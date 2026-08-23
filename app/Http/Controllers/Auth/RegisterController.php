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
     * Muestra la vista de registro.
     */
    public function showRegistrationForm(Request $request)
    {
        $redirect = $request->query('redirect', '');
        return view('register', compact('redirect'));
    }

    /**
     * Procesa la solicitud de registro.
     * Todo nuevo usuario registrado públicamente queda con el rol "Consultante".
     */
    public function register(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Se asigna automáticamente el rol Consultante (ID 4 o por slug)
        $consultanteRol = Rol::where('slug', 'consultante')->first();
        $rolId = $consultanteRol ? $consultanteRol->id : 4;

        $user = User::create([
            'nombre_completo' => $request->nombre_completo,
            'nombre_usuario' => $request->nombre_usuario,
            'correo' => $request->correo,
            'rol_id' => $rolId,
            'password_hash' => Hash::make($request->password),
            'activo' => true,
        ]);

        Auth::login($user);

        $redirectUrl = $request->input('redirect');
        if (!empty($redirectUrl) && (str_starts_with($redirectUrl, '/') || str_starts_with($redirectUrl, url('/')))) {
            if (str_contains($redirectUrl, 'sgc') || str_contains($redirectUrl, 'dashboard')) {
                return redirect()->route('sgc.dashboard')->with('success', '¡Registro exitoso! Bienvenido(a) ' . $user->full_name);
            }
            return redirect($redirectUrl)->with('success', '¡Registro exitoso! Bienvenido(a) ' . $user->full_name);
        }

        return redirect()->route('sgc.dashboard')->with('success', '¡Registro exitoso! Bienvenido(a) ' . $user->full_name);
    }
}
