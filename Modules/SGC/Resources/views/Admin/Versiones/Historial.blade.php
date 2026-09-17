@extends('sgc::layouts.master')

@section('title', 'SGC • Historial de Cambios de Documento')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & NAVIGATION ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
                Historial de Cambios de Documento
            </h2>
            <p class="text-muted small mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px;">
                Consulte la trazabilidad de modificaciones, actualizaciones y estados de cada versión documental.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Selector de Documento Rápido -->
            <form method="GET" action="{{ route('sgc.versiones.historial-view') }}" class="d-inline-block">
                <select name="documento_id" class="form-select form-select-sm bg-white border shadow-xs rounded-3 fw-semibold text-dark" style="font-size: 12.5px; height: 38px; min-width: 220px;" onchange="window.location.href='{{ url('sgc/versiones/historial') }}/' + this.value">
                    @foreach($documentosList as $docItem)
                        <option value="{{ $docItem->id }}" {{ ($documento && $documento->id == $docItem->id) ? 'selected' : '' }}>
                            {{ $docItem->codigo }} — {{ Str::limit($docItem->nombre, 30) }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Botón Volver a Versiones -->
            <a href="{{ route('sgc.versiones.index') }}" 
               class="btn btn-outline-secondary bg-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-xs" 
               style="font-size: 13px; height: 38px;" 
               title="Volver a la tabla de versiones">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>

    @if($documento)
        @php
            $verVigente = $documento->versionActual->numero_version ?? '3.0';
            $fechaEntrada = $documento->fecha_publicacion 
                ? $documento->fecha_publicacion->format('d-M-Y') 
                : ($documento->creado_en ? $documento->creado_en->format('d-M-Y') : '15-Ene-2024');
            
            // Reemplazo de meses en español
            $mesesEn = ['Jan'=>'Ene', 'Feb'=>'Feb', 'Mar'=>'Mar', 'Apr'=>'Abr', 'May'=>'May', 'Jun'=>'Jun', 'Jul'=>'Jul', 'Aug'=>'Ago', 'Sep'=>'Sep', 'Oct'=>'Oct', 'Nov'=>'Nov', 'Dec'=>'Dic'];
            foreach($mesesEn as $en => $es) {
                $fechaEntrada = str_replace($en, $es, $fechaEntrada);
            }

            $responsableNombre = $documento->responsable->nombre_completo 
                ?? ($documento->responsable->nombre_usuario ?? 'Sandra Perdomo');
        @endphp

        <!-- ======= CARD SUPERIOR: METADATOS DEL DOCUMENTO ======= -->
        <div class="card border rounded-4 bg-white shadow-sm p-4 mb-4" style="border-color: #e2e8f0 !important;">
            <!-- Fila Superior: Código, Título y Badge de Vigencia -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pb-3 mb-3 border-bottom" style="border-color: #f1f5f9 !important;">
                <div class="d-flex align-items-center gap-2.5 flex-wrap">
                    <span class="badge px-2.5 py-1.5 fw-bold" style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; font-size: 13px; letter-spacing: 0.2px;">
                        {{ $documento->codigo }}
                    </span>
                    <h3 class="fw-bold text-dark mb-0" style="font-size: 20px; font-family: 'Outfit', sans-serif;">
                        {{ $documento->nombre }}
                    </h3>
                </div>

                <div>
                    <span class="badge px-3 py-1.5 fw-bold" style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; font-size: 13px; border-radius: 20px;">
                        Vigente (V{{ $verVigente }})
                    </span>
                </div>
            </div>

            <!-- Fila Inferior: 4 Columnas de Clasificación Institucional -->
            <div class="row g-3">
                <!-- 1. Proceso -->
                <div class="col-12 col-sm-6 col-md-3">
                    <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.6px;">
                        PROCESO
                    </small>
                    <strong class="text-dark d-block" style="font-size: 14.5px; font-weight: 700;">
                        {{ $documento->proceso->nombre ?? 'Calidad y Control' }}
                    </strong>
                </div>

                <!-- 2. Tipo de Documento -->
                <div class="col-12 col-sm-6 col-md-3">
                    <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.6px;">
                        TIPO DE DOCUMENTO
                    </small>
                    <strong class="text-dark d-block" style="font-size: 14.5px; font-weight: 700;">
                        {{ $documento->tipoDoc->nombre ?? 'Procedimiento' }}
                    </strong>
                </div>

                <!-- 3. Responsable de Revisión -->
                <div class="col-12 col-sm-6 col-md-3">
                    <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.6px;">
                        RESPONSABLE DE REVISIÓN
                    </small>
                    <strong class="text-dark d-block" style="font-size: 14.5px; font-weight: 700;">
                        {{ $responsableNombre }}
                    </strong>
                </div>

                <!-- 4. Fecha Entrada Vigencia -->
                <div class="col-12 col-sm-6 col-md-3">
                    <small class="text-uppercase text-muted fw-bold d-block mb-1" style="font-size: 10.5px; letter-spacing: 0.6px;">
                        FECHA ENTRADA VIGENCIA
                    </small>
                    <strong class="text-dark d-block" style="font-size: 14.5px; font-weight: 700;">
                        {{ $fechaEntrada }}
                    </strong>
                </div>
            </div>
        </div>

        <!-- ======= CARD PRINCIPAL: LÍNEA DE TIEMPO / HISTORIAL DE CAMBIOS ======= -->
        <div class="card border rounded-4 bg-white shadow-sm p-4 mb-4" style="border-color: #e2e8f0 !important;">
            
            <!-- Barra de Filtros del Historial -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-4 mb-4 border-bottom" style="border-color: #f1f5f9 !important;">
                <form method="GET" action="{{ route('sgc.versiones.historial-view', $documento->id) }}" class="d-flex flex-wrap align-items-center gap-2 w-100" id="formFiltroHistorial">
                    
                    <span class="fw-bold text-dark me-1" style="font-size: 13.5px;">
                        Filtrar historial:
                    </span>

                    <!-- Selector Tipo de Cambio -->
                    <div class="position-relative">
                        <select name="tipo_cambio" class="form-select form-select-sm bg-white border rounded-3 px-3 py-1.5 fw-semibold text-dark shadow-xs" style="font-size: 13px; min-width: 190px;" onchange="this.form.submit()">
                            <option value="all" {{ ($tipoCambio === 'all' || empty($tipoCambio)) ? 'selected' : '' }}>Tipo de Cambio: Todos</option>
                            <option value="estado" {{ $tipoCambio === 'estado' ? 'selected' : '' }}>Cambio de estado</option>
                            <option value="correccion" {{ $tipoCambio === 'correccion' ? 'selected' : '' }}>Corrección</option>
                            <option value="contenido" {{ $tipoCambio === 'contenido' ? 'selected' : '' }}>Actualización de contenido</option>
                            <option value="inicial" {{ $tipoCambio === 'inicial' ? 'selected' : '' }}>Creación inicial</option>
                        </select>
                    </div>

                    <!-- Selector Rango de Fechas / Display -->
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 border rounded-3 bg-white text-muted shadow-xs" style="font-size: 13px; cursor: pointer;" title="Período de auditoría histórico">
                        <i class="far fa-calendar-alt text-secondary"></i>
                        <span>15-Oct-2021 a 15-Ene-2024</span>
                    </div>

                    @if($tipoCambio !== 'all' && !empty($tipoCambio))
                        <a href="{{ route('sgc.versiones.historial-view', $documento->id) }}" class="text-danger small text-decoration-none fw-bold ms-auto">
                            <i class="fas fa-times-circle me-1"></i>Quitar filtro
                        </a>
                    @endif
                </form>
            </div>

            <!-- Estructura de Línea de Tiempo Vertical Exacta del Mockup -->
            <div class="timeline-container position-relative px-2 py-1">
                @forelse($timelineEvents as $event)
                    @php
                        // Estilos de los puntos según el tipo de cambio
                        $dotColorClass = match($event['dot_color']) {
                            'green' => 'background-color: #22c55e; border: 3px solid #ffffff; box-shadow: 0 0 0 1.5px #86efac;',
                            'orange' => 'background-color: #f97316; border: 3px solid #ffffff; box-shadow: 0 0 0 1.5px #fdba74;',
                            'blue' => 'background-color: #0284c7; border: 3px solid #ffffff; box-shadow: 0 0 0 1.5px #7dd3fc;',
                            default => 'background-color: #22c55e; border: 3px solid #ffffff; box-shadow: 0 0 0 1.5px #86efac;'
                        };
                    @endphp

                    <div class="timeline-item position-relative mb-4 ps-4 pb-1">
                        <!-- Punto Conector de la Línea -->
                        <div class="timeline-dot position-absolute rounded-circle" style="{{ $dotColorClass }} width: 14px; height: 14px; left: 0px; top: 4px; z-index: 2;"></div>

                        <!-- Encabezado del Evento: Versión + Badge + Fecha a la derecha -->
                        <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <strong class="text-dark fw-bold" style="font-size: 15px; font-family: 'Outfit', sans-serif;">
                                    {{ $event['version_label'] }}
                                </strong>
                                <span class="badge px-2 py-0.5 fw-semibold" style="background-color: {{ $event['badge_bg'] }}; color: {{ $event['badge_text'] }}; font-size: 11.5px; border-radius: 6px;">
                                    {{ $event['tipo_badge'] }}
                                </span>
                            </div>

                            <span class="text-muted" style="font-size: 12.5px;">
                                {{ $event['fecha_hora'] }}
                            </span>
                        </div>

                        <!-- Línea de Autoría: Por: Nombre (Rol) -->
                        <div class="text-secondary fw-semibold mb-1" style="font-size: 13px; color: #475569 !important;">
                            {{ $event['autor'] }}
                        </div>

                        <!-- Cuerpo de la Descripción / Modificaciones -->
                        <p class="mb-0 text-muted" style="font-size: 13.5px; line-height: 1.5; color: #64748b !important;">
                            {{ $event['descripcion'] }}
                        </p>

                        <!-- Botón de Descarga si existe archivo de versión -->
                        @if(isset($event['download_url']) && $event['download_url'] !== '#')
                            <div class="mt-2">
                                <a href="{{ $event['download_url'] }}" class="btn btn-sm btn-light border text-secondary px-2.5 py-1 rounded-2 shadow-xs d-inline-flex align-items-center gap-1.5" style="font-size: 11.5px;">
                                    <i class="fas fa-file-arrow-down text-success"></i>
                                    <span>Descargar adjunto ({{ $event['archivo_formato'] ?? 'PDF' }})</span>
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-timeline fs-2 mb-2 text-secondary opacity-50"></i>
                        <p class="mb-0">No se encontraron eventos para los criterios seleccionados.</p>
                    </div>
                @endforelse
            </div>

        </div>

    @else
        <!-- Alerta si no hay documentos -->
        <div class="card border rounded-4 bg-white shadow-sm p-5 text-center">
            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background-color: #f1f5f9; color: #94a3b8;">
                <i class="fas fa-folder-open fs-3"></i>
            </div>
            <h5 class="fw-bold text-dark mb-1">No hay documentos registrados</h5>
            <p class="text-muted small mb-3">Registre un documento en el Listado Maestro para consultar su historial de versiones.</p>
            <a href="{{ route('sgc.documentos.index') }}" class="btn text-white px-3 py-2 rounded-3 fw-semibold mx-auto" style="background-color: #39A900; width: fit-content;">
                Ir a Listado Maestro
            </a>
        </div>
    @endif

</div>

<!-- Estilos para la línea vertical continua del Timeline -->
<style>
    .timeline-container {
        position: relative;
    }
    
    /* Línea vertical que conecta los puntos */
    .timeline-container::before {
        content: '';
        position: absolute;
        top: 10px;
        bottom: 24px;
        left: 13px;
        width: 2px;
        background-color: #e2e8f0;
        z-index: 1;
    }

    .timeline-item {
        position: relative;
        transition: all 0.2s ease-in-out;
    }

    .timeline-item:hover {
        background-color: rgba(248, 250, 252, 0.6);
        border-radius: 8px;
    }

    .shadow-xs {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
</style>
@endsection
