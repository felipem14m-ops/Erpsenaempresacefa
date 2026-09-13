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
    public function index(Request $request)
    {
        $search = $request->query('search');
        $rolId = $request->query('rol_id');

        $query = User::with('rol')->orderBy('id', 'desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre_completo', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_usuario', 'LIKE', "%{$search}%")
                    ->orWhere('correo', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($rolId) && $rolId !== 'all') {
            $query->where('rol_id', $rolId);
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Rol::orderBy('id')->get();

        if (view()->exists('users.index')) {
            return view('users.index', compact('users', 'roles', 'search', 'rolId'));
        }

        if (view()->exists('admin.usuarios.index')) {
            return view('admin.usuarios.index', compact('users', 'roles', 'search', 'rolId'));
        }

        return redirect()->route('home')->with('info', 'Listado de usuarios.');
    }

    /**
     * Muestra el formulario para crear un nuevo usuario (create).
     */
    public function create()
    {
        $roles = Rol::all();
        if (view()->exists('users.create')) {
            return view('users.create', compact('roles'));
        }
        return redirect()->route('home');
    }

    /**
     * Guarda un nuevo usuario en la base de datos (store).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'correo' => 'required|string|email|max:255|unique:usuarios,correo',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ], [
            'nombre_usuario.unique' => 'El nombre de usuario ya está en uso.',
            'correo.unique' => 'El correo electrónico ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        User::create([
            'nombre_completo' => $request->nombre_completo,
            'nombre_usuario' => $request->nombre_usuario,
            'correo' => $request->correo,
            'password_hash' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'activo' => $request->boolean('activo', true),
        ]);

        return redirect()->back()->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente (edit).
     */
    public function edit(User $user)
    {
        $roles = Rol::all();
        if (view()->exists('users.edit')) {
            return view('users.edit', compact('user', 'roles'));
        }
        return redirect()->route('home');
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
            'activo' => $request->has('activo') ? $request->boolean('activo') : $user->activo,
        ];

        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Alterna el estado activo/inactivo del usuario.
     */
    public function toggleStatus(User $user)
    {
        $user->activo = !$user->activo;
        $user->save();

        $estado = $user->activo ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "El usuario {$user->full_name} ha sido {$estado}.");
    }

    /**
     * Elimina un usuario de la base de datos (destroy).
     */
    public function destroy(User $user)
    {
        $name = $user->full_name;
        $user->delete();

        return redirect()->back()->with('success', "Usuario '{$name}' eliminado correctamente.");
    }
}
