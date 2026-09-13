@extends('sgc::layouts.master')

@section('title', 'SGC • Aprobar Solicitud ' . $solicitud->numero)

@section('content')
<div class="container-fluid px-0">

    <!-- ======= PAGE HEADER ======= -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
            Aprobar Solicitud Documental
        </h2>
        <p class="text-muted small mb-0" style="font-size: 13.5px;">
            Revise los detalles técnicos, justificación y borrador antes de autorizar la publicación.
        </p>
    </div>

    <!-- ======= FLASH MESSAGES ======= -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #eaf8ea; color: #39A900;">
                <i class="fas fa-circle-check fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Operación Exitosa</strong>
                <span class="text-secondary small">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #fef2f2; color: #ef4444;">
                <i class="fas fa-triangle-exclamation fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Atención</strong>
                <span class="text-secondary small">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ======= MAIN 2-COLUMN EVALUATION GRID ======= -->
    <div class="row g-4 align-items-start">
        
        <!-- ======= LEFT COLUMN: DETALLES Y DICTAMEN ======= -->
        <div class="col-12 col-lg-8">
            <div class="card border rounded-4 bg-white shadow-xs p-4">
                
                <h5 class="fw-bold text-dark mb-4" style="font-size: 17px; font-family: 'Outfit', sans-serif;">
                    Detalles de la Solicitud {{ $solicitud->numero }}
                </h5>

                <!-- Metadata Grid (2 Columns x 3 Rows) -->
                <div class="row g-4 mb-4">
                    <!-- Row 1 -->
                    <div class="col-12 col-sm-6">
                        <small class="text-muted fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase;">
                            Tipo de Solicitud
                        </small>
                        <span class="fw-bold text-dark text-capitalize d-block" style="font-size: 14.5px;">
                            {{ $solicitud->tipo }}
                        </span>
                    </div>

                    <div class="col-12 col-sm-6">
                        <small class="text-muted fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase;">
                            Solicitante
                        </small>
                        <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">
                            {{ $solicitud->solicitante->nombre_completo ?? ($solicitud->solicitante->nombre_usuario ?? 'Ing. Amanda Ortiz') }}
                        </span>
                    </div>

                    <!-- Row 2 -->
                    <div class="col-12 col-sm-6">
                        <small class="text-muted fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase;">
                            Área
                        </small>
                        <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">
                            {{ $solicitud->area->nombre ?? ($solicitud->documento->area->nombre ?? 'Agroindustrial') }}
                        </span>
                    </div>

                    <div class="col-12 col-sm-6">
                        <small class="text-muted fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase;">
                            Proceso
                        </small>
                        <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">
                            {{ $solicitud->proceso->nombre ?? ($solicitud->documento->proceso->nombre ?? 'Calidad') }}
                        </span>
                    </div>

                    <!-- Row 3 -->
                    <div class="col-12 col-sm-6">
                        <small class="text-muted fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase;">
                            Fecha Radicación
                        </small>
                        <span class="fw-bold text-dark d-block" style="font-size: 14.5px;">
                            {{ $solicitud->fecha_radicacion ? $solicitud->fecha_radicacion->translatedFormat('d-M-Y') : ($solicitud->creado_en ? $solicitud->creado_en->translatedFormat('d-M-Y') : '18-Ene-2024') }}
                        </span>
                    </div>

                    <div class="col-12 col-sm-6">
                        <small class="text-muted fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase;">
                            Estado Actual
                        </small>
                        <div>
                            @if($solicitud->estado === 'radicada')
                                <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fef3c7; color: #d97706; font-size: 12px;">
                                    Radicada
                                </span>
                            @elseif($solicitud->estado === 'en_revision')
                                <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #e0f2fe; color: #0284c7; font-size: 12px;">
                                    En revisión
                                </span>
                            @elseif($solicitud->estado === 'aprobada')
                                <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #eaf8ea; color: #007832; font-size: 12px;">
                                    Aprobada
                                </span>
                            @else
                                <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fee2e2; color: #dc2626; font-size: 12px;">
                                    Rechazada
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Justificación de la Solicitud Box -->
                <div class="rounded-3 p-3 mb-4" style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                    <small class="text-muted fw-medium d-block mb-1" style="font-size: 11.5px;">Justificación de la Solicitud</small>
                    <p class="text-secondary mb-0" style="font-size: 13.5px; line-height: 1.6; white-space: pre-wrap;">{{ $solicitud->justificacion }}</p>
                </div>

                <!-- Evaluation Form (Approve or Reject with observations) -->
                <form method="POST" id="formEvaluacionSolicitud">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-medium mb-1" style="font-size: 12px;">
                            Observaciones del Responsable de Calidad
                        </label>
                        <textarea name="observaciones" 
                                  id="input_observaciones" 
                                  class="form-control rounded-3 p-3 bg-white border" 
                                  style="font-size: 13.5px; border-color: #e2e8f0;" 
                                  rows="4" 
                                  placeholder="Escriba observaciones o motivos de rechazo/aprobación...">{{ old('observaciones', $solicitud->observaciones_resp) }}</textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end align-items-center gap-3 pt-2">
                        <!-- Reject Button -->
                        <button type="submit" 
                                formaction="{{ route('sgc.solicitudes.rechazar', $solicitud->id) }}" 
                                class="btn rounded-3 px-4 py-2 fw-bold" 
                                style="border: 1.5px solid #ef4444; color: #ef4444; background: #ffffff; font-size: 14px;"
                                onclick="return confirm('¿Está seguro de rechazar esta solicitud con las observaciones indicadas?');">
                            Rechazar Solicitud
                        </button>

                        <!-- Approve Button -->
                        <button type="submit" 
                                formaction="{{ route('sgc.solicitudes.aprobar', $solicitud->id) }}" 
                                class="btn text-white rounded-3 px-4 py-2 fw-bold shadow-xs" 
                                style="background-color: #39A900; border: none; font-size: 14px;"
                                onclick="return confirm('¿Está seguro de aprobar esta solicitud para su publicación oficial?');">
                            Aprobar Solicitud
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- ======= RIGHT COLUMN: BORRADOR ADJUNTO ======= -->
        <div class="col-12 col-lg-4">
            <div class="card border rounded-4 bg-white shadow-xs p-4">
                
                <h5 class="fw-bold text-dark mb-3" style="font-size: 17px; font-family: 'Outfit', sans-serif;">
                    Borrador Adjunto
                </h5>

                <!-- Dashed Container -->
                <div class="rounded-4 p-4 text-center d-flex flex-column align-items-center justify-content-center" style="border: 1.5px dashed #86efac; background-color: #ffffff;">
                    
                    <!-- Icon -->
                    <div class="rounded-3 d-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </div>

                    @php
                        $adjuntoName = $solicitud->adjunto_ruta ? basename($solicitud->adjunto_ruta) : ($solicitud->numero . '_borrador.docx');
                    @endphp

                    <!-- Filename -->
                    <strong class="text-dark d-block mb-1 text-truncate" style="font-size: 13.5px; max-width: 100%;" title="{{ $adjuntoName }}">
                        {{ $adjuntoName }}
                    </strong>

                    <!-- Filesize -->
                    <small class="text-muted d-block mb-3" style="font-size: 11.5px;">
                        Tamaño: 4.2 MB
                    </small>

                    <!-- Download Button -->
                    @if($solicitud->adjunto_ruta)
                        <a href="{{ route('sgc.solicitudes.download-adjunto', $solicitud->id) }}" class="btn text-white rounded-3 px-4 py-2 fw-bold w-100 shadow-xs" style="background-color: #39A900; border: none; font-size: 13.5px;">
                            Descargar Archivo
                        </a>
                    @else
                        <a href="{{ route('sgc.solicitudes.download-adjunto', $solicitud->id) }}" class="btn text-white rounded-3 px-4 py-2 fw-bold w-100 shadow-xs" style="background-color: #39A900; border: none; font-size: 13.5px;">
                            Descargar Archivo
                        </a>
                    @endif

                </div>

            </div>
        </div>

    </div>

</div>
@endsection
