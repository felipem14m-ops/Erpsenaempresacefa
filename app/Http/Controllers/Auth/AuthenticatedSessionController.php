<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Umbral máximo de intentos fallidos antes de bloquear temporalmente la cuenta.
     */
    public const MAX_INTENTOS_FALLIDOS = 5;

    /**
     * Duración del bloqueo temporal en minutos.
     */
    public const MINUTOS_BLOQUEO = 15;

    /**
     * Muestra la vista de inicio de sesión del ERP.
     */
    public function create(Request $request)
    {
        if (Auth::check()) {
            $redirect = $request->query('redirect', route('home'));
            return redirect($redirect)->with('info', 'Ya has iniciado sesión como ' . Auth::user()->full_name);
        }

        $redirect = $request->query('redirect', '');
        return view('login', compact('redirect'));
    }

    /**
     * Procesa la autenticación del usuario, controlando fuerza bruta y auditoría.
     */
    public function store(Request $request)
    {
        $loginField = $request->has('correo') ? 'correo' : 'email';

        $request->validate([
            $loginField => 'required|string',
            'password'  => 'required|string',
        ], [
            "{$loginField}.required" => 'Debes ingresar tu correo electrónico o nombre de usuario.',
            'password.required'      => 'Debes ingresar tu contraseña.',
        ]);

        $loginInput = trim((string) $request->input($loginField));
        $password   = (string) $request->input('password');
        $remember   = $request->boolean('remember');

        // Buscar usuario por correo electrónico o por nombre_usuario
        $user = User::where('correo', strtolower($loginInput))
            ->orWhere('nombre_usuario', $loginInput)
            ->first();

        // 1. Verificación de bloqueo por intentos fallidos
        if ($user && $user->bloqueado_hasta && now()->lessThan($user->bloqueado_hasta)) {
            $minutosRestantes = (int) ceil(now()->diffInSeconds($user->bloqueado_hasta) / 60);

            Bitacora::registrar(
                modulo: 'core',
                accion: 'login_bloqueado',
                descripcion: "Intento de acceso a cuenta bloqueada temporalmente: '{$user->nombre_usuario}'",
                opciones: [
                    'usuario_id' => $user->id,
                    'resultado'  => 'fallido',
                ]
            );

            return back()
                ->withInput($request->only('correo', 'remember', 'redirect'))
                ->withErrors([
                    'correo' => "Tu cuenta está temporalmente bloqueada por seguridad debido a múltiples intentos fallidos. Intenta nuevamente en {$minutosRestantes} minuto(s).",
                ]);
        }

        // 2. Verificación de credenciales exitosa
        if ($user && Hash::check($password, $user->password_hash)) {
            // Validar si la cuenta está activa
            if (!$user->activo) {
                Bitacora::registrar(
                    modulo: 'core',
                    accion: 'login_inactivo',
                    descripcion: "Intento de acceso a cuenta desactivada: '{$user->nombre_usuario}'",
                    opciones: [
                        'usuario_id' => $user->id,
                        'resultado'  => 'fallido',
                    ]
                );

                return back()
                    ->withInput($request->only('correo', 'remember', 'redirect'))
                    ->withErrors([
                        'correo' => 'Tu cuenta se encuentra desactivada en el sistema. Contacta al administrador institucional.',
                    ]);
            }

            // Restablecer contadores y actualizar último acceso
            $user->intentos_fallidos = 0;
            $user->bloqueado_hasta   = null;
            $user->ultimo_acceso     = now();
            $user->save();

            // Iniciar sesión
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Auditoría de login exitoso en bitácora
            Bitacora::registrar(
                modulo: 'core',
                accion: 'login_exitoso',
                descripcion: "Inicio de sesión exitoso del usuario '{$user->nombre_usuario}'",
                opciones: [
                    'usuario_id' => $user->id,
                    'resultado'  => 'exitoso',
                ]
            );

            // Redirección inteligente
            $redirectUrl = $request->input('redirect');
            if (!empty($redirectUrl) && (str_starts_with($redirectUrl, '/') || str_starts_with($redirectUrl, url('/')))) {
                if (str_contains($redirectUrl, 'sgc') || str_contains($redirectUrl, 'dashboard')) {
                    return redirect()->route('sgc.dashboard')->with('success', '¡Bienvenido(a), ' . $user->full_name . '!');
                }
                return redirect($redirectUrl)->with('success', '¡Bienvenido(a), ' . $user->full_name . '!');
            }

            return redirect()->route('sgc.dashboard')->with('success', '¡Bienvenido(a), ' . $user->full_name . '!');
        }

        // 3. Credenciales incorrectas: incremento de intentos y posible bloqueo
        if ($user) {
            $user->intentos_fallidos += 1;
            $accion = 'login_fallido';
            $mensajeBitacora = "Contraseña incorrecta para el usuario '{$user->nombre_usuario}' (Intento {$user->intentos_fallidos}/" . self::MAX_INTENTOS_FALLIDOS . ")";

            if ($user->intentos_fallidos >= self::MAX_INTENTOS_FALLIDOS) {
                $user->bloqueado_hasta = now()->addMinutes(self::MINUTOS_BLOQUEO);
                $accion = 'login_bloqueado';
                $mensajeBitacora = "Cuenta '{$user->nombre_usuario}' bloqueada por {$user->intentos_fallidos} intentos fallidos consecutivos.";
            }

            $user->save();

            Bitacora::registrar(
                modulo: 'core',
                accion: $accion,
                descripcion: $mensajeBitacora,
                opciones: [
                    'usuario_id' => $user->id,
                    'resultado'  => 'fallido',
                ]
            );
        } else {
            Bitacora::registrar(
                modulo: 'core',
                accion: 'login_fallido',
                descripcion: "Intento de inicio de sesión con identificador no existente: '{$loginInput}'",
                opciones: [
                    'resultado' => 'fallido',
                ]
            );
        }

        return back()
            ->withInput($request->only('correo', 'remember', 'redirect'))
            ->withErrors([
                'correo' => 'Las credenciales ingresadas no coinciden con nuestros registros.',
            ]);
    }

    /**
     * Cierra la sesión activa y audita el evento en bitácora.
     */
    public function destroy(Request $request)
    {
        $usuario = Auth::user();

        if ($usuario) {
            Bitacora::registrar(
                modulo: 'core',
                accion: 'logout',
                descripcion: "Cierre de sesión del usuario '{$usuario->nombre_usuario}'",
                opciones: [
                    'usuario_id' => $usuario->id,
                    'resultado'  => 'exitoso',
                ]
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectUrl = $request->input('redirect', $request->query('redirect', ''));
        if (!empty($redirectUrl) && (str_starts_with($redirectUrl, '/') || str_starts_with($redirectUrl, url('/')))) {
            return redirect($redirectUrl)->with('info', 'Has cerrado sesión exitosamente.');
        }

        return redirect()->route('login')->with('info', 'Has cerrado sesión exitosamente.');
    }
}
