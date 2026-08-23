<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Muestra el listado de usuarios con filtros de búsqueda y rol.
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

        if (view()->exists('sgc::Admin.Usuarios.Dashboard')) {
            return view('sgc::Admin.Usuarios.Dashboard', compact('users', 'roles', 'search', 'rolId'));
        }

        return view('sgc::Admin.Users.index', compact('users', 'roles', 'search', 'rolId'));
    }

    /**
     * Guarda un nuevo usuario creado desde el módulo SGC.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'correo' => 'required|string|email|max:255|unique:usuarios,correo',
            'rol_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8',
        ], [
            'nombre_usuario.unique' => 'El nombre de usuario ya está en uso.',
            'correo.unique' => 'El correo electrónico ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        User::create([
            'nombre_completo' => $request->nombre_completo,
            'nombre_usuario' => $request->nombre_usuario,
            'correo' => $request->correo,
            'rol_id' => $request->rol_id,
            'password_hash' => Hash::make($request->password),
            'activo' => $request->has('activo') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Usuario registrado exitosamente en el módulo SGC.');
    }

    /**
     * Actualiza la información de un usuario existente.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario,' . $user->id,
            'correo' => 'required|string|email|max:255|unique:usuarios,correo,' . $user->id,
            'rol_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'nombre_completo' => $request->nombre_completo,
            'nombre_usuario' => $request->nombre_usuario,
            'correo' => $request->correo,
            'rol_id' => $request->rol_id,
            'activo' => $request->has('activo') ? true : false,
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
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->activo = !$user->activo;
        $user->save();

        $estado = $user->activo ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "El usuario {$user->full_name} ha sido {$estado}.");
    }

    /**
     * Elimina un usuario del sistema.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->full_name;
        $user->delete();

        return redirect()->back()->with('success', "Usuario '{$name}' eliminado correctamente.");
    }
}
