<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\SGC\Models\Solicitud;
use Modules\SGC\Models\Proceso;
use Modules\SGC\Models\Area;
use Modules\SGC\Models\TipoDocumento;
use Modules\SGC\Models\Documento;
use Modules\SGC\Models\VersionDoc;
use Modules\SGC\Models\ListadoMaestro;
use Modules\SGC\Models\Bitacora;
use App\Models\Notificacion;
use Modules\SGC\Http\Requests\Solicitud\StoreSolicitudRequest;

class SolicitudController extends Controller
{
    /**
     * Muestra la lista de solicitudes documentales.
     * Si la petición es del Líder de Área muestra su portal de radicación,
     * y si es del Responsable de Calidad o Admin muestra la Gestión y Aprobación Documental.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $isLiderRoute = request()->routeIs('sgc.lider_area.*');
        $isLiderUser = auth()->check() && (auth()->user()->rol_id == 3 || str_contains(strtolower(auth()->user()->rol->nombre ?? ''), 'lider'));

        // Si es la ruta del Líder de Área o el usuario autenticado tiene rol Líder de Área:
        if ($isLiderRoute || $isLiderUser) {
            return $this->indexLiderArea($request);
        }

        // ==========================================
        // VISTA RESPONSABLE DE CALIDAD / ADMIN
        // ==========================================
        $query = Solicitud::with(['documento', 'proceso', 'area', 'tipoDoc', 'solicitante', 'asignado'])
            ->orderBy('id', 'desc');

        // Filtro de Búsqueda
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('justificacion', 'like', "%{$search}%")
                  ->orWhere('nombre_propuesto', 'like', "%{$search}%")
                  ->orWhereHas('solicitante', function ($qs) use ($search) {
                      $qs->where('nombre_completo', 'like', "%{$search}%")
                         ->orWhere('nombre_usuario', 'like', "%{$search}%");
                  })
                  ->orWhereHas('area', function ($qa) use ($search) {
                      $qa->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por Estado
        if ($request->filled('estado') && $request->estado !== 'all') {
            $query->where('estado', $request->estado);
        }

        $solicitudes = $query->paginate(10)->withQueryString();

        return view('sgc::Resp_Calidad.Solicitudes.index', compact('solicitudes'));
    }

    /**
     * Muestra la vista de evaluación y dictamen de solicitud para Responsable de Calidad.
     * Al ser consultada por primera vez, pasa automáticamente de 'radicada' a 'en_revision'
     * y se notifica en tiempo real al Líder de Área solicitante.
     */
    public function evaluar($id)
    {
        $solicitud = Solicitud::with(['documento.versionActual', 'proceso', 'area', 'tipoDoc', 'solicitante.rol', 'asignado'])
            ->findOrFail($id);

        // Si la solicitud está radicada y entra a evaluación, pasa automáticamente a 'en_revision'
        if ($solicitud->estado === 'radicada') {
            $solicitud->estado = 'en_revision';
            $solicitud->asignado_a = auth()->id();
            $solicitud->save();

            // Notificación al Líder de Área
            if ($solicitud->solicitado_por) {
                Notificacion::notificarUsuario(
                    $solicitud->solicitado_por,
                    'solicitud_en_revision',
                    "Solicitud en Revisión ({$solicitud->numero})",
                    "Su solicitud {$solicitud->numero} ({$solicitud->tipo}) ha pasado a estado 'En Revisión' por el Responsable de Calidad.",
                    'solicitudes',
                    $solicitud->id
                );
            }

            // Registro en Bitácora
            $userName = auth()->user()->nombre_completo ?? auth()->user()->nombre_usuario ?? 'Responsable de Calidad';
            Bitacora::registrar(
                'Modificación',
                "Solicitud N° {$solicitud->numero} pasó a estado 'En Revisión' por {$userName}.",
                'solicitudes',
                $solicitud->id,
                ['estado' => 'radicada'],
                ['estado' => 'en_revision'],
                'exitoso',
                'Solicitudes'
            );
        }

        return view('sgc::Resp_Calidad.Solicitudes.aprobar', compact('solicitud'));
    }

    /**
     * Aprueba formalmente una solicitud documental y publica automáticamente
     * el documento oficial en el Listado Maestro.
     */
    public function aprobar(Request $request, $id)
    {
        $solicitud = Solicitud::with(['documento', 'proceso', 'area', 'tipoDoc', 'solicitante'])->findOrFail($id);
        $userId = auth()->id();
        $userName = auth()->user()->nombre_completo ?? auth()->user()->nombre_usuario ?? 'Responsable de Calidad';

        DB::transaction(function () use ($solicitud, $request, $userId, $userName) {
            $estadoAnterior = $solicitud->estado;
            $solicitud->estado = 'aprobada';
            $solicitud->observaciones_resp = $request->input('observaciones', 'Solicitud aprobada y validada técnicamente para su inclusión en el Listado Maestro.');
            $solicitud->fecha_resolucion = now();
            $solicitud->asignado_a = $userId;
            $solicitud->save();

            // =========================================================================
            // PUBLICACIÓN AUTOMÁTICA EN LISTADO MAESTRO (DOCUMENTO + VERSION)
            // =========================================================================
            if ($solicitud->tipo === 'Creación' || $solicitud->tipo === 'creacion') {
                // 1. Generar código documental oficial estandarizado
                $tipoPrefix = $solicitud->tipoDoc?->codigo ?? 'PR';
                $areaPrefix = $solicitud->area?->codigo ?? 'AG';
                $consecutivo = Documento::where('proceso_id', $solicitud->proceso_id)->count() + 1;
                $codigoDoc = sprintf('%s-%s-%03d', $tipoPrefix, $areaPrefix, $consecutivo);

                // Asegurar código único si ya existiera
                while (Documento::where('codigo', $codigoDoc)->exists()) {
                    $consecutivo++;
                    $codigoDoc = sprintf('%s-%s-%03d', $tipoPrefix, $areaPrefix, $consecutivo);
                }

                // 2. Crear registro oficial en tabla documentos (vigente)
                $documento = Documento::create([
                    'codigo' => $codigoDoc,
                    'nombre' => $solicitud->nombre_propuesto ?: "Documento Oficial {$codigoDoc}",
                    'descripcion' => $solicitud->justificacion,
                    'proceso_id' => $solicitud->proceso_id,
                    'area_id' => $solicitud->area_id,
                    'tipo_doc_id' => $solicitud->tipo_doc_id ?: 1,
                    'responsable_id' => $solicitud->solicitado_por ?: $userId,
                    'estado' => 'vigente',
                    'fecha_elaboracion' => now()->toDateString(),
                    'fecha_proxima_revision' => now()->addYear()->toDateString(),
                    'fecha_publicacion' => now(),
                    'creado_por' => $userId,
                ]);

                // 3. Crear primera versión oficial V1.0 en versiones_doc
                $versionDoc = VersionDoc::create([
                    'documento_id' => $documento->id,
                    'numero_version' => '1.0',
                    'descripcion_cambio' => $solicitud->justificacion ?: 'Emisión inicial del documento oficial aprobado.',
                    'archivo_ruta' => $solicitud->adjunto_ruta ?: 'sgc/documentos/default.pdf',
                    'archivo_nombre' => basename($solicitud->adjunto_ruta ?: 'documento.pdf'),
                    'archivo_tamano_kb' => 125,
                    'archivo_formato' => pathinfo($solicitud->adjunto_ruta ?? 'pdf', PATHINFO_EXTENSION) ?: 'pdf',
                    'estado' => 'vigente',
                    'publicado_por' => $userId,
                    'fecha_publicacion' => now(),
                    'creado_por' => $userId,
                    'creado_en' => now(),
                ]);

                // 4. Registrar en el Listado Maestro oficial
                ListadoMaestro::updateOrCreate(
                    ['documento_id' => $documento->id],
                    [
                        'version_id' => $versionDoc->id,
                        'proceso_id' => $documento->proceso_id,
                        'publicado_por' => $userId,
                        'fecha_pub' => now(),
                        'activo' => true,
                    ]
                );

                // Vincular la solicitud con el nuevo documento creado
                $solicitud->documento_id = $documento->id;
                $solicitud->save();

            } elseif ($solicitud->tipo === 'Modificación' || $solicitud->tipo === 'modificacion') {
                $doc = $solicitud->documento;
                if ($doc) {
                    // Marcar versiones anteriores como obsoletas
                    VersionDoc::where('documento_id', $doc->id)->update(['estado' => 'obsoleto']);

                    // Crear nueva versión (V2.0 o sucesiva)
                    $versionActual = $doc->versiones()->max('numero_version') ?? '1.0';
                    $nextVerNum = is_numeric($versionActual) ? number_format((float)$versionActual + 1.0, 1) : '2.0';

                    $nuevaVersion = VersionDoc::create([
                        'documento_id' => $doc->id,
                        'numero_version' => $nextVerNum,
                        'descripcion_cambio' => $solicitud->descripcion_cambio ?: ($solicitud->justificacion ?: 'Modificación oficial aprobada.'),
                        'archivo_ruta' => $solicitud->adjunto_ruta ?: 'sgc/documentos/default.pdf',
                        'archivo_nombre' => basename($solicitud->adjunto_ruta ?: 'documento_v2.pdf'),
                        'archivo_tamano_kb' => 150,
                        'archivo_formato' => pathinfo($solicitud->adjunto_ruta ?? 'pdf', PATHINFO_EXTENSION) ?: 'pdf',
                        'estado' => 'vigente',
                        'publicado_por' => $userId,
                        'fecha_publicacion' => now(),
                        'creado_por' => $userId,
                        'creado_en' => now(),
                    ]);

                    $doc->update([
                        'estado' => 'vigente',
                        'fecha_proxima_revision' => now()->addYear()->toDateString(),
                        'actualizado_en' => now(),
                    ]);

                    ListadoMaestro::updateOrCreate(
                        ['documento_id' => $doc->id],
                        [
                            'version_id' => $nuevaVersion->id,
                            'proceso_id' => $doc->proceso_id,
                            'publicado_por' => $userId,
                            'fecha_pub' => now(),
                            'activo' => true,
                        ]
                    );
                }
            } elseif ($solicitud->tipo === 'Eliminación' || $solicitud->tipo === 'eliminacion') {
                $doc = $solicitud->documento;
                if ($doc) {
                    $doc->update([
                        'estado' => 'obsoleto',
                        'fecha_obsolescencia' => now(),
                    ]);
                    ListadoMaestro::where('documento_id', $doc->id)->update(['activo' => false]);
                }
            }

            // =========================================================================
            // NOTIFICACIÓN AL LÍDER DE ÁREA
            // =========================================================================
            if ($solicitud->solicitado_por) {
                Notificacion::notificarUsuario(
                    $solicitud->solicitado_por,
                    'solicitud_aprobada',
                    "¡Solicitud Aprobada y Publicada! ({$solicitud->numero})",
                    "Su solicitud {$solicitud->numero} ha sido APROBADA y el documento oficial ha sido incorporado al Listado Maestro vigente.",
                    'solicitudes',
                    $solicitud->id
                );
            }

            // =========================================================================
            // REGISTRO EN BITÁCORA
            // =========================================================================
            Bitacora::registrar(
                'Aprobación',
                "Solicitud N° {$solicitud->numero} ({$solicitud->tipo}) aprobada por {$userName} y publicada en el Listado Maestro.",
                'solicitudes',
                $solicitud->id,
                ['estado' => $estadoAnterior],
                ['estado' => 'aprobada', 'observaciones' => $solicitud->observaciones_resp],
                'exitoso',
                'Solicitudes'
            );
        });

        return redirect()->route('sgc.solicitudes.index')
            ->with('success', "La solicitud N° {$solicitud->numero} ha sido aprobada y el documento oficial ha sido publicado exitosamente en el Listado Maestro.");
    }

    /**
     * Rechaza formalmente una solicitud documental con observaciones.
     */
    public function rechazar(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $userId = auth()->id();
        $userName = auth()->user()->nombre_completo ?? auth()->user()->nombre_usuario ?? 'Responsable de Calidad';

        $estadoAnterior = $solicitud->estado;
        $solicitud->estado = 'rechazada';
        $solicitud->observaciones_resp = $request->input('observaciones', 'Solicitud rechazada por observaciones técnicas de Calidad.');
        $solicitud->fecha_resolucion = now();
        $solicitud->asignado_a = $userId;
        $solicitud->save();

        // Notificación al Líder de Área
        if ($solicitud->solicitado_por) {
            Notificacion::notificarUsuario(
                $solicitud->solicitado_por,
                'solicitud_rechazada',
                "Solicitud Rechazada ({$solicitud->numero})",
                "Su solicitud {$solicitud->numero} fue rechazada con la siguiente observación: {$solicitud->observaciones_resp}",
                'solicitudes',
                $solicitud->id
            );
        }

        // Registro en bitácora
        Bitacora::registrar(
            'Rechazo',
            "Solicitud N° {$solicitud->numero} rechazada por {$userName}.",
            'solicitudes',
            $solicitud->id,
            ['estado' => $estadoAnterior],
            ['estado' => 'rechazada', 'observaciones' => $solicitud->observaciones_resp],
            'exitoso',
            'Solicitudes'
        );

        return redirect()->route('sgc.solicitudes.index')
            ->with('warning', "La solicitud N° {$solicitud->numero} ha sido rechazada. Se notificó al Líder de Área con las observaciones registradas.");
    }

    /**
     * Radica una nueva solicitud en el sistema SGC (Líder de Área).
     */
    public function store(StoreSolicitudRequest $request)
    {
        $userId = auth()->id() ?? 1;
        $userName = auth()->user()->nombre_completo ?? auth()->user()->nombre_usuario ?? 'Líder de Área';

        $solicitud = DB::transaction(function () use ($request, $userId, $userName) {
            $year = date('Y');
            $consecutivo = Solicitud::whereYear('creado_en', $year)->count() + 1;
            $numero = sprintf('SOL-%s-%04d', $year, $consecutivo);

            $adjuntoRuta = null;
            if ($request->hasFile('adjunto')) {
                $file = $request->file('adjunto');
                $filename = 'borrador_' . strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '_', $numero)) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $adjuntoRuta = $file->storeAs('sgc/solicitudes_adjuntos', $filename, 'public');
            }

            $procesoId = $request->proceso_id;
            $areaId = $request->area_id;
            $tipoDocId = $request->tipo_doc_id;

            if ($request->filled('documento_id')) {
                $doc = Documento::find($request->documento_id);
                if ($doc) {
                    $procesoId = $procesoId ?: $doc->proceso_id;
                    $areaId = $areaId ?: $doc->area_id;
                    $tipoDocId = $tipoDocId ?: $doc->tipo_doc_id;
                }
            }

            $sol = Solicitud::create([
                'numero' => $numero,
                'tipo' => $request->tipo,
                'estado' => 'radicada',
                'documento_id' => $request->documento_id,
                'nombre_propuesto' => $request->nombre_propuesto,
                'proceso_id' => $procesoId,
                'area_id' => $areaId,
                'tipo_doc_id' => $tipoDocId,
                'justificacion' => $request->justificacion,
                'descripcion_cambio' => $request->descripcion_cambio,
                'adjunto_ruta' => $adjuntoRuta,
                'solicitado_por' => $userId,
                'fecha_radicacion' => now(),
                'creado_en' => now(),
                'actualizado_en' => now(),
            ]);

            // Cargar relaciones para notificación y bitácora
            $sol->load(['area', 'proceso', 'tipoDoc']);
            $areaNombre = $sol->area->nombre ?? 'Centro Agroindustrial';

            // =========================================================================
            // NOTIFICAR EN TIEMPO REAL AL RESPONSABLE DE CALIDAD Y ADMINISTRADORES
            // =========================================================================
            Notificacion::notificarRol(
                [1, 2, 'admin', 'administrador', 'resp_calidad', 'responsable_calidad'],
                'solicitud_radicada',
                "Nueva Solicitud Radicada ({$sol->numero})",
                "El Líder de Área '{$userName}' ha radicado la solicitud {$sol->numero} ({$sol->tipo}) para el área '{$areaNombre}'.",
                'solicitudes',
                $sol->id,
                $userId
            );

            // =========================================================================
            // REGISTRO EN BITÁCORA
            // =========================================================================
            Bitacora::registrar(
                'Creación',
                "Radicó la solicitud de {$sol->tipo} N° {$sol->numero} para el área {$areaNombre}.",
                'solicitudes',
                $sol->id,
                null,
                [
                    'numero' => $sol->numero,
                    'tipo' => $sol->tipo,
                    'proceso_id' => $sol->proceso_id,
                    'area_id' => $sol->area_id
                ],
                'exitoso',
                'Solicitudes',
                $userId
            );

            return $sol;
        });

        return redirect()->route('sgc.lider_area.solicitudes.index')
            ->with('success', "Solicitud N° {$solicitud->numero} radicada exitosamente ante Calidad. Se ha notificado al Responsable de Calidad.");
    }

    /**
     * Vista de Solicitudes del Líder de Área.
     */
    protected function indexLiderArea(Request $request)
    {
        $userId = auth()->id();
        $query = Solicitud::with(['documento', 'proceso', 'area', 'tipoDoc', 'solicitante', 'asignado']);

        if (!request()->has('ver_todos')) {
            $query->where('solicitado_por', $userId);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('justificacion', 'like', "%{$search}%")
                  ->orWhere('nombre_propuesto', 'like', "%{$search}%")
                  ->orWhereHas('documento', function ($qd) use ($search) {
                      $qd->where('nombre', 'like', "%{$search}%")
                         ->orWhere('codigo', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('tipo') && $request->tipo !== 'all') {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado') && $request->estado !== 'all') {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('proceso_id') && $request->proceso_id !== 'all') {
            $query->where('proceso_id', $request->proceso_id);
        }

        if ($request->filled('area_id') && $request->area_id !== 'all') {
            $query->where('area_id', $request->area_id);
        }

        $baseMetricsQuery = !request()->has('ver_todos') ? Solicitud::where('solicitado_por', $userId) : Solicitud::query();
        $totalRadicadas = (clone $baseMetricsQuery)->count();
        $enTramite = (clone $baseMetricsQuery)->whereIn('estado', ['radicada', 'en_revision'])->count();
        $aprobadas = (clone $baseMetricsQuery)->where('estado', 'aprobada')->count();
        $rechazadas = (clone $baseMetricsQuery)->whereIn('estado', ['rechazada', 'devuelta', 'cancelada'])->count();

        $solicitudes = $query->orderBy('id', 'desc')->paginate(10)->appends($request->all());

        $procesos = Proceso::where('activo', 1)->orderBy('nombre')->get();
        $areas = Area::where('activo', 1)->orderBy('nombre')->get();
        $tiposDoc = TipoDocumento::where('activo', 1)->orderBy('nombre')->get();
        $documentos = Documento::with(['proceso', 'area', 'tipoDoc', 'versionActual'])
            ->where('estado', 'vigente')
            ->orderBy('codigo')
            ->get();

        return view('sgc::Lider_Area.Solicitudes.index', compact(
            'solicitudes',
            'totalRadicadas',
            'enTramite',
            'aprobadas',
            'rechazadas',
            'procesos',
            'areas',
            'tiposDoc',
            'documentos'
        ));
    }

    /**
     * Muestra el detalle completo de una solicitud documental (Líder).
     */
    public function show($id)
    {
        $solicitud = Solicitud::with(['documento.versionActual', 'proceso', 'area', 'tipoDoc', 'solicitante.rol', 'asignado'])
            ->findOrFail($id);

        return view('sgc::Lider_Area.Solicitudes.Detalle', compact('solicitud'));
    }

    /**
     * Descarga el archivo adjunto/borrador de la solicitud.
     */
    public function downloadAdjunto($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        if (!$solicitud->adjunto_ruta || !Storage::disk('public')->exists($solicitud->adjunto_ruta)) {
            return redirect()->back()->with('error', 'El archivo borrador adjunto no se encuentra disponible.');
        }

        return Storage::disk('public')->download($solicitud->adjunto_ruta);
    }
}
