<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios (index).
     */
    public function index()
    {
        $users = User::with('rol')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario (create).
     */
    public function create()
    {
        $roles = Rol::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Guarda un nuevo usuario en la base de datos (store).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'nombre_completo' => $request->nombre_completo,
            'nombre_usuario' => $request->nombre_usuario,
            'correo' => $request->correo,
            'password_hash' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'activo' => true,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente (edit).
     */
    public function edit(User $user)
    {
        $roles = Rol::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza los datos de un usuario en la base de datos (update).
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario,' . $user->id,
            'correo' => 'required|string|email|max:255|unique:usuarios,correo,' . $user->id,
            'rol_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'nombre_completo' => $request->nombre_completo,
            'nombre_usuario' => $request->nombre_usuario,
            'correo' => $request->correo,
            'rol_id' => $request->rol_id,
            'activo' => $request->has('activo') ? true : false,
        ];

        // Solo actualizar la contraseña si se ingresó una nueva
        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario de la base de datos (destroy).
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
