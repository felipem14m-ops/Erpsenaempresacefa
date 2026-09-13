@extends('sgc::layouts.master')

@section('title', 'SGC • Dashboard Responsable de Calidad')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= PAGE HEADER ======= -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
            Bienvenido, Responsable de Calidad
        </h2>
        <p class="text-muted small mb-0" style="font-size: 13.5px;">
            Consola de aprobación y revisión de solicitudes de calidad.
        </p>
    </div>

    <!-- ======= 4 METRIC KPI CARDS (1 ROW x 4 COLS) ======= -->
    <div class="row g-3 mb-4">
        
        <!-- Card 1: Documentos Vigentes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: #f0faf0; color: #39A900; border: 1px solid rgba(57, 169, 0, 0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                            <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-muted fw-bold" style="font-size: 10.5px; letter-spacing: 0.6px; text-transform: uppercase;">
                            Documentos Vigentes
                        </div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
                            {{ $metricVigentes ?? 47 }}
                        </div>
                        <small class="text-muted" style="font-size: 11.5px;">Listado maestro activo</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Solicitudes Pendientes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: #fff7ed; color: #ea580c; border: 1px solid rgba(234, 88, 12, 0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                            <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5"/>
                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-muted fw-bold" style="font-size: 10.5px; letter-spacing: 0.6px; text-transform: uppercase;">
                            Solicitudes Pendientes
                        </div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
                            {{ $metricPendientes ?? 8 }}
                        </div>
                        <small class="text-muted" style="font-size: 11.5px;">Requieren su aprobación</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Documentos por Vencer -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: #fef2f2; color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-muted fw-bold" style="font-size: 10.5px; letter-spacing: 0.6px; text-transform: uppercase;">
                            Documentos por Vencer
                        </div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
                            {{ $metricProximosVencer ?? 5 }}
                        </div>
                        <small class="text-muted" style="font-size: 11.5px;">Revisión próxima 30 días</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Versiones de Hoy -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: #f0f9ff; color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.15);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-bezier2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h1A1.5 1.5 0 0 1 5 2.5h4.141a2.5 2.5 0 0 0 2.41 1.94 2.5 2.5 0 0 0 2.41-1.94H13.5A1.5 1.5 0 0 1 15 2.5v1A1.5 1.5 0 0 1 13.5 5h-1.05a2.5 2.5 0 0 0-2.41-1.94 2.5 2.5 0 0 0-2.41 1.94H5A1.5 1.5 0 0 1 3.5 5h-1A1.5 1.5 0 0 1 1 3.5zM2.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm10 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-muted fw-bold" style="font-size: 10.5px; letter-spacing: 0.6px; text-transform: uppercase;">
                            Versiones de Hoy
                        </div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
                            {{ $metricVersionesHoy ?? 3 }}
                        </div>
                        <small class="text-muted" style="font-size: 11.5px;">Actualizadas hoy</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ======= BOTTOM 2-COLUMN SECTION ======= -->
    <div class="row g-4 align-items-stretch">
        
        <!-- ======= LEFT COLUMN: SOLICITUDES PENDIENTES DE APROBACIÓN ======= -->
        <div class="col-12 col-lg-7">
            <div class="card border rounded-4 bg-white shadow-xs h-100 p-4 d-flex flex-column justify-content-between">
                <div>
                    <!-- Card Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0" style="font-size: 16px; font-family: 'Outfit', sans-serif;">
                            Solicitudes Pendientes de Aprobación
                        </h5>
                        <a href="{{ route('sgc.solicitudes.index') }}" class="text-decoration-none fw-semibold small d-inline-flex align-items-center gap-1" style="color: #39A900; font-size: 13px;">
                            <span>Ver todas</span>
                            <span>→</span>
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                            <thead class="table-light">
                                <tr class="text-muted" style="font-size: 12px; letter-spacing: 0.2px;">
                                    <th class="border-0 ps-3 py-2.5">Número</th>
                                    <th class="border-0 py-2.5">Tipo</th>
                                    <th class="border-0 py-2.5">Solicitante</th>
                                    <th class="border-0 py-2.5">Fecha</th>
                                    <th class="border-0 pe-3 py-2.5">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Row 1 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <a href="{{ route('sgc.solicitudes.index') }}" class="text-decoration-none fw-bold text-dark font-monospace">
                                            SOL-042
                                        </a>
                                    </td>
                                    <td class="py-3 text-secondary">Creación</td>
                                    <td class="py-3 text-dark fw-medium">Ing. Amanda Ortiz</td>
                                    <td class="py-3 text-secondary">18-Ene-2024</td>
                                    <td class="pe-3 py-3">
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fef3c7; color: #d97706; font-size: 11.5px;">
                                            Radicada
                                        </span>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <a href="{{ route('sgc.solicitudes.index') }}" class="text-decoration-none fw-bold text-dark font-monospace">
                                            SOL-041
                                        </a>
                                    </td>
                                    <td class="py-3 text-secondary">Modificación</td>
                                    <td class="py-3 text-dark fw-medium">Dr. Hector Gomez</td>
                                    <td class="py-3 text-secondary">17-Ene-2024</td>
                                    <td class="pe-3 py-3">
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #fef3c7; color: #d97706; font-size: 11.5px;">
                                            Radicada
                                        </span>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <a href="{{ route('sgc.solicitudes.index') }}" class="text-decoration-none fw-bold text-dark font-monospace">
                                            SOL-040
                                        </a>
                                    </td>
                                    <td class="py-3 text-secondary">Eliminación</td>
                                    <td class="py-3 text-dark fw-medium">Laura Beltran</td>
                                    <td class="py-3 text-secondary">15-Ene-2024</td>
                                    <td class="pe-3 py-3">
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #e0f2fe; color: #0284c7; font-size: 11.5px;">
                                            En revisión
                                        </span>
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <a href="{{ route('sgc.solicitudes.index') }}" class="text-decoration-none fw-bold text-dark font-monospace">
                                            SOL-039
                                        </a>
                                    </td>
                                    <td class="py-3 text-secondary">Creación</td>
                                    <td class="py-3 text-dark fw-medium">Ing. Amanda Ortiz</td>
                                    <td class="py-3 text-secondary">12-Ene-2024</td>
                                    <td class="pe-3 py-3">
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #e0f2fe; color: #0284c7; font-size: 11.5px;">
                                            En revisión
                                        </span>
                                    </td>
                                </tr>

                                <!-- Row 5 -->
                                <tr>
                                    <td class="ps-3 py-3">
                                        <a href="{{ route('sgc.solicitudes.index') }}" class="text-decoration-none fw-bold text-dark font-monospace">
                                            SOL-038
                                        </a>
                                    </td>
                                    <td class="py-3 text-secondary">Modificación</td>
                                    <td class="py-3 text-dark fw-medium">Roberto Diaz</td>
                                    <td class="py-3 text-secondary">10-Ene-2024</td>
                                    <td class="pe-3 py-3">
                                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background-color: #e0f2fe; color: #0284c7; font-size: 11.5px;">
                                            En revisión
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======= RIGHT COLUMN: ACTIVIDAD RECIENTE (BITÁCORA) ======= -->
        <div class="col-12 col-lg-5">
            <div class="card border rounded-4 bg-white shadow-xs h-100 p-4 d-flex flex-column justify-content-between">
                <div>
                    <!-- Card Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold text-dark mb-0" style="font-size: 16px; font-family: 'Outfit', sans-serif;">
                            Actividad Reciente (Bitácora)
                        </h5>
                        <div class="text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-activity" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Timeline Items -->
                    <div class="position-relative ps-3">
                        
                        <!-- Timeline Item 1 -->
                        <div class="position-relative pb-4 ps-3" style="border-left: 1.5px solid #e2e8f0;">
                            <span class="position-absolute" style="left: -5px; top: 3px; width: 8px; height: 8px; background-color: #39A900; border-radius: 50%;"></span>
                            <div class="d-flex flex-column">
                                <p class="mb-1 text-dark" style="font-size: 13.5px; line-height: 1.45;">
                                    <strong>Carlos Ruiz (Admin)</strong> aprobó la solicitud <strong>SOL-040</strong>
                                </p>
                                <small class="text-muted" style="font-size: 11.5px;">Hace 5 min</small>
                            </div>
                        </div>

                        <!-- Timeline Item 2 -->
                        <div class="position-relative pb-4 ps-3" style="border-left: 1.5px solid #e2e8f0;">
                            <span class="position-absolute" style="left: -5px; top: 3px; width: 8px; height: 8px; background-color: #39A900; border-radius: 50%;"></span>
                            <div class="d-flex flex-column">
                                <p class="mb-1 text-dark" style="font-size: 13.5px; line-height: 1.45;">
                                    <strong>Sandra Perdomo</strong> subió nueva versión de <strong>PR-CA-001 (V3)</strong>
                                </p>
                                <small class="text-muted" style="font-size: 11.5px;">Hace 23 min</small>
                            </div>
                        </div>

                        <!-- Timeline Item 3 -->
                        <div class="position-relative pb-4 ps-3" style="border-left: 1.5px solid #e2e8f0;">
                            <span class="position-absolute" style="left: -5px; top: 3px; width: 8px; height: 8px; background-color: #39A900; border-radius: 50%;"></span>
                            <div class="d-flex flex-column">
                                <p class="mb-1 text-dark" style="font-size: 13.5px; line-height: 1.45;">
                                    <strong>Hector Gomez</strong> creó solicitud de modificación <strong>SOL-041</strong>
                                </p>
                                <small class="text-muted" style="font-size: 11.5px;">Hace 1 hora</small>
                            </div>
                        </div>

                        <!-- Timeline Item 4 -->
                        <div class="position-relative ps-3" style="border-left: 1.5px solid transparent;">
                            <span class="position-absolute" style="left: -5px; top: 3px; width: 8px; height: 8px; background-color: #39A900; border-radius: 50%;"></span>
                            <div class="d-flex flex-column">
                                <p class="mb-1 text-dark" style="font-size: 13.5px; line-height: 1.45;">
                                    <strong>Sandra Perdomo</strong> marcó obsoleto el documento <strong>FT-SI-024 (V1)</strong>
                                </p>
                                <small class="text-muted" style="font-size: 11.5px;">Hace 3 horas</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
