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

            // 4. Denegar acceso para peticiones AJAX o JSON
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Acceso denegado: Tu rol ({$rolNombre}) no cuenta con los permisos necesarios para realizar esta acción en el módulo {$modulo}.",
                ], Response::HTTP_FORBIDDEN);
            }

            // 5. Redirección amigable con alerta de bloqueo para peticiones Web
            $mensajeError = "Acceso Denegado: Tu rol ({$rolNombre}) no cuenta con los permisos necesarios para acceder a esta sección del {$modulo}.";

            // Si el usuario tiene acceso básico al módulo pero no a la acción específica, redirigir al Dashboard del módulo
            if ($usuario->tieneAccesoModulo($modulo)) {
                $dashboardRoute = match (strtoupper($modulo)) {
                    'SGC' => 'sgc.dashboard',
                    'SST' => 'sst.dashboard',
                    default => 'welcome'
                };

                if (\Illuminate\Support\Facades\Route::has($dashboardRoute) && !$request->routeIs($dashboardRoute)) {
                    return redirect()->route($dashboardRoute)->with('error', $mensajeError);
                }
            }

            // Si no tiene acceso al módulo o ya está en el dashboard, redirigir al inicio general
            return redirect()->route('welcome')->with('error', $mensajeError);
        }

        return $next($request);
    }
}
