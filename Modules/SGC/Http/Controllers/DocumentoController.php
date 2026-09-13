<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Modules\SGC\Models\Documento;
use Modules\SGC\Models\VersionDoc;
use Modules\SGC\Models\Proceso;
use Modules\SGC\Models\Area;
use Modules\SGC\Models\TipoDocumento;
use Modules\SGC\Models\DocumentoFrecuente;
use Modules\SGC\Models\ListadoMaestro;
use Modules\SGC\Models\Bitacora;
use Modules\SGC\Models\HistorialEstado;
use Modules\SGC\Http\Requests\Documento\StoreDocumentoRequest;
use Modules\SGC\Http\Requests\Documento\UpdateDocumentoRequest;

class DocumentoController extends Controller
{
    /**
     * Muestra el Listado Maestro de Documentos con filtros y documentos frecuentes.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $procesoId = $request->query('proceso_id');
        $areaId = $request->query('area_id');
        $tipoDocId = $request->query('tipo_doc_id');
        $estado = $request->query('estado');

        // Query principal de documentos
        $query = Documento::with(['proceso', 'area', 'tipoDoc', 'responsable', 'versionActual', 'versiones'])
            ->orderBy('id', 'desc');

        // Filtro de búsqueda (código, nombre o descripción)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'LIKE', "%{$search}%")
                    ->orWhere('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por proceso
        if (!empty($procesoId) && $procesoId !== 'all') {
            $query->where('proceso_id', $procesoId);
        }

        // Filtro por área
        if (!empty($areaId) && $areaId !== 'all') {
            $query->where('area_id', $areaId);
        }

        // Filtro por tipo documental
        if (!empty($tipoDocId) && $tipoDocId !== 'all') {
            $query->where('tipo_doc_id', $tipoDocId);
        }

        // Filtro por estado
        if (!empty($estado) && $estado !== 'all') {
            $query->where('estado', $estado);
        }

        $documentos = $query->paginate(10)->withQueryString();

        // Carga de catálogos para filtros y formularios
        $procesos = Proceso::where('activo', 1)->orderBy('nombre')->get();
        $areas = Area::where('activo', 1)->orderBy('nombre')->get();
        $tiposDoc = TipoDocumento::where('activo', 1)->orderBy('nombre')->get();
        $responsables = User::where('activo', 1)->orderBy('nombre_completo')->get();

        // Documentos Frecuentes (Top 3 destacados para las tarjetas superiores)
        $userId = auth()->id();
        $frecuentesQuery = DocumentoFrecuente::with(['documento.versionActual', 'documento.proceso'])
            ->whereHas('documento');

        if ($userId) {
            $frecuentesQuery->where('usuario_id', $userId);
        }

        $frecuentes = $frecuentesQuery->orderBy('total_accesos', 'desc')
            ->take(3)
            ->get()
            ->pluck('documento');

        // Si no hay suficientes frecuentes por usuario, completar con documentos vigentes generales
        if ($frecuentes->count() < 3) {
            $extras = Documento::with(['versionActual', 'proceso'])
                ->where('estado', 'vigente')
                ->whereNotIn('id', $frecuentes->pluck('id')->toArray())
                ->take(3 - $frecuentes->count())
                ->get();
            $frecuentes = $frecuentes->concat($extras);
        }

        return view('sgc::Admin.Documento.GestionDocumentos', compact(
            'documentos',
            'procesos',
            'areas',
            'tiposDoc',
            'responsables',
            'frecuentes',
            'search',
            'procesoId',
            'areaId',
            'tipoDocId',
            'estado'
        ));
    }

    /**
     * Registra un nuevo documento cumpliendo el Flujo 1 (UML Registrar Documento).
     */
    public function store(StoreDocumentoRequest $request)
    {
        $userId = auth()->id() ?? 1;

        // 1. Almacenar archivo en almacenamiento seguro
        $file = $request->file('archivo');
        $extension = strtolower($file->getClientOriginalExtension());
        $originalName = $file->getClientOriginalName();
        $sizeKb = round($file->getSize() / 1024);
        $cleanCode = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '_', $request->codigo));
        $filename = $cleanCode . '_v' . str_replace('.', '_', $request->numero_version) . '_' . time() . '.' . $extension;
        $filePath = $file->storeAs('sgc/documentos', $filename, 'public');

        // 2. Almacena documento con estado 'Borrador' en el repositorio
        $documento = Documento::create([
            'codigo' => strtoupper(trim($request->codigo)),
            'nombre' => trim($request->nombre),
            'descripcion' => $request->descripcion,
            'proceso_id' => $request->proceso_id,
            'area_id' => $request->area_id,
            'tipo_doc_id' => $request->tipo_doc_id,
            'responsable_id' => $request->responsable_id,
            'estado' => 'borrador', // Flujo UML: Estado 'Borrador'
            'fecha_elaboracion' => $request->fecha_elaboracion,
            'fecha_proxima_revision' => $request->fecha_proxima_revision,
            'creado_por' => $userId,
            'creado_en' => now(),
            'actualizado_en' => now(),
        ]);

        // 3. Crear versión inicial en versiones_doc
        $version = VersionDoc::create([
            'documento_id' => $documento->id,
            'numero_version' => trim($request->numero_version),
            'descripcion_cambio' => $request->descripcion_cambio ?? 'Creación inicial del documento en estado Borrador.',
            'archivo_ruta' => $filePath,
            'archivo_nombre' => $originalName,
            'archivo_tamano_kb' => $sizeKb,
            'archivo_formato' => $extension,
            'estado' => 'borrador',
            'creado_por' => $userId,
            'creado_en' => now(),
        ]);

        // 4. Registra acción en bitácora: (usuario, fecha, código doc)
        $userName = auth()->user()->nombre_completo ?? auth()->user()->nombre_usuario ?? 'Responsable de Calidad';
        Bitacora::registrar(
            'registro_documento',
            "Documento {$documento->codigo} registrado en estado Borrador por {$userName}.",
            'documentos',
            $documento->id,
            null,
            [
                'codigo' => $documento->codigo,
                'nombre' => $documento->nombre,
                'version' => $version->numero_version,
                'estado' => 'borrador',
                'archivo' => $originalName
            ]
        );

        // 5. Retornar mensaje exacto del flujo
        return redirect()->back()->with('success', 'Documento registrado exitosamente. Pendiente de revisión y aprobación.');
    }

    /**
     * Retorna el detalle completo y trazabilidad de versiones para el modal (Flujo 2).
     */
    public function show($id)
    {
        $documento = Documento::with([
            'proceso',
            'area',
            'tipoDoc',
            'responsable',
            'creador',
            'versiones.creador',
            'versiones.publicador',
            'historialEstados.usuario'
        ])->findOrFail($id);

        // Registrar acceso en documentos frecuentes
        if (auth()->check()) {
            DocumentoFrecuente::registrarAcceso(auth()->id(), $documento->id);
        }

        // Obtener historial de bitácora asociado al documento
        $bitacoras = Bitacora::where('entidad', 'documentos')
            ->where('entidad_id', $documento->id)
            ->with('usuario')
            ->orderBy('registrado_en', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'documento' => $documento,
            'bitacoras' => $bitacoras,
        ]);
    }

    /**
     * Actualiza los datos de un documento cumpliendo el Flujo 3 (UML Editar datos Documento).
     */
    public function update(UpdateDocumentoRequest $request, $id)
    {
        $documento = Documento::findOrFail($id);

        $anteriores = $documento->only(['nombre', 'proceso_id', 'area_id', 'tipo_doc_id', 'responsable_id', 'descripcion', 'fecha_proxima_revision']);

        // Persiste cambios en BD (actualizado_en)
        $documento->update([
            'nombre' => trim($request->nombre),
            'proceso_id' => $request->proceso_id,
            'area_id' => $request->area_id,
            'tipo_doc_id' => $request->tipo_doc_id,
            'responsable_id' => $request->responsable_id,
            'descripcion' => $request->descripcion,
            'fecha_proxima_revision' => $request->fecha_proxima_revision,
            'actualizado_en' => now(),
        ]);

        // Si se adjunta un nuevo archivo, actualizar la versión actual
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $extension = strtolower($file->getClientOriginalExtension());
            $originalName = $file->getClientOriginalName();
            $sizeKb = round($file->getSize() / 1024);
            $cleanCode = strtolower(preg_replace('/[^a-zA-Z0-9_-]/', '_', $documento->codigo));
            $filename = $cleanCode . '_update_' . time() . '.' . $extension;
            $filePath = $file->storeAs('sgc/documentos', $filename, 'public');

            $versionActual = $documento->versionActual;
            if ($versionActual) {
                $versionActual->update([
                    'archivo_ruta' => $filePath,
                    'archivo_nombre' => $originalName,
                    'archivo_tamano_kb' => $sizeKb,
                    'archivo_formato' => $extension,
                ]);
            }
        }

        // Registra edición en bitácora
        $userName = auth()->user()->nombre_completo ?? auth()->user()->nombre_usuario ?? 'Usuario';
        Bitacora::registrar(
            'edicion_documento',
            "Actualización de datos del documento {$documento->codigo} realizada por {$userName}.",
            'documentos',
            $documento->id,
            $anteriores,
            $documento->only(['nombre', 'proceso_id', 'area_id', 'tipo_doc_id', 'responsable_id', 'descripcion', 'fecha_proxima_revision'])
        );

        // Mensaje exacto del flujo
        return redirect()->back()->with('success', 'Datos actualizados exitosamente.');
    }

    /**
     * Elimina un documento y registra la acción en la bitácora.
     */
    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);
        $codigo = $documento->codigo;
        $nombre = $documento->nombre;

        // Registrar en bitácora antes de eliminar
        $userName = auth()->user()->nombre_completo ?? auth()->user()->nombre_usuario ?? 'Usuario';
        Bitacora::registrar(
            'eliminacion_documento',
            "Documento {$codigo} ('{$nombre}') eliminado del sistema por {$userName}.",
            'documentos',
            $id,
            ['codigo' => $codigo, 'nombre' => $nombre],
            null
        );

        // Eliminar versiones y documento
        $documento->delete();

        return redirect()->back()->with('success', "El documento {$codigo} ha sido eliminado exitosamente.");
    }

    /**
     * Descarga el archivo del documento y suma acceso a documentos frecuentes.
     */
    public function download($id)
    {
        $documento = Documento::with('versionActual')->findOrFail($id);
        $version = $documento->versionActual;

        // Registrar acceso
        if (auth()->check()) {
            DocumentoFrecuente::registrarAcceso(auth()->id(), $documento->id);
        }

        if ($version && Storage::disk('public')->exists($version->archivo_ruta)) {
            return Storage::disk('public')->download($version->archivo_ruta, $version->archivo_nombre);
        }

        // Si el archivo físico de prueba no existe, generar una respuesta descargable simulada
        $content = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000052 00000 n\n0000000108 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n185\n%%EOF";
        $fileName = strtolower($documento->codigo) . '.pdf';

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
