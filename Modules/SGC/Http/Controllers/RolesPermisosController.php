<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\SGC\Http\Requests\Permiso\PermisoSGCRequest;
use Modules\SGC\Http\Requests\Permiso\AsignarPermisoSGCRequest;
use Modules\SGC\Models\Bitacora;

class RolesPermisosController extends Controller
{
    private const MODULO = 'SGC';

    /**
     * Vista principal: catálogo de roles (solo lectura),
     * permisos de SGC, y la matriz rol↔permiso ya asignada.
     */
    public function index()
    {
        $roles = Rol::orderBy('nombre')->get(); // lectura global, sin editar

        $permisos = Permiso::deModulo(self::MODULO)->orderBy('accion')->get();

        $asignaciones = DB::table('rol_permisos')
            ->join('permisos', 'permisos.id', '=', 'rol_permisos.permiso_id')
            ->where('permisos.modulo', self::MODULO)
            ->select('rol_permisos.rol_id', 'rol_permisos.permiso_id')
            ->get();

        return view('sgc::Admin.Roles-Permisos.index', compact('roles', 'permisos', 'asignaciones'));
    }

    /** Crear un permiso nuevo, forzado a modulo=SGC */
    public function storePermiso(PermisoSGCRequest $request)
    {
        $permiso = Permiso::create($request->validated());

        Bitacora::registrar(
            'Creación',
            "Creó nuevo permiso '{$permiso->nombre}' ({$permiso->accion}) en SGC.",
            'permisos',
            $permiso->id,
            null,
            $permiso->toArray(),
            'exitoso',
            'Roles y Permisos'
        );

        return back()->with('success', 'Permiso de SGC creado correctamente.');
    }

    /** Editar un permiso — con barrera de seguridad por módulo */
    public function updatePermiso(PermisoSGCRequest $request, int $permisoId)
    {
        $permiso = Permiso::deModulo(self::MODULO)->findOrFail($permisoId);
        $prev = $permiso->toArray();
        $permiso->update($request->validated());

        Bitacora::registrar(
            'Modificación',
            "Actualizó el permiso '{$permiso->nombre}'.",
            'permisos',
            $permiso->id,
            $prev,
            $permiso->toArray(),
            'exitoso',
            'Roles y Permisos'
        );

        return back()->with('success', 'Permiso actualizado.');
    }

    /** Eliminar un permiso — misma barrera */
    public function destroyPermiso(int $permisoId)
    {
        $permiso = Permiso::deModulo(self::MODULO)->findOrFail($permisoId);
        $nombre = $permiso->nombre;

        // Evita romper rol_permisos existentes sin querer
        DB::table('rol_permisos')->where('permiso_id', $permiso->id)->delete();
        $permiso->delete();

        Bitacora::registrar(
            'Eliminación',
            "Eliminó el permiso '{$nombre}' del SGC.",
            'permisos',
            $permisoId,
            null,
            null,
            'exitoso',
            'Roles y Permisos'
        );

        return back()->with('success', 'Permiso eliminado.');
    }

    /**
     * Asignar un permiso de SGC a un rol.
     * firstOrFail() es la barrera real: si alguien manipula el permiso_id
     * en la petición para apuntar a otro módulo, esto responde 404.
     */
    public function asignar(AsignarPermisoSGCRequest $request)
    {
        $permiso = Permiso::deModulo(self::MODULO)->findOrFail($request->permiso_id);
        $rol = Rol::find($request->rol_id);

        DB::table('rol_permisos')->updateOrInsert([
            'rol_id' => $request->rol_id,
            'permiso_id' => $permiso->id,
        ]);

        Bitacora::registrar(
            'Modificación',
            "Asignó el permiso '{$permiso->nombre}' al rol '{$rol->nombre}'.",
            'rol_permisos',
            $request->rol_id,
            null,
            ['rol_id' => $request->rol_id, 'permiso_id' => $permiso->id],
            'exitoso',
            'Roles y Permisos'
        );

        return back()->with('success', 'Permiso asignado al rol.');
    }

    /** Quitar un permiso de SGC de un rol */
    public function quitar(AsignarPermisoSGCRequest $request)
    {
        $permiso = Permiso::deModulo(self::MODULO)->findOrFail($request->permiso_id);
        $rol = Rol::find($request->rol_id);

        DB::table('rol_permisos')
            ->where('rol_id', $request->rol_id)
            ->where('permiso_id', $permiso->id)
            ->delete();

        Bitacora::registrar(
            'Modificación',
            "Retiró el permiso '{$permiso->nombre}' del rol '{$rol->nombre}'.",
            'rol_permisos',
            $request->rol_id,
            null,
            null,
            'exitoso',
            'Roles y Permisos'
        );

        return back()->with('success', 'Permiso retirado del rol.');
    }

    /** Solo lectura: qué usuarios tienen hoy acceso efectivo a SGC, por rol */
    public function usuariosPorRol()
    {
        $usuarios = User::with('rol')
            ->whereHas('rol.permisos', fn($q) => $q->where('modulo', self::MODULO))
            ->orderBy('nombre_completo')
            ->paginate(10);

        return view('sgc::Admin.Roles-Permisos.usuarios', compact('usuarios'));
    }
}