@extends('sgc::layouts.master')

@section('title', 'SGC • Reportes de Gestión de Calidad')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= PAGE HEADER ======= -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
            Reportes del SGC
        </h2>
        <p class="text-muted small mb-0" style="font-size: 13.5px;">
            Indicadores generales de calidad y exportación de información.
        </p>
    </div>

    <!-- ======= 4 INTERACTIVE INDICATOR CARDS (2x2 GRID) ======= -->
    <div class="row g-3 mb-4">
        
        <!-- Card 1: Documentos Vigentes -->
        <div class="col-12 col-md-6">
            <div class="card border rounded-4 p-3 bg-white shadow-xs h-100 report-card-tab cursor-pointer {{ request('tab') == 'vigentes' ? 'active-report-card' : '' }}" 
                 id="card-tab-vigentes"
                 onclick="switchReportTab('vigentes')"
                 style="cursor: pointer; transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900; border: 1px solid rgba(57, 169, 0, 0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size: 12px;">Documentos Vigentes</div>
                        <div class="fs-4 fw-bold text-dark lh-1 mt-1">{{ $metricVigentes }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Próximos a Vencer (Default Selected in Mockup) -->
        <div class="col-12 col-md-6">
            <div class="card border rounded-4 p-3 bg-white shadow-xs h-100 report-card-tab cursor-pointer {{ request('tab', 'proximos_vencer') == 'proximos_vencer' ? 'active-report-card' : '' }}" 
                 id="card-tab-proximos_vencer"
                 onclick="switchReportTab('proximos_vencer')"
                 style="cursor: pointer; transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #fef3c7; color: #d97706; border: 1px solid rgba(217, 119, 6, 0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size: 12px;">Próximos a Vencer</div>
                        <div class="fs-4 fw-bold lh-1 mt-1" style="color: #ea580c;">{{ $totalProximosVencer }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Actividad por Proceso -->
        <div class="col-12 col-md-6">
            <div class="card border rounded-4 p-3 bg-white shadow-xs h-100 report-card-tab cursor-pointer {{ request('tab') == 'actividad_proceso' ? 'active-report-card' : '' }}" 
                 id="card-tab-actividad_proceso"
                 onclick="switchReportTab('actividad_proceso')"
                 style="cursor: pointer; transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #e0f2fe; color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size: 12px;">Actividad por Proceso</div>
                        <div class="fw-bold text-dark lh-1 mt-1" style="font-size: 14.5px;">Ver gráficas de cambios</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Exportación para Auditoría -->
        <div class="col-12 col-md-6">
            <div class="card border rounded-4 p-3 bg-white shadow-xs h-100 report-card-tab cursor-pointer {{ request('tab') == 'auditoria' ? 'active-report-card' : '' }}" 
                 id="card-tab-auditoria"
                 onclick="switchReportTab('auditoria')"
                 style="cursor: pointer; transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16">
                            <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-muted fw-semibold" style="font-size: 12px;">Exportación para Auditoría</div>
                        <div class="fw-bold text-dark lh-1 mt-1" style="font-size: 14.5px;">Descargar archivo maestro</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ======= SELECTED REPORT CONTAINER ======= -->
    <div class="card border rounded-4 bg-white shadow-xs p-4 overflow-hidden mb-4" id="report-container">
        
        <!-- Header: Selected Report Title + Export Buttons -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom">
            <div>
                <h5 class="fw-bold text-dark mb-1" id="report-title" style="font-size: 17px; font-family: 'Outfit', sans-serif;">
                    Reporte Seleccionado: Próximos a Vencer
                </h5>
                <p class="text-muted small mb-0" id="report-subtitle" style="font-size: 12.5px;">
                    Lista de documentos próximos a requerir actualización obligatoria.
                </p>
            </div>

            <!-- Action Buttons: Descargar PDF & Descargar Excel -->
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-white border rounded-3 px-3 py-2 fw-semibold text-secondary d-inline-flex align-items-center gap-2 shadow-2xs" style="background-color: #ffffff; font-size: 13.5px;" onclick="imprimirReporte()">
                    <i class="fas fa-file-pdf text-danger"></i>
                    <span>Descargar PDF</span>
                </button>

                <a href="{{ route('sgc.reportes.export.excel', ['tipo' => 'proximos_vencer']) }}" id="btn-export-excel" class="btn text-white rounded-3 px-3 py-2 fw-bold d-inline-flex align-items-center gap-2 shadow-xs" style="background-color: #39A900; border: none; font-size: 13.5px;">
                    <i class="fas fa-file-excel"></i>
                    <span>Descargar Excel</span>
                </a>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: PRÓXIMOS A VENCER (DEFAULT VIEW)    -->
        <!-- ========================================== -->
        <div class="report-content-panel" id="panel-proximos_vencer">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                    <thead class="table-light">
                        <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.5px;">
                            <th class="border-0 ps-3 py-3">Código</th>
                            <th class="border-0 py-3">Nombre del Documento</th>
                            <th class="border-0 py-3">Proceso</th>
                            <th class="border-0 py-3">Días Restantes</th>
                            <th class="border-0 pe-3 py-3">Responsable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proximosList as $item)
                            <tr>
                                <!-- Código -->
                                <td class="ps-3 py-3">
                                    <span class="fw-bold text-dark font-monospace" style="font-size: 13.5px;">
                                        {{ $item['codigo'] }}
                                    </span>
                                </td>

                                <!-- Nombre del Documento -->
                                <td class="py-3">
                                    <span class="text-dark fw-medium">{{ $item['nombre'] }}</span>
                                </td>

                                <!-- Proceso -->
                                <td class="py-3">
                                    <span class="text-secondary">{{ $item['proceso'] }}</span>
                                </td>

                                <!-- Días Restantes -->
                                <td class="py-3">
                                    @if($item['dias_restantes'] <= 15)
                                        <span class="fw-bold text-danger">{{ $item['dias_restantes'] }} días</span>
                                    @elseif($item['dias_restantes'] <= 30)
                                        <span class="fw-bold" style="color: #ea580c;">{{ $item['dias_restantes'] }} días</span>
                                    @else
                                        <span class="fw-semibold text-warning-emphasis">{{ $item['dias_restantes'] }} días</span>
                                    @endif
                                </td>

                                <!-- Responsable -->
                                <td class="pe-3 py-3">
                                    <span class="text-secondary">{{ $item['responsable'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No hay documentos en periodo crítico de vencimiento.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-top px-4 py-3 bg-white text-muted small">
                Mostrando {{ count($proximosVencer) }} documentos próximos a revisión / vencimiento
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: DOCUMENTOS VIGENTES                 -->
        <!-- ========================================== -->
        <div class="report-content-panel d-none" id="panel-vigentes">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                    <thead class="table-light">
                        <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.5px;">
                            <th class="border-0 ps-3 py-3">Código</th>
                            <th class="border-0 py-3">Nombre del Documento</th>
                            <th class="border-0 py-3">Proceso</th>
                            <th class="border-0 py-3">Área</th>
                            <th class="border-0 py-3">Tipo</th>
                            <th class="border-0 py-3">Versión</th>
                            <th class="border-0 pe-3 py-3">Responsable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documentosVigentes as $doc)
                            <tr>
                                <td class="ps-3 py-3">
                                    <span class="fw-bold text-dark font-monospace">{{ $doc->codigo }}</span>
                                </td>
                                <td class="py-3">
                                    <strong class="text-dark">{{ $doc->nombre }}</strong>
                                </td>
                                <td class="py-3">
                                    <span class="text-secondary">{{ $doc->proceso->nombre ?? 'N/A' }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="text-secondary">{{ $doc->area->nombre ?? 'N/A' }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-secondary border">{{ $doc->tipoDoc->codigo ?? 'PR' }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="badge rounded-pill text-success bg-success-subtle fw-semibold">V.{{ $doc->versionActual->numero_version ?? '1.0' }}</span>
                                </td>
                                <td class="pe-3 py-3">
                                    <span class="text-secondary">{{ $doc->responsable->nombre_completo ?? ($doc->responsable->nombre_usuario ?? 'Carlos Alberto Ruiz') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No hay documentos vigentes registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-top px-4 py-3 bg-white text-muted small">
                Mostrando {{ $documentosVigentes->count() }} documentos vigentes del SGC
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 3: ACTIVIDAD POR PROCESO               -->
        <!-- ========================================== -->
        <div class="report-content-panel d-none" id="panel-actividad_proceso">
            <div class="row g-3 mb-3">
                @foreach($procesosActividad as $proc)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card border rounded-3 p-3 bg-light bg-opacity-50">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success fw-bold">{{ $proc['codigo'] }}</span>
                                <small class="fw-bold text-success">{{ $proc['cumplimiento'] }} Actualizado</small>
                            </div>
                            <h6 class="fw-bold text-dark mb-2">{{ $proc['nombre'] }}</h6>
                            <div class="d-flex justify-content-between text-muted small">
                                <span>Docs Vigentes: <strong class="text-dark">{{ $proc['vigentes'] }}</strong></span>
                                <span>Trámites: <strong class="text-dark">{{ $proc['solicitudes'] }}</strong></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 4: EXPORTACIÓN PARA AUDITORÍA          -->
        <!-- ========================================== -->
        <div class="report-content-panel d-none" id="panel-auditoria">
            <div class="alert alert-light border rounded-3 d-flex align-items-center gap-3 p-3 mb-3">
                <i class="fas fa-shield-halved text-success fs-4"></i>
                <div class="flex-grow-1">
                    <strong class="d-block text-dark">Paquete Oficial de Auditoría de Calidad</strong>
                    <small class="text-muted">Incluye listado maestro vigente, actas de control de cambios y trazabilidad institucional del centro.</small>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                    <thead class="table-light">
                        <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.5px;">
                            <th class="border-0 ps-3 py-3">Registro</th>
                            <th class="border-0 py-3">Acción Registrada</th>
                            <th class="border-0 py-3">Módulo</th>
                            <th class="border-0 py-3">Usuario Auditor / Operador</th>
                            <th class="border-0 pe-3 py-3">Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditoriaLog as $log)
                            <tr>
                                <td class="ps-3 py-3 font-monospace text-muted">#LOG-{{ str_pad($log->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-3">
                                    <strong class="text-dark d-block">{{ $log->descripcion }}</strong>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-secondary border">{{ strtoupper($log->modulo ?: 'SGC') }}</span>
                                </td>
                                <td class="py-3">
                                    <span class="text-secondary">{{ $log->usuario->nombre_completo ?? 'Administrador SGC' }}</span>
                                </td>
                                <td class="pe-3 py-3 text-muted small">
                                    {{ $log->creado_en ? $log->creado_en->format('d/m/Y h:i A') : now()->format('d/m/Y h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No hay registros de trazabilidad recientes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@push('styles')
<style>
    .report-card-tab:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06) !important;
        border-color: rgba(57, 169, 0, 0.3) !important;
    }
    .active-report-card {
        border-color: #39A900 !important;
        background-color: #fbfefb !important;
        box-shadow: 0 4px 14px rgba(57, 169, 0, 0.08) !important;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        #report-container, #report-container * {
            visibility: visible;
        }
        #report-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none !important;
            box-shadow: none !important;
        }
        .main-sidebar, .main-header, button, a {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const reportConfigs = {
        'proximos_vencer': {
            title: 'Reporte Seleccionado: Próximos a Vencer',
            subtitle: 'Lista de documentos próximos a requerir actualización obligatoria.',
            exportType: 'proximos_vencer'
        },
        'vigentes': {
            title: 'Reporte Seleccionado: Documentos Vigentes',
            subtitle: 'Listado maestro de todos los documentos oficiales vigentes en el SGC.',
            exportType: 'vigentes'
        },
        'actividad_proceso': {
            title: 'Reporte Seleccionado: Actividad por Proceso',
            subtitle: 'Distribución y estado de actualización de la documentación por macroprocesos.',
            exportType: 'actividad_proceso'
        },
        'auditoria': {
            title: 'Reporte Seleccionado: Exportación para Auditoría',
            subtitle: 'Consolidado integral de trazabilidad, listado maestro y eventos del sistema.',
            exportType: 'auditoria'
        }
    };

    function switchReportTab(tabKey) {
        // 1. Update Card Active Classes
        document.querySelectorAll('.report-card-tab').forEach(el => el.classList.remove('active-report-card'));
        const activeCard = document.getElementById('card-tab-' + tabKey);
        if (activeCard) {
            activeCard.classList.add('active-report-card');
        }

        // 2. Hide all panels, show selected panel
        document.querySelectorAll('.report-content-panel').forEach(panel => panel.classList.add('d-none'));
        const targetPanel = document.getElementById('panel-' + tabKey);
        if (targetPanel) {
            targetPanel.classList.remove('d-none');
        }

        // 3. Update Title, Subtitle and Excel Download URL
        if (reportConfigs[tabKey]) {
            document.getElementById('report-title').innerText = reportConfigs[tabKey].title;
            document.getElementById('report-subtitle').innerText = reportConfigs[tabKey].subtitle;
            const excelBtn = document.getElementById('btn-export-excel');
            excelBtn.href = "{{ route('sgc.reportes.export.excel') }}?tipo=" + reportConfigs[tabKey].exportType;
        }
    }

    function imprimirReporte() {
        window.print();
    }
</script>
@endpush
@endsection
