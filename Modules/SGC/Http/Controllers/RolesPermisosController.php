<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\SGC\Http\Requests\Permiso\PermisoSGCRequest;
use Modules\SGC\Http\Requests\Permiso\AsignarPermisoSGCRequest;
use Modules\SGC\Models\Bitacora;

class RolesPermisosController extends Controller
{
    private const MODULO = 'SGC';

    /**
     * Vista principal: catálogo de roles institucional,
     * permisos del SGC categorizados y matriz de asignación interactiva.
     */
    public function index()
    {
        // Ordenar roles de forma jerárquica (Admin primero, luego Resp. Calidad, Líder de Área)
        $roles = Rol::orderByRaw("
            CASE 
                WHEN id = 1 OR slug = 'admin' THEN 1
                WHEN id = 2 OR slug = 'resp_calidad' THEN 2
                WHEN id = 3 OR slug = 'lider_area' THEN 3
                ELSE 4
            END
        ")->orderBy('nombre')->get();

        $permisos = Permiso::deModulo(self::MODULO)->orderBy('accion')->get();

        $asignaciones = DB::table('rol_permisos')
            ->join('permisos', 'permisos.id', '=', 'rol_permisos.permiso_id')
            ->where('permisos.modulo', self::MODULO)
            ->select('rol_permisos.rol_id', 'rol_permisos.permiso_id')
            ->get();

        return view('sgc::Admin.Roles-Permisos.index', compact('roles', 'permisos', 'asignaciones'));
    }

    /** Crear un permiso nuevo para el módulo SGC */
    public function storePermiso(PermisoSGCRequest $request)
    {
        $permiso = Permiso::create(array_merge($request->validated(), ['modulo' => self::MODULO]));

        Bitacora::registrar(
            'Creación',
            "Creó nuevo permiso '{$permiso->accion}' en SGC.",
            'permisos',
            $permiso->id,
            null,
            $permiso->toArray(),
            'exitoso',
            'Roles y Permisos'
        );

        return back()->with('success', "Permiso '{$permiso->accion}' creado correctamente para el SGC.");
    }

    /** Editar descripción o metadatos de un permiso */
    public function updatePermiso(PermisoSGCRequest $request, int $permisoId)
    {
        $permiso = Permiso::deModulo(self::MODULO)->findOrFail($permisoId);
        $prev = $permiso->toArray();
        $permiso->update($request->validated());

        Bitacora::registrar(
            'Modificación',
            "Actualizó el permiso '{$permiso->accion}'.",
            'permisos',
            $permiso->id,
            $prev,
            $permiso->toArray(),
            'exitoso',
            'Roles y Permisos'
        );

        return back()->with('success', 'Permiso actualizado.');
    }

    /** Eliminar un permiso del SGC */
    public function destroyPermiso(int $permisoId)
    {
        $permiso = Permiso::deModulo(self::MODULO)->findOrFail($permisoId);
        $accion = $permiso->accion;

        // Limpiar asignaciones previas
        DB::table('rol_permisos')->where('permiso_id', $permiso->id)->delete();
        $permiso->delete();

        Bitacora::registrar(
            'Eliminación',
            "Eliminó el permiso '{$accion}' del SGC.",
            'permisos',
            $permisoId,
            null,
            null,
            'exitoso',
            'Roles y Permisos'
        );

        return back()->with('success', "Permiso '{$accion}' eliminado correctamente.");
    }

    /**
     * Asignar un permiso de SGC a un rol.
     * Soporta peticiones web estándar y AJAX en tiempo real.
     */
    public function asignar(AsignarPermisoSGCRequest $request)
    {
        $permiso = Permiso::deModulo(self::MODULO)->findOrFail($request->permiso_id);
        $rol = Rol::findOrFail($request->rol_id);

        DB::table('rol_permisos')->updateOrInsert([
            'rol_id' => $request->rol_id,
            'permiso_id' => $permiso->id,
        ]);

        Bitacora::registrar(
            'Modificación',
            "Asignó el permiso '{$permiso->accion}' al rol '{$rol->nombre}'.",
            'rol_permisos',
            $request->rol_id,
            null,
            ['rol_id' => $request->rol_id, 'permiso_id' => $permiso->id],
            'exitoso',
            'Roles y Permisos'
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'assigned' => true,
                'message' => "Permiso '{$permiso->accion}' asignado a '{$rol->nombre}'.",
                'rol' => $rol->nombre,
                'permiso' => $permiso->accion
            ]);
        }

        return back()->with('success', "Permiso '{$permiso->accion}' asignado al rol {$rol->nombre}.");
    }

    /**
     * Quitar un permiso de SGC de un rol.
     * Soporta peticiones web estándar y AJAX en tiempo real.
     */
    public function quitar(AsignarPermisoSGCRequest $request)
    {
        $permiso = Permiso::deModulo(self::MODULO)->findOrFail($request->permiso_id);
        $rol = Rol::findOrFail($request->rol_id);

        DB::table('rol_permisos')
            ->where('rol_id', $request->rol_id)
            ->where('permiso_id', $permiso->id)
            ->delete();

        Bitacora::registrar(
            'Modificación',
            "Retiró el permiso '{$permiso->accion}' del rol '{$rol->nombre}'.",
            'rol_permisos',
            $request->rol_id,
            null,
            null,
            'exitoso',
            'Roles y Permisos'
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'assigned' => false,
                'message' => "Permiso '{$permiso->accion}' revocado de '{$rol->nombre}'.",
                'rol' => $rol->nombre,
                'permiso' => $permiso->accion
            ]);
        }

        return back()->with('success', "Permiso '{$permiso->accion}' retirado del rol {$rol->nombre}.");
    }

    /** Vista de usuarios que tienen acceso efectivo a SGC */
    public function usuariosPorRol()
    {
        $usuarios = User::with('rol')
            ->whereHas('rol.permisos', fn($q) => $q->where('modulo', self::MODULO))
            ->orderBy('nombre_completo')
            ->paginate(15);

        return view('sgc::Admin.Roles-Permisos.usuarios', compact('usuarios'));
    }
}