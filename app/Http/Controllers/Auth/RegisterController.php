<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Muestra la vista de registro del ERP.
     */
    public function showRegistrationForm(Request $request)
    {
        if (Auth::check()) {
            $redirect = $request->query('redirect', route('home'));
            return redirect($redirect)->with('info', 'Ya has iniciado sesión como ' . Auth::user()->full_name);
        }

        $redirect = $request->query('redirect', '');
        return view('register', compact('redirect'));
    }

    /**
     * Maneja el registro de nuevos usuarios en el sistema ERP.
     * Todo nuevo usuario registrado públicamente queda con el rol institucional por defecto.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:120',
            'nombre_usuario' => 'required|string|min:3|max:60|unique:usuarios,nombre_usuario|regex:/^[a-zA-Z0-9._-]+$/',
            'correo' => 'required|string|email|max:120|unique:usuarios,correo',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.max' => 'El nombre completo no debe exceder 120 caracteres.',
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.min' => 'El nombre de usuario debe tener al menos 3 caracteres.',
            'nombre_usuario.max' => 'El nombre de usuario no debe exceder 60 caracteres.',
            'nombre_usuario.unique' => 'Este nombre de usuario ya se encuentra registrado.',
            'nombre_usuario.regex' => 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debes ingresar un correo electrónico válido.',
            'correo.max' => 'El correo electrónico no debe exceder 120 caracteres.',
            'correo.unique' => 'Este correo electrónico ya está registrado en el sistema.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        // Asignar el rol institucional por defecto ('lider_area')
        $defaultRol = Rol::where('slug', 'lider_area')->first() ?? Rol::where('id', 3)->first();
        $rolId = $defaultRol ? $defaultRol->id : 3;

        // Crear el nuevo usuario
        $user = User::create([
            'nombre_completo' => trim($request->input('nombre_completo')),
            'nombre_usuario' => trim($request->input('nombre_usuario')),
            'correo' => strtolower(trim($request->input('correo'))),
            'rol_id' => $rolId,
            'password_hash' => Hash::make($request->input('password')),
            'activo' => 1,
            'intentos_fallidos' => 0,
        ]);

        // Iniciar sesión automáticamente tras el registro
        Auth::login($user);
        $request->session()->regenerate();

        // Manejo inteligente de redirección
        $redirectUrl = $request->input('redirect');
        if (!empty($redirectUrl) && (str_starts_with($redirectUrl, '/') || str_starts_with($redirectUrl, url('/')))) {
            if (str_contains($redirectUrl, 'sgc') || str_contains($redirectUrl, 'dashboard')) {
                return redirect()->route('sgc.dashboard')->with('success', '¡Cuenta creada con éxito! Bienvenido(a), ' . $user->full_name);
            }
            return redirect($redirectUrl)->with('success', '¡Cuenta creada con éxito! Bienvenido(a), ' . $user->full_name);
        }

        return redirect()->route('sgc.dashboard')->with('success', '¡Cuenta creada con éxito! Bienvenido(a), ' . $user->full_name);
    }
}

