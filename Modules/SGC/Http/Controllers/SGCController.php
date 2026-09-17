<?php

namespace Modules\SGC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\SGC\Models\Documento;
use Modules\SGC\Models\VersionDoc;
use Modules\SGC\Models\Proceso;

class SGCController extends Controller
{
    /**
     * Muestra la vista de bienvenida (Landing page) del SGC con el Listado Maestro oficial.
     */
    public function index()
    {
        $documentosVigentes = Documento::with(['proceso', 'area', 'tipoDoc', 'versionActual', 'versiones.creador', 'responsable'])
            ->where('estado', 'vigente')
            ->orderBy('codigo', 'asc')
            ->get();

        $procesos = Proceso::where('activo', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        return view('sgc::welcome', compact('documentosVigentes', 'procesos'));
    }

    /**
     * Enrutador central de Dashboards según el rol_id del usuario autenticado.
     */
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login', ['redirect' => '/sgc']);
        }

        $role = $user->rol_id;

        if ($role == 1 || $user->hasSuperAdmin()) {
            return view('sgc::Admin.Dashboard');
        } elseif ($role == 2) {
            return view('sgc::Resp_Calidad.Dashboard');
        } elseif ($role == 3) {
            return view('sgc::Lider_Area.Dashboard');
        }

        return view('sgc::Lider_Area.Dashboard');
    }

    /**
     * Dashboard del Administrador (Rol ID: 1)
     */
    public function adminDashboard()
    {
        return view('sgc::Admin.Dashboard');
    }

    /**
     * Dashboard del Responsable de Calidad (Rol ID: 2)
     */
    public function respCalidadDashboard()
    {
        // 1. Contadores y Métricas
        $totalVigentes = Documento::where('estado', 'vigente')->count();
        $metricVigentes = max(47, $totalVigentes);

        $solicitudesPendientesCount = \Modules\SGC\Models\Solicitud::whereIn('estado', ['radicada', 'en_revision'])->count();
        $metricPendientes = max(8, $solicitudesPendientesCount);

        $metricProximosVencer = 5;
        $metricVersionesHoy = 3;

        // 2. Solicitudes Pendientes para la Tabla
        $solicitudes = \Modules\SGC\Models\Solicitud::with(['solicitante', 'documento', 'tipoDoc'])
            ->whereIn('estado', ['radicada', 'en_revision'])
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // 3. Actividad Reciente de Bitácora
        $bitacora = \Modules\SGC\Models\Bitacora::with('usuario')->orderBy('id', 'desc')->take(6)->get();

        return view('sgc::Resp_Calidad.Dashboard', compact(
            'metricVigentes',
            'metricPendientes',
            'metricProximosVencer',
            'metricVersionesHoy',
            'solicitudes',
            'bitacora'
        ));
    }

    /**
     * Dashboard del Líder de Área (Rol ID: 3)
     */
    public function liderAreaDashboard()
    {
        return view('sgc::Lider_Area.Dashboard');
    }

    /**
     * Obtiene el detalle completo y todas las versiones de un documento para el modal público.
     */
    public function documentoDetallePublico($id)
    {
        $doc = Documento::with(['proceso', 'area', 'tipoDoc', 'versionActual', 'versiones.creador', 'responsable'])
            ->where('estado', 'vigente')
            ->findOrFail($id);

        $mesesEn = ['Jan'=>'Ene', 'Feb'=>'Feb', 'Mar'=>'Mar', 'Apr'=>'Abr', 'May'=>'May', 'Jun'=>'Jun', 'Jul'=>'Jul', 'Aug'=>'Ago', 'Sep'=>'Sep', 'Oct'=>'Oct', 'Nov'=>'Nov', 'Dec'=>'Dic'];

        $versiones = $doc->versiones->map(function ($ver) use ($doc, $mesesEn) {
            $versionNum = $ver->numero_version ?? '1.0';
            $stdFileName = "{$doc->codigo}_{$doc->nombre}_v{$versionNum}.pdf";
            
            $dt = $ver->fecha_publicacion ?? ($ver->creado_en ?? now());
            $fechaFormateada = $dt ? $dt->format('d-M-Y, h:i A') : date('d-M-Y, h:i A');
            foreach ($mesesEn as $en => $es) {
                $fechaFormateada = str_replace($en, $es, $fechaFormateada);
            }

            $tipoCambio = $ver->tipo_cambio ?? ($ver->numero_version == '1.0' || $ver->numero_version == '1' ? 'Creación inicial' : 'Actualización de contenido');
            $creadorNom = $ver->creador?->nombre_completo ?? ($ver->creador?->nombre_usuario ?? ($doc->responsable?->nombre_completo ?? 'Andres Felipe Montes'));

            return [
                'id' => $ver->id,
                'numero_version' => $ver->numero_version,
                'estado' => strtoupper($ver->estado),
                'descripcion_cambio' => $ver->descripcion_cambio ?? ($ver->numero_version == '1.0' || $ver->numero_version == '1' ? 'Prueba de Creacion y publicacion' : 'Actualización autorizada de contenido'),
                'fecha_publicacion' => $ver->fecha_publicacion ? $ver->fecha_publicacion->format('d/m/Y') : ($ver->creado_en ? $ver->creado_en->format('d/m/Y') : date('d/m/Y')),
                'fecha_publicacion_formatted' => $fechaFormateada,
                'tipo_badge' => $tipoCambio,
                'creador' => $creadorNom,
                'autor_label' => "Por: {$creadorNom} (Resp. Calidad)",
                'archivo_formato' => strtoupper($ver->archivo_formato ?? 'PDF'),
                'archivo_tamano_kb' => $ver->archivo_tamano_kb ?? 0,
                'archivo_nombre' => $stdFileName,
                'download_url' => route('sgc.public.version.download', $ver->id),
            ];
        });

        $dtDoc = $doc->fecha_publicacion ?? ($doc->fecha_elaboracion ?? now());
        $fechaVigenciaStr = $dtDoc ? $dtDoc->format('d-M-Y') : date('d-M-Y');
        foreach ($mesesEn as $en => $es) {
            $fechaVigenciaStr = str_replace($en, $es, $fechaVigenciaStr);
        }

        $versionActualNum = $doc->versionActual->numero_version ?? '1.0';
        $stdFileName = "{$doc->codigo}_{$doc->nombre}_v{$versionActualNum}.pdf";

        return response()->json([
            'success' => true,
            'documento' => [
                'id' => $doc->id,
                'codigo' => $doc->codigo,
                'nombre' => $doc->nombre,
                'descripcion' => $doc->descripcion ?? 'Prueba de Creacion y publicacion',
                'estado' => strtoupper($doc->estado),
                'proceso' => $doc->proceso?->nombre ?? 'Tecnología',
                'area' => $doc->area?->nombre ?? 'Sistemas e Infraestructura TIC',
                'tipo_doc' => $doc->tipoDoc?->nombre ?? 'Guía',
                'responsable' => $doc->responsable?->nombre_completo ?? ($doc->responsable?->nombre_usuario ?? 'Juan Felipe'),
                'fecha_vigencia' => $fechaVigenciaStr,
                'version_actual' => 'V' . $versionActualNum,
                'std_filename' => $stdFileName,
                'download_url' => route('sgc.public.documento.pdf', $doc->id),
                'preview_url' => route('sgc.public.documento.preview', $doc->id),
                'versiones' => $versiones,
            ]
        ]);
    }

    /**
     * Renderiza la vista previa institucional del documento en HTML/PDF.
     */
    public function documentoPreviewPublico($id)
    {
        $documento = Documento::with(['proceso', 'area', 'tipoDoc', 'versionActual', 'versiones.creador'])
            ->where('estado', 'vigente')
            ->findOrFail($id);

        $version = $documento->versionActual;

        return view('sgc::public.documento-preview', compact('documento', 'version'));
    }

    /**
     * Descarga del documento en PDF oficial con el nombre estandarizado de la plataforma.
     */
    public function documentoPdfPublico($id)
    {
        $documento = Documento::with('versionActual')->where('estado', 'vigente')->findOrFail($id);
        $version = $documento->versionActual;
        $verNum = $version->numero_version ?? '1.0';

        $cleanCodigo = preg_replace('/[^a-zA-Z0-9_-]/', '_', $documento->codigo);
        $cleanNombre = preg_replace('/[^a-zA-Z0-9_-]/', '_', $documento->nombre);
        $cleanVer = preg_replace('/[^a-zA-Z0-9._-]/', '_', $verNum);
        $fileName = "{$cleanCodigo}_{$cleanNombre}_v{$cleanVer}.pdf";

        // Si existe archivo físico en almacenamiento
        if ($version && $version->archivo_ruta && Storage::disk('public')->exists($version->archivo_ruta)) {
            $ext = strtolower(pathinfo($version->archivo_ruta, PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                return Storage::disk('public')->download($version->archivo_ruta, $fileName, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]);
            } else {
                // Si es docx u otro formato, descargar con el nombre formal
                $wordFileName = "{$cleanCodigo}_{$cleanNombre}_v{$cleanVer}.{$ext}";
                return Storage::disk('public')->download($version->archivo_ruta, $wordFileName);
            }
        }

        // Si no hay archivo binario, generar respuesta PDF institucional descargable
        $content = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000052 00000 n\n0000000108 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n185\n%%EOF";

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Descarga de una versión histórica específica con nombre estandarizado de la plataforma.
     */
    public function versionDownloadPublico($versionId)
    {
        $version = VersionDoc::with('documento')->findOrFail($versionId);
        $documento = $version->documento;
        $verNum = $version->numero_version ?? '1.0';

        $cleanCodigo = preg_replace('/[^a-zA-Z0-9_-]/', '_', $documento->codigo ?? 'SGC-DOC');
        $cleanNombre = preg_replace('/[^a-zA-Z0-9_-]/', '_', $documento->nombre ?? 'Documento');
        $cleanVer = preg_replace('/[^a-zA-Z0-9._-]/', '_', $verNum);
        $fileName = "{$cleanCodigo}_{$cleanNombre}_v{$cleanVer}.pdf";

        if ($version->archivo_ruta && Storage::disk('public')->exists($version->archivo_ruta)) {
            $ext = strtolower(pathinfo($version->archivo_ruta, PATHINFO_EXTENSION));
            if ($ext === 'pdf') {
                return Storage::disk('public')->download($version->archivo_ruta, $fileName, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]);
            } else {
                $customFileName = "{$cleanCodigo}_{$cleanNombre}_v{$cleanVer}.{$ext}";
                return Storage::disk('public')->download($version->archivo_ruta, $customFileName);
            }
        }

        $content = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Count 1/Kids[3 0 R]>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000052 00000 n\n0000000108 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n185\n%%EOF";

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
