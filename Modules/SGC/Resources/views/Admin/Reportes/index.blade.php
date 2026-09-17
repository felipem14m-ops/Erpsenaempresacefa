@extends('sgc::layouts.master')

@section('title', 'Consola de Reportes SGC • SENA')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= PAGE HEADER ======= -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">
            Consola de Reportes SGC
        </h2>
        <p class="text-secondary small mb-0" style="font-size: 14px;">
            Genere y descargue reportes del estado documental, solicitudes de cambio e indicadores clave.
        </p>
    </div>

    <!-- ======= TOP KPI CARDS (ROW OF 4) ======= -->
    <div class="row g-3 mb-4">
        
        <!-- Card 1: Total Documentos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-2xs h-100 kpi-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 48px; height: 48px; background-color: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5zM3 3H2v1h1z"/>
                            <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1z"/>
                            <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5zM2 7h1v1H2zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm1 .5H2v1h1z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-uppercase fw-bold text-secondary" style="font-size: 11px; letter-spacing: 0.5px;">TOTAL DOCUMENTOS</div>
                        <div class="fw-bolder text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $totalDocumentos }}</div>
                        <div class="text-muted small" style="font-size: 11.5px;">Listado maestro total</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Solicitudes del Mes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-2xs h-100 kpi-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 48px; height: 48px; background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                            <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-uppercase fw-bold text-secondary" style="font-size: 11px; letter-spacing: 0.5px;">SOLICITUDES DEL MES</div>
                        <div class="fw-bolder text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $solicitudesMes }}</div>
                        <div class="text-muted small" style="font-size: 11.5px;">Procesadas en {{ $mesNombre }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Tasa de Aprobación -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-2xs h-100 kpi-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 48px; height: 48px; background-color: #eff6ff; color: #0284c7; border: 1px solid #dbeafe;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16">
                            <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-uppercase fw-bold text-secondary" style="font-size: 11px; letter-spacing: 0.5px;">TASA DE APROBACIÓN</div>
                        <div class="fw-bolder text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $tasaAprobacion }}</div>
                        <div class="text-muted small" style="font-size: 11.5px;">Indicador general SGC</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Docs por Vencer -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-2xs h-100 kpi-stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 48px; height: 48px; background-color: #fef2f2; color: #ef4444; border: 1px solid #fee2e2;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-uppercase fw-bold text-secondary" style="font-size: 11px; letter-spacing: 0.5px;">DOCS POR VENCER</div>
                        <div class="fw-bolder text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $docsPorVencer }}</div>
                        <div class="text-muted small" style="font-size: 11.5px;">Próximos 30 días</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ======= MAIN 2-COLUMN LAYOUT ======= -->
    <div class="row g-4">

        <!-- ============================================== -->
        <!-- COLUMN 1 (LEFT): GENERAR NUEVO REPORTE         -->
        <!-- ============================================== -->
        <div class="col-12 col-lg-7">
            <div class="card border rounded-4 bg-white shadow-2xs p-4 h-100">
                
                <h5 class="fw-bold text-dark mb-4" style="font-size: 18px; font-family: 'Outfit', sans-serif;">
                    Generar Nuevo Reporte
                </h5>

                <form action="{{ route('sgc.reportes.generar') }}" method="POST" target="_blank" id="form-generar-reporte">
                    @csrf

                    <!-- 1. Tipo de Reporte -->
                    <div class="mb-4">
                        <label for="tipo_reporte" class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11.5px; letter-spacing: 0.5px;">
                            TIPO DE REPORTE
                        </label>
                        <select name="tipo_reporte" id="tipo_reporte" class="form-select form-select-custom rounded-3 py-2 px-3" style="font-size: 14px; border-color: #e2e8f0; color: #1e293b;">
                            <option value="listado_maestro" selected>Inventario Documental (Listado Maestro)</option>
                            <option value="solicitudes">Solicitudes de Creación y Cambio</option>
                            <option value="bitacora">Bitácora de Trazabilidad y Auditoría</option>
                            <option value="indicadores">Indicadores de Eficacia y Calidad</option>
                            <option value="historico">Histórico de Versiones y Control de Cambios</option>
                            <option value="proximos_vencer">Documentos Próximos a Vencer</option>
                        </select>
                    </div>

                    <!-- 2. Rango de Fechas (Inicio / Fin) -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label for="fecha_inicio" class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11.5px; letter-spacing: 0.5px;">
                                FECHA INICIO
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3" style="border-color: #e2e8f0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                        <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                        <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                    </svg>
                                </span>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" 
                                       class="form-control border-start-0 rounded-end-3 py-2" 
                                       value="{{ $fechaInicioDefecto }}" 
                                       style="font-size: 14px; border-color: #e2e8f0; color: #1e293b;">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="fecha_fin" class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11.5px; letter-spacing: 0.5px;">
                                FECHA FIN
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3" style="border-color: #e2e8f0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                        <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                        <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                    </svg>
                                </span>
                                <input type="date" name="fecha_fin" id="fecha_fin" 
                                       class="form-control border-start-0 rounded-end-3 py-2" 
                                       value="{{ $fechaFinDefecto }}" 
                                       style="font-size: 14px; border-color: #e2e8f0; color: #1e293b;">
                            </div>
                        </div>
                    </div>

                    <!-- 3. Proceso / Área -->
                    <div class="mb-4">
                        <label for="proceso_id" class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11.5px; letter-spacing: 0.5px;">
                            PROCESO / ÁREA
                        </label>
                        <select name="proceso_id" id="proceso_id" class="form-select form-select-custom rounded-3 py-2 px-3" style="font-size: 14px; border-color: #e2e8f0; color: #1e293b;">
                            <option value="todos" selected>Todos los Procesos (General)</option>
                            @foreach($procesos as $proc)
                                <option value="{{ $proc->id }}">{{ $proc->codigo }} - {{ $proc->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 4. Formato de Exportación -->
                    <div class="mb-4">
                        <label class="form-label text-uppercase text-secondary fw-bold mb-2" style="font-size: 11.5px; letter-spacing: 0.5px;">
                            FORMATO DE EXPORTACIÓN
                        </label>
                        <div class="d-flex flex-wrap align-items-center gap-4 mt-1">
                            <div class="form-check custom-radio-sgc">
                                <input class="form-check-input" type="radio" name="formato" id="formato_pdf" value="pdf" checked>
                                <label class="form-check-label fw-semibold text-dark ps-1" for="formato_pdf" style="font-size: 14px;">
                                    Documento PDF (.pdf)
                                </label>
                            </div>
                            <div class="form-check custom-radio-sgc">
                                <input class="form-check-input" type="radio" name="formato" id="formato_excel" value="excel">
                                <label class="form-check-label fw-semibold text-dark ps-1" for="formato_excel" style="font-size: 14px;">
                                    Hoja de Cálculo Excel (.xlsx)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="btn text-white w-100 py-3 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-xs btn-generate-sgc">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
                                <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1z"/>
                            </svg>
                            <span>Generar Reporte del Sistema</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        <!-- ============================================== -->
        <!-- COLUMN 2 (RIGHT): REPORTES GENERADOS RECIENTES -->
        <!-- ============================================== -->
        <div class="col-12 col-lg-5">
            <div class="card border rounded-4 bg-white shadow-2xs p-4 h-100">
                
                <h5 class="fw-bold text-dark mb-4" style="font-size: 18px; font-family: 'Outfit', sans-serif;">
                    Reportes Generados Recientes
                </h5>

                <div class="d-flex flex-column gap-3">
                    
                    <!-- Item 1: Listado Maestro Vigentes PDF -->
                    <div class="recent-report-item border rounded-3 p-3 bg-white d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3 overflow-hidden">
                            <span class="badge px-2 py-1 fw-bold rounded-2 flex-shrink-0" 
                                  style="background-color: #fef2f2; color: #dc2626; font-size: 11px; letter-spacing: 0.5px; border: 1px solid #fee2e2;">
                                PDF
                            </span>
                            <div class="text-truncate">
                                <div class="fw-semibold text-dark text-truncate" style="font-size: 13.5px;" title="Listado_Maestro_Vigentes_Angostura.pdf">
                                    Listado_Maestro_Vigentes_Angostura.p...
                                </div>
                                <div class="text-muted small" style="font-size: 11.5px;">
                                    Generado: Hoy, 10:45 AM
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('sgc.reportes.generar', ['tipo_reporte' => 'listado_maestro', 'formato' => 'pdf']) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-light border rounded-3 p-2 text-secondary btn-download-icon flex-shrink-0"
                           title="Descargar Reporte PDF">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Item 2: Solicitudes Procesadas XLSX -->
                    <div class="recent-report-item border rounded-3 p-3 bg-white d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3 overflow-hidden">
                            <span class="badge px-2 py-1 fw-bold rounded-2 flex-shrink-0" 
                                  style="background-color: #f0fdf4; color: #16a34a; font-size: 11px; letter-spacing: 0.5px; border: 1px solid #dcfce7;">
                                XLSX
                            </span>
                            <div class="text-truncate">
                                <div class="fw-semibold text-dark text-truncate" style="font-size: 13.5px;" title="Solicitudes_Procesadas_Q1_2024.xlsx">
                                    Solicitudes_Procesadas_Q1_2024.xlsx
                                </div>
                                <div class="text-muted small" style="font-size: 11.5px;">
                                    Generado: Ayer, 03:15 PM
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('sgc.reportes.generar', ['tipo_reporte' => 'solicitudes', 'formato' => 'excel']) }}" 
                           class="btn btn-sm btn-light border rounded-3 p-2 text-secondary btn-download-icon flex-shrink-0"
                           title="Descargar Archivo Excel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Item 3: Indicadores Gestion Calidad PDF -->
                    <div class="recent-report-item border rounded-3 p-3 bg-white d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3 overflow-hidden">
                            <span class="badge px-2 py-1 fw-bold rounded-2 flex-shrink-0" 
                                  style="background-color: #fef2f2; color: #dc2626; font-size: 11px; letter-spacing: 0.5px; border: 1px solid #fee2e2;">
                                PDF
                            </span>
                            <div class="text-truncate">
                                <div class="fw-semibold text-dark text-truncate" style="font-size: 13.5px;" title="Indicadores_Gestion_Calidad_Anual.pdf">
                                    Indicadores_Gestion_Calidad_Anual.pdf
                                </div>
                                <div class="text-muted small" style="font-size: 11.5px;">
                                    Generado: 15-Ene-2024
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('sgc.reportes.generar', ['tipo_reporte' => 'indicadores', 'formato' => 'pdf']) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-light border rounded-3 p-2 text-secondary btn-download-icon flex-shrink-0"
                           title="Descargar Reporte PDF">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Item 4: Bitacora Trazabilidad Auditoria XLSX -->
                    <div class="recent-report-item border rounded-3 p-3 bg-white d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3 overflow-hidden">
                            <span class="badge px-2 py-1 fw-bold rounded-2 flex-shrink-0" 
                                  style="background-color: #f0fdf4; color: #16a34a; font-size: 11px; letter-spacing: 0.5px; border: 1px solid #dcfce7;">
                                XLSX
                            </span>
                            <div class="text-truncate">
                                <div class="fw-semibold text-dark text-truncate" style="font-size: 13.5px;" title="Bitacora_Trazabilidad_Auditoria_SGC.xlsx">
                                    Bitacora_Trazabilidad_Auditoria_SGC.xl...
                                </div>
                                <div class="text-muted small" style="font-size: 11.5px;">
                                    Generado: 10-Ene-2024
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('sgc.reportes.generar', ['tipo_reporte' => 'bitacora', 'formato' => 'excel']) }}" 
                           class="btn btn-sm btn-light border rounded-3 p-2 text-secondary btn-download-icon flex-shrink-0"
                           title="Descargar Archivo Excel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Item 5: Listado Maestro Historico Obsoletos XLSX -->
                    <div class="recent-report-item border rounded-3 p-3 bg-white d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3 overflow-hidden">
                            <span class="badge px-2 py-1 fw-bold rounded-2 flex-shrink-0" 
                                  style="background-color: #f0fdf4; color: #16a34a; font-size: 11px; letter-spacing: 0.5px; border: 1px solid #dcfce7;">
                                XLSX
                            </span>
                            <div class="text-truncate">
                                <div class="fw-semibold text-dark text-truncate" style="font-size: 13.5px;" title="Listado_Maestro_Historico_Obsoletos.xlsx">
                                    Listado_Maestro_Historico_Obsoletos.x...
                                </div>
                                <div class="text-muted small" style="font-size: 11.5px;">
                                    Generado: 05-Ene-2024
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('sgc.reportes.generar', ['tipo_reporte' => 'historico', 'formato' => 'excel']) }}" 
                           class="btn btn-sm btn-light border rounded-3 p-2 text-secondary btn-download-icon flex-shrink-0"
                           title="Descargar Archivo Excel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                            </svg>
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

@push('styles')
<style>
    .shadow-2xs {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .kpi-stat-card {
        border-color: #e8edf2 !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05) !important;
    }

    .form-select-custom, .form-control {
        border-color: #e2e8f0;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-select-custom:focus, .form-control:focus {
        border-color: #39A900 !important;
        box-shadow: 0 0 0 0.25rem rgba(57, 169, 0, 0.15) !important;
    }

    .custom-radio-sgc .form-check-input {
        width: 1.15em;
        height: 1.15em;
        margin-top: 0.15em;
        border-color: #cbd5e1;
    }
    .custom-radio-sgc .form-check-input:checked {
        background-color: #39A900;
        border-color: #39A900;
    }
    .custom-radio-sgc .form-check-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(57, 169, 0, 0.2);
    }

    .btn-generate-sgc {
        background-color: #39A900;
        border: none;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }
    .btn-generate-sgc:hover {
        background-color: #2e8500;
        transform: translateY(-1px);
    }
    .btn-generate-sgc:active {
        transform: translateY(0);
    }

    .recent-report-item {
        border-color: #edf2f7 !important;
        transition: background-color 0.15s ease, border-color 0.15s ease, transform 0.15s ease;
    }
    .recent-report-item:hover {
        background-color: #f8fafc !important;
        border-color: #cbd5e1 !important;
        transform: translateX(2px);
    }

    .btn-download-icon {
        border-color: #e2e8f0 !important;
        background-color: #ffffff !important;
        transition: all 0.2s ease;
    }
    .btn-download-icon:hover {
        background-color: #f0fdf4 !important;
        border-color: #39A900 !important;
        color: #39A900 !important;
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('form-generar-reporte');
        const formatoPdf = document.getElementById('formato_pdf');
        
        form.addEventListener('submit', function() {
            if (formatoPdf.checked) {
                form.setAttribute('target', '_blank');
            } else {
                form.removeAttribute('target');
            }
        });
    });
</script>
@endpush
@endsection
