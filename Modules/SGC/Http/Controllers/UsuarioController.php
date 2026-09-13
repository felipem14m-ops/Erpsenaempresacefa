<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\SGC\Http\Requests\Usuario\StoreUsuarioRequest;
use Modules\SGC\Http\Requests\Usuario\UpdateUsuarioRequest;

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
     * Guarda un nuevo usuario en el SGC utilizando StoreUsuarioRequest.
     */
    public function store(StoreUsuarioRequest $request)
    {
        $data = $request->validated();
        $data['password_hash'] = Hash::make($request->password);
        $data['activo'] = $request->boolean('activo', true);
        unset($data['password']);

        User::create($data);

        return redirect()->back()->with('success', 'Usuario registrado exitosamente en el módulo SGC.');
    }

    /**
     * Actualiza la información de un usuario existente utilizando UpdateUsuarioRequest.
     */
    public function update(UpdateUsuarioRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password_hash'] = Hash::make($request->password);
        }
        unset($data['password']);

        $data['activo'] = $request->boolean('activo');

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
