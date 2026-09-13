<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Bitacora;

class VerificarAccesoModulo
{
    /**
     * Maneja una solicitud entrante y verifica los permisos del usuario para el módulo.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $modulo Nombre del módulo (SGC, SST, Control_ECP, SIGE, SISGEDI, Apicola, SISIG, core)
     * @param  string|null  $accion Acción específica requerida dentro del módulo (opcional)
     */
    public function handle(Request $request, Closure $next, string $modulo, ?string $accion = null): Response
    {
        // 1. Verificar autenticación
        if (!Auth::check()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Debes iniciar sesión para acceder a este recurso.',
                ], Response::HTTP_UNAUTHORIZED);
            }

            return redirect()->route('login', ['redirect' => $request->getRequestUri()])
                ->with('warning', 'Debes iniciar sesión para acceder al módulo solicitado.');
        }

        $usuario = Auth::user();

        // 2. Verificar autorización mediante el rol y permisos asociados
        if (!$usuario->tieneAccesoModulo($modulo, $accion)) {
            $rolNombre = $usuario->rol ? $usuario->rol->nombre : 'Sin Rol';
            $detalleAccion = $accion ? " (acción: '{$accion}')" : '';
            $descripcionFallo = "Acceso no autorizado: El usuario '{$usuario->nombre_usuario}' con rol '{$rolNombre}' intentó acceder al módulo '{$modulo}'{$detalleAccion} sin permisos suficientes.";

            // 3. Registrar acceso denegado en la bitácora institucional
            Bitacora::registrar(
                modulo: $modulo,
                accion: $accion ?? 'acceso_denegado',
                descripcion: $descripcionFallo,
                opciones: [
                    'usuario_id' => $usuario->id,
                    'resultado'  => 'fallido',
                    'entidad'    => 'modulo',
                    'entidad_id' => null,
                ]
            );

            // 4. Denegar acceso con 403 Forbidden
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Acceso denegado: No cuentas con permisos para acceder al módulo {$modulo}{$detalleAccion}.",
                ], Response::HTTP_FORBIDDEN);
            }

            abort(Response::HTTP_FORBIDDEN, "Acceso restringido: Tu rol ({$rolNombre}) no cuenta con permisos autorizados para el módulo {$modulo}.");
        }

        return $next($request);
    }
}
