<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SGC\Models\Bitacora;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TrazabilidadController extends Controller
{
    /**
     * Muestra el panel y listado principal de la Bitácora de Trazabilidad Documental.
     */
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));
        $accion = $request->get('accion', 'all');
        $usuario = $request->get('usuario', 'all');
        $fecha = $request->get('fecha', '');

        $query = Bitacora::with(['usuario.rol'])
            ->orderBy('registrado_en', 'desc')
            ->orderBy('id', 'desc');

        // 1. Filtro por término de búsqueda global
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%")
                    ->orWhere('modulo', 'LIKE', "%{$search}%")
                    ->orWhere('accion', 'LIKE', "%{$search}%")
                    ->orWhere('entidad', 'LIKE', "%{$search}%")
                    ->orWhere('ip_address', 'LIKE', "%{$search}%")
                    ->orWhereHas('usuario', function ($u) use ($search) {
                        $u->where('nombre_completo', 'LIKE', "%{$search}%")
                            ->orWhere('nombre_usuario', 'LIKE', "%{$search}%")
                            ->orWhere('correo', 'LIKE', "%{$search}%");
                    });
            });
        }

        // 2. Filtro por Tipo de Acción
        if (!empty($accion) && $accion !== 'all' && $accion !== 'Todas') {
            $query->where(function ($q) use ($accion) {
                $q->where('accion', 'LIKE', "%{$accion}%");
                // Mapeos comunes de equivalencia
                if ($accion === 'Aprobación') {
                    $q->orWhere('accion', 'LIKE', '%aprobar%')->orWhere('accion', 'LIKE', '%aprobado%');
                } elseif ($accion === 'Rechazo') {
                    $q->orWhere('accion', 'LIKE', '%rechazar%')->orWhere('accion', 'LIKE', '%rechazado%');
                } elseif ($accion === 'Creación') {
                    $q->orWhere('accion', 'LIKE', '%crear%')->orWhere('accion', 'LIKE', '%radicar%')->orWhere('accion', 'LIKE', '%subir%');
                } elseif ($accion === 'Modificación') {
                    $q->orWhere('accion', 'LIKE', '%editar%')->orWhere('accion', 'LIKE', '%actualizar%')->orWhere('accion', 'LIKE', '%cambiar%');
                } elseif ($accion === 'Descarga') {
                    $q->orWhere('accion', 'LIKE', '%descargar%')->orWhere('accion', 'LIKE', '%download%');
                } elseif ($accion === 'Eliminación') {
                    $q->orWhere('accion', 'LIKE', '%eliminar%')->orWhere('accion', 'LIKE', '%borrar%');
                } elseif ($accion === 'Consulta') {
                    $q->orWhere('accion', 'LIKE', '%consultar%')->orWhere('accion', 'LIKE', '%ver%');
                }
            });
        }

        // 3. Filtro por Usuario
        if (!empty($usuario) && $usuario !== 'all' && $usuario !== 'Todos') {
            if (is_numeric($usuario)) {
                $query->where('usuario_id', $usuario);
            } elseif ($usuario === 'sistema' || $usuario === 'Sistema SGC') {
                $query->whereNull('usuario_id');
            } else {
                $query->whereHas('usuario', function ($u) use ($usuario) {
                    $u->where('nombre_completo', 'LIKE', "%{$usuario}%")
                        ->orWhere('nombre_usuario', 'LIKE', "%{$usuario}%");
                });
            }
        }

        // 4. Filtro por Fecha
        if (!empty($fecha)) {
            if ($fecha === 'hoy') {
                $query->whereDate('registrado_en', Carbon::today());
            } else {
                try {
                    $parsedDate = Carbon::parse($fecha)->format('Y-m-d');
                    $query->whereDate('registrado_en', $parsedDate);
                } catch (\Exception $e) {
                    // Si el formato no es parseable se omite
                }
            }
        }

        // Paginación real de 10 registros por página
        $bitacoras = $query->paginate(10)->withQueryString();

        // Lista de usuarios registrados activos para el selector
        $usuariosList = User::where('activo', 1)
            ->orderBy('nombre_completo', 'asc')
            ->get(['id', 'nombre_completo', 'nombre_usuario']);

        // Lista de acciones estándar de calidad para el selector
        $accionesList = [
            'Todas',
            'Aprobación',
            'Consulta',
            'Modificación',
            'Rechazo',
            'Creación',
            'Descarga',
            'Eliminación'
        ];

        return view('sgc::Admin.Trazabilidad.index', compact(
            'bitacoras',
            'search',
            'accion',
            'usuario',
            'fecha',
            'usuariosList',
            'accionesList'
        ));
    }

    /**
     * Exporta los registros filtrados de la bitácora a formato CSV estructurado para Excel.
     */
    public function export(Request $request): StreamedResponse
    {
        $search = trim($request->get('search', ''));
        $accion = $request->get('accion', 'all');
        $usuario = $request->get('usuario', 'all');
        $fecha = $request->get('fecha', '');

        $query = Bitacora::with(['usuario.rol'])
            ->orderBy('registrado_en', 'desc')
            ->orderBy('id', 'desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%")
                    ->orWhere('modulo', 'LIKE', "%{$search}%")
                    ->orWhere('accion', 'LIKE', "%{$search}%")
                    ->orWhere('entidad', 'LIKE', "%{$search}%")
                    ->orWhere('ip_address', 'LIKE', "%{$search}%")
                    ->orWhereHas('usuario', function ($u) use ($search) {
                        $u->where('nombre_completo', 'LIKE', "%{$search}%")
                            ->orWhere('nombre_usuario', 'LIKE', "%{$search}%")
                            ->orWhere('correo', 'LIKE', "%{$search}%");
                    });
            });
        }

        if (!empty($accion) && $accion !== 'all' && $accion !== 'Todas') {
            $query->where('accion', 'LIKE', "%{$accion}%");
        }

        if (!empty($usuario) && $usuario !== 'all' && $usuario !== 'Todos') {
            if (is_numeric($usuario)) {
                $query->where('usuario_id', $usuario);
            } elseif ($usuario === 'sistema' || $usuario === 'Sistema SGC') {
                $query->whereNull('usuario_id');
            } else {
                $query->whereHas('usuario', function ($u) use ($usuario) {
                    $u->where('nombre_completo', 'LIKE', "%{$usuario}%")
                        ->orWhere('nombre_usuario', 'LIKE', "%{$usuario}%");
                });
            }
        }

        if (!empty($fecha)) {
            if ($fecha === 'hoy') {
                $query->whereDate('registrado_en', Carbon::today());
            } else {
                try {
                    $parsedDate = Carbon::parse($fecha)->format('Y-m-d');
                    $query->whereDate('registrado_en', $parsedDate);
                } catch (\Exception $e) {}
            }
        }

        $filename = 'SGC_Bitacora_Trazabilidad_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($query) {
            $file = fopen('php://output', 'w');
            
            // Inyectar BOM UTF-8 para apertura directa y limpia en Microsoft Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Encabezado institucional
            fputcsv($file, ['SENA - CENTRO DE FORMACIÓN AGROINDUSTRIAL LA ANGOSTURA']);
            fputcsv($file, ['SISTEMA DE GESTIÓN DE CALIDAD (SGC) - BITÁCORA DE TRAZABILIDAD DOCUMENTAL']);
            fputcsv($file, ['Generado el:', date('d/m/Y H:i:s'), 'Total Registros:', $query->count()]);
            fputcsv($file, []);

            // Encabezados de columnas
            fputcsv($file, [
                'ID',
                'Fecha y Hora',
                'Usuario',
                'Rol Institucional',
                'Acción',
                'Módulo Afectado',
                'Entidad',
                'ID Entidad',
                'Detalle de la Operación',
                'Resultado',
                'Dirección IP',
                'Navegador / User Agent'
            ]);

            $query->chunk(200, function ($registros) use ($file) {
                foreach ($registros as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->registrado_en ? $row->registrado_en->format('d/m/Y H:i:s') : 'N/A',
                        $row->usuario_nombre,
                        $row->usuario_rol,
                        $row->accion_normalizada,
                        $row->modulo ?? 'SGC',
                        $row->entidad ?? 'General',
                        $row->entidad_id ?? 'N/A',
                        $row->descripcion,
                        ucfirst($row->resultado ?? 'exitoso'),
                        $row->ip_address ?? '127.0.0.1',
                        $row->user_agent ?? 'N/A'
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Retorna la información detallada de una fila de auditoría para visualización en modal.
     */
    public function show($id)
    {
        $bitacora = Bitacora::with(['usuario.rol'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $bitacora->id,
                'fecha_hora' => $bitacora->registrado_en ? $bitacora->registrado_en->format('d/m/Y h:i:s A') : 'N/A',
                'usuario' => $bitacora->usuario_nombre,
                'rol' => $bitacora->usuario_rol,
                'accion' => $bitacora->accion_normalizada,
                'accion_original' => $bitacora->accion,
                'modulo' => $bitacora->modulo ?? 'Documentos',
                'entidad' => $bitacora->entidad ?? 'General',
                'entidad_id' => $bitacora->entidad_id,
                'descripcion' => $bitacora->descripcion,
                'resultado' => $bitacora->resultado ?? 'exitoso',
                'ip_address' => $bitacora->ip_address ?? '127.0.0.1',
                'user_agent' => $bitacora->user_agent ?? 'N/A',
                'datos_anteriores' => $bitacora->datos_anteriores,
                'datos_nuevos' => $bitacora->datos_nuevos,
            ]
        ]);
    }
}
