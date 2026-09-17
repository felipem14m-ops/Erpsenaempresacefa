@extends('sgc::layouts.master')

@section('title', 'SGC • Solicitud ' . $solicitud->numero)

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & ACTION ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h2 class="fw-bold text-dark mb-0" style="font-size: 26px; font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">
                    Solicitud {{ $solicitud->numero }}
                </h2>

                <!-- Status Badge -->
                @if($solicitud->estado === 'aprobada')
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold" style="background-color: #f0fdf4; color: #16a34a; font-size: 12.5px; border: 1px solid #dcfce7;">
                        <i class="fas fa-circle-check me-1"></i> Aprobada
                    </span>
                @elseif($solicitud->estado === 'radicada')
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold" style="background-color: #f1f5f9; color: #475569; font-size: 12.5px; border: 1px solid #cbd5e1;">
                        <i class="fas fa-clock me-1"></i> Radicada
                    </span>
                @elseif($solicitud->estado === 'en_revision')
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold" style="background-color: #fefce8; color: #ca8a04; font-size: 12.5px; border: 1px solid #fef08a;">
                        <i class="fas fa-spinner fa-spin me-1"></i> En revisión
                    </span>
                @elseif(in_array($solicitud->estado, ['rechazada', 'devuelta', 'cancelada']))
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold" style="background-color: #fef2f2; color: #ef4444; font-size: 12.5px; border: 1px solid #fee2e2;">
                        <i class="fas fa-circle-xmark me-1"></i> Con Observaciones
                    </span>
                @else
                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold bg-light text-secondary border">
                        {{ ucfirst($solicitud->estado) }}
                    </span>
                @endif
            </div>
            <p class="text-secondary small mb-0 mt-1" style="font-size: 13.5px;">
                Consulte los detalles y el historial de revisiones de su solicitud.
            </p>
        </div>

        <div>
            <a href="{{ route('sgc.admin.solicitudes.index') }}" class="btn btn-white border rounded-3 px-3 py-2 fw-semibold text-secondary d-inline-flex align-items-center gap-2 shadow-2xs" style="background-color: #ffffff; font-size: 13.5px;">
                <i class="fas fa-arrow-left"></i>
                <span>Volver al Listado</span>
            </a>
        </div>
    </div>

    <!-- ======= MAIN 2-COLUMN DETAIL GRID ======= -->
    <div class="row g-4 align-items-start">

        <!-- ======= LEFT COLUMN: INFORMACIÓN DE LA SOLICITUD ======= -->
        <div class="col-12 col-lg-8">
            <div class="card border rounded-4 bg-white shadow-2xs p-4">
                
                <h5 class="fw-bold text-dark mb-4" style="font-size: 17px; font-family: 'Outfit', sans-serif;">
                    Información de la Solicitud
                </h5>

                <!-- 2-Row Metadata Grid -->
                <div class="row g-4 mb-4">
                    <!-- Row 1 -->
                    <div class="col-12 col-sm-4">
                        <small class="text-muted fw-semibold d-block mb-1" style="font-size: 11.5px;">Número</small>
                        <span class="fw-bold text-dark font-monospace d-block" style="font-size: 14.5px;">
                            {{ $solicitud->numero }}
                        </span>
                    </div>

                    <div class="col-12 col-sm-4">
                        <small class="text-muted fw-semibold d-block mb-1" style="font-size: 11.5px;">Tipo de Solicitud</small>
                        <span class="fw-bold text-dark text-capitalize d-block" style="font-size: 14.5px;">
                            {{ $solicitud->tipo }}
                        </span>
                    </div>

                    <div class="col-12 col-sm-4">
                        <small class="text-muted fw-semibold d-block mb-1" style="font-size: 11.5px;">Fecha Radicación</small>
                        <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">
                            {{ $solicitud->fecha_radicacion ? $solicitud->fecha_radicacion->translatedFormat('d-M-Y') : ($solicitud->creado_en ? $solicitud->creado_en->translatedFormat('d-M-Y') : 'N/A') }}
                        </span>
                    </div>

                    <!-- Row 2 -->
                    <div class="col-12 col-sm-4">
                        <small class="text-muted fw-semibold d-block mb-1" style="font-size: 11.5px;">Solicitante</small>
                        <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">
                            {{ $solicitud->solicitante->nombre_completo ?? ($solicitud->solicitante->nombre_usuario ?? 'Administrador') }}
                        </span>
                    </div>

                    <div class="col-12 col-sm-4">
                        <small class="text-muted fw-semibold d-block mb-1" style="font-size: 11.5px;">Área</small>
                        <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">
                            {{ $solicitud->area->nombre ?? ($solicitud->documento->area->nombre ?? 'N/A') }}
                        </span>
                    </div>

                    <div class="col-12 col-sm-4">
                        <small class="text-muted fw-semibold d-block mb-1" style="font-size: 11.5px;">Proceso</small>
                        <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">
                            {{ $solicitud->proceso->nombre ?? ($solicitud->documento->proceso->nombre ?? 'N/A') }}
                        </span>
                    </div>
                </div>

                <!-- Documento Relacionado Box -->
                <div class="rounded-3 p-3 mb-3" style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                    <small class="text-muted fw-medium d-block mb-1" style="font-size: 11.5px;">Documento Relacionado</small>
                    @if($solicitud->documento)
                        <span class="fw-bold d-block" style="color: #007832; font-size: 14px;">
                            {{ $solicitud->documento->codigo }} — {{ $solicitud->documento->nombre }}
                        </span>
                    @else
                        <span class="fw-bold d-block" style="color: #007832; font-size: 14px;">
                            {{ $solicitud->nombre_propuesto ?: ($solicitud->tipoDoc->nombre ?? 'Documento nuevo a crear') }}
                        </span>
                    @endif
                </div>

                <!-- Justificación de la Solicitud Box -->
                <div class="rounded-3 p-3 mb-4" style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                    <small class="text-muted fw-medium d-block mb-1" style="font-size: 11.5px;">Justificación de la Solicitud</small>
                    <p class="text-secondary mb-0" style="font-size: 13.5px; line-height: 1.6; white-space: pre-wrap;">{{ $solicitud->justificacion }}</p>
                </div>

                <!-- Respuesta del Responsable de Calidad Box -->
                @if($solicitud->estado === 'aprobada' || $solicitud->observaciones_resp)
                    <div class="rounded-3 p-3" style="background-color: #f0faf0; border: 1px solid #c8e6c9;">
                        <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-2">
                            <strong style="color: #007832; font-size: 13.5px;">Respuesta del Responsable de Calidad</strong>
                            <small class="text-muted" style="font-size: 11.5px;">
                                Resuelto el: {{ $solicitud->fecha_resolucion ? $solicitud->fecha_resolucion->translatedFormat('d-M-Y') : ($solicitud->actualizado_en ? $solicitud->actualizado_en->translatedFormat('d-M-Y') : now()->translatedFormat('d-M-Y')) }}
                            </small>
                        </div>
                        <p class="text-dark mb-0" style="font-size: 13px; line-height: 1.55;">
                            {{ $solicitud->observaciones_resp ?: 'Se revisó la propuesta del borrador y se valida la coherencia frente al marco regulatorio. Procedimiento de cambio aplicado de forma satisfactoria en el listado maestro vigente.' }}
                        </p>
                    </div>
                @elseif(in_array($solicitud->estado, ['rechazada', 'devuelta']))
                    <div class="rounded-3 p-3" style="background-color: #fff1f2; border: 1px solid rgba(239, 68, 68, 0.35);">
                        <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-2">
                            <strong style="color: #b91c1c; font-size: 13.5px;">Dictamen / Observaciones de Calidad</strong>
                            <small class="text-muted" style="font-size: 11.5px;">
                                Revisado el: {{ $solicitud->actualizado_en ? $solicitud->actualizado_en->translatedFormat('d-M-Y') : 'N/A' }}
                            </small>
                        </div>
                        <p class="text-dark mb-0" style="font-size: 13px; line-height: 1.55;">
                            {{ $solicitud->observaciones_resp ?: 'Solicitud con observaciones técnicas requeridas para su aprobación.' }}
                        </p>
                    </div>
                @else
                    <div class="rounded-3 p-3" style="background-color: #fefce8; border: 1px solid #fef08a;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong style="color: #ca8a04; font-size: 13.5px;">Estado de Revisión</strong>
                            <small class="text-muted" style="font-size: 11.5px;">En trámite</small>
                        </div>
                        <p class="text-secondary small mb-0" style="font-size: 13px;">
                            La solicitud se encuentra en cola de revisión por parte del Responsable de Calidad. Una vez evaluada, el dictamen y las observaciones aparecerán en este panel.
                        </p>
                    </div>
                @endif

            </div>
        </div>

        <!-- ======= RIGHT COLUMN: BORRADOR ADJUNTO ======= -->
        <div class="col-12 col-lg-4">
            <div class="card border rounded-4 bg-white shadow-2xs p-4">
                
                <h5 class="fw-bold text-dark mb-1" style="font-size: 17px; font-family: 'Outfit', sans-serif;">
                    Borrador Adjunto
                </h5>
                <p class="text-muted small mb-4" style="font-size: 12.5px;">
                    Documento borrador cargado en la radicación
                </p>

                @if($solicitud->adjunto_ruta)
                    @php
                        $ext = strtoupper(pathinfo($solicitud->adjunto_ruta, PATHINFO_EXTENSION));
                        $filename = basename($solicitud->adjunto_ruta);
                    @endphp
                    <div class="border rounded-3 p-3 d-flex align-items-center justify-content-between bg-white" style="border-color: #e2e8f0;">
                        <div class="d-flex align-items-center gap-3 overflow-hidden me-2" style="min-width: 0;">
                            <!-- Doc Icon -->
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background-color: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7;">
                                <i class="fas fa-file-lines fs-5"></i>
                            </div>

                            <!-- File Details -->
                            <div class="text-truncate" style="min-width: 0;">
                                <strong class="text-dark d-block text-truncate" style="font-size: 13px;" title="{{ $filename }}">
                                    {{ $filename }}
                                </strong>
                                <small class="text-muted" style="font-size: 11px;">
                                    Archivo {{ $ext }} · Borrador
                                </small>
                            </div>
                        </div>

                        <!-- Download Button -->
                        <a href="{{ route('sgc.admin.solicitudes.download-adjunto', $solicitud->id) }}" class="btn btn-light btn-sm border rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;" title="Descargar Borrador">
                            <i class="fas fa-download text-secondary"></i>
                        </a>
                    </div>
                @else
                    <div class="border rounded-3 p-4 text-center text-muted small" style="background-color: #f8fafc; border-style: dashed !important; border-color: #cbd5e1;">
                        <i class="fas fa-file-circle-xmark fs-4 text-muted mb-2 d-block"></i>
                        No se adjuntó archivo borrador para esta solicitud.
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>
@endsection
