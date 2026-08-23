<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SGC • Dashboard Responsable de Calidad | SENA Empresa</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/assets/img/cefaempresa.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light" style="font-family: 'Inter', sans-serif;">

    <div class="container-fluid min-vh-100 p-0">
        <div class="row g-0 min-vh-100">

            <!-- ======= LEFT SIDEBAR ======= -->
            <nav class="col-12 col-md-3 col-lg-2 bg-white border-end d-flex flex-column justify-content-between p-3 position-sticky top-0" style="height: 100vh; z-index: 1020;">
                <div>
                    <!-- Brand Section -->
                    <div class="d-flex align-items-center gap-3 pb-3 mb-2 border-bottom">
                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 42px; height: 42px; background-color: #39A900;">
                            <i class="fas fa-certificate fs-5"></i>
                        </div>
                        <div class="lh-1">
                            <span class="fw-bold text-dark d-block fs-6">SENA</span>
                            <small class="fw-bold text-success" style="font-size: 11px; letter-spacing: 0.5px; color: #39A900 !important;">CALIDAD REGIONAL</small>
                        </div>
                    </div>

                    <!-- Subtitle -->
                    <div class="px-1 mb-3">
                        <small class="text-muted d-block" style="font-size: 11.5px; line-height: 1.3;">
                            Centro de Formación Agroindustrial<br>
                            <strong class="text-dark">La Angostura</strong>
                        </small>
                    </div>

                    <!-- Menu Items -->
                    <div class="nav nav-pills flex-column gap-1">
                        <a href="{{ route('sgc.dashboard') }}" class="nav-link active rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-semibold" style="background-color: #eaf8ea; color: #39A900; border: 1.5px solid #39A900;">
                            <i class="fas fa-house" style="width: 20px;"></i>
                            <span>Inicio</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-clipboard-check text-muted" style="width: 20px;"></i>
                            <span>Revisión de Solicitudes</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-file-signature text-muted" style="width: 20px;"></i>
                            <span>Aprobación y Publicación</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-diagram-project text-muted" style="width: 20px;"></i>
                            <span>Control de Versiones</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-shield-halved text-muted" style="width: 20px;"></i>
                            <span>Matriz ISO 9001</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-chart-pie text-muted" style="width: 20px;"></i>
                            <span>Reportes de Calidad</span>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Bottom: Logout -->
                <div class="pt-3 border-top">
                    <a href="{{ route('logout') }}" class="text-danger text-decoration-none fw-bold d-flex align-items-center gap-2 px-2 py-1 rounded-2">
                        <i class="fas fa-arrow-right-from-bracket"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </nav>

            <!-- ======= MAIN CONTENT ======= -->
            <main class="col-12 col-md-9 col-lg-10 d-flex flex-column min-vh-100">

                <!-- Top Navbar Header -->
                <header class="bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center sticky-top" style="z-index: 1010;">
                    <div class="d-flex align-items-center gap-2">
                        <strong class="fs-6 text-dark">SGC</strong>
                        <span class="text-muted opacity-50">|</span>
                        <span class="text-muted small">Gestión y Control de Calidad Documental</span>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <!-- Notification Button -->
                        <button class="btn btn-light border-0 rounded-circle position-relative p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Notificaciones">
                            <i class="far fa-bell text-secondary"></i>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle"></span>
                        </button>

                        <!-- User Profile Badge -->
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-end d-none d-sm-block">
                                <span class="fw-bold d-block text-dark lh-1" style="font-size: 13.5px;">{{ Auth::user()->full_name ?? 'Responsable de Calidad' }}</span>
                                <span class="badge rounded-pill px-2 py-1 mt-1 fw-bold" style="background-color: #fef3c7; color: #b45309; font-size: 11px;">
                                    Responsable de Calidad
                                </span>
                            </div>
                            <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background-color: #f59e0b; font-size: 13px;">
                                {{ Auth::user()->initials ?? 'RC' }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Dashboard Body -->
                <div class="p-4 p-lg-5 flex-grow-1">

                    <!-- Welcome Title & Action Button -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Bienvenido, {{ Auth::user()->full_name ?? 'Responsable de Calidad' }}</h2>
                            <p class="text-muted small mb-0">Panel de evaluación, aprobación técnica y control de vigencia documental ISO 9001.</p>
                        </div>

                        <div>
                            <a href="javascript:void(0)" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;">
                                <i class="fas fa-check-double"></i>
                                <span>Revisar Solicitudes (12)</span>
                            </a>
                        </div>
                    </div>

                    <!-- 4 Stat Cards Grid -->
                    <div class="row g-3 mb-4">
                        <!-- Stat 1 -->
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #fef9e7; color: #eab308;">
                                        <i class="fas fa-clock-rotate-left fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Pendientes por Evaluar</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">12</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Requieren dictamen técnico</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stat 2 -->
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                                        <i class="fas fa-file-circle-check fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Documentos Vigentes</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">47</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Publicados oficialmente</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stat 3 -->
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #ebf5ff; color: #3b82f6;">
                                        <i class="fas fa-pen-ruler fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">En Modificación (V2)</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">6</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Versiones en borrador</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stat 4 -->
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #ffebee; color: #ef4444;">
                                        <i class="fas fa-triangle-exclamation fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Alertas de Vencimiento</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">5</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Revisión trienal requerida</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom 2-Column Section -->
                    <div class="row g-4">
                        <!-- Left: Bandeja de Aprobación -->
                        <div class="col-12 col-lg-8">
                            <div class="card border rounded-4 bg-white shadow-sm h-100 overflow-hidden">
                                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold text-dark mb-0 fs-6">Bandeja de Aprobación Documental</h5>
                                    <span class="badge bg-warning text-dark px-2 py-1 small fw-bold">12 Pendientes</span>
                                </div>

                                <div class="table-responsive p-2">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                                        <thead class="table-light">
                                            <tr class="text-muted text-uppercase" style="font-size: 12px;">
                                                <th class="border-0 ps-3 py-3">Código</th>
                                                <th class="border-0 py-3">Documento</th>
                                                <th class="border-0 py-3">Área / Solicitante</th>
                                                <th class="border-0 text-end pe-3 py-3">Acción Rápida</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-3 fw-bold text-dark">SOL-041</td>
                                                <td>
                                                    <span class="fw-semibold d-block">Procedimiento de Inseminación Bovina</span>
                                                    <small class="text-muted">PR-AG-004 (Modificación a V2)</small>
                                                </td>
                                                <td>Dr. Hector Gomez (Pecuaria)</td>
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-sm btn-success rounded-2 px-2 py-1" title="Aprobar y Publicar"><i class="fas fa-check"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger rounded-2 px-2 py-1 ms-1" title="Devolver con observaciones"><i class="fas fa-rotate-left"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3 fw-bold text-dark">SOL-039</td>
                                                <td>
                                                    <span class="fw-semibold d-block">Manual de Laboratorio de Suelos</span>
                                                    <small class="text-muted">MA-AG-015 (Creación Nueva)</small>
                                                </td>
                                                <td>Ing. Amanda Ortiz (Agrícola)</td>
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-sm btn-success rounded-2 px-2 py-1" title="Aprobar y Publicar"><i class="fas fa-check"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger rounded-2 px-2 py-1 ms-1" title="Devolver con observaciones"><i class="fas fa-rotate-left"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3 fw-bold text-dark">SOL-037</td>
                                                <td>
                                                    <span class="fw-semibold d-block">Formato de Control Fitosanitario</span>
                                                    <small class="text-muted">FT-AG-008 (Modificación a V3)</small>
                                                </td>
                                                <td>Laura Beltran (Agronomía)</td>
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-sm btn-success rounded-2 px-2 py-1" title="Aprobar y Publicar"><i class="fas fa-check"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger rounded-2 px-2 py-1 ms-1" title="Devolver con observaciones"><i class="fas fa-rotate-left"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Actividad ISO Reciente -->
                        <div class="col-12 col-lg-4">
                            <div class="card border rounded-4 bg-white shadow-sm h-100">
                                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold text-dark mb-0 fs-6">Bitácora ISO de Calidad</h5>
                                    <i class="fas fa-shield-check text-success"></i>
                                </div>

                                <div class="card-body p-4 pt-2 d-flex flex-column gap-3">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                                        <div>
                                            <p class="mb-0 text-dark small"><strong>Publicación atómica:</strong> PR-CA-001 (V2) pasó a Vigente.</p>
                                            <small class="text-muted" style="font-size: 11.5px;">Hace 12 min</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #ef4444; box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);"></div>
                                        <div>
                                            <p class="mb-0 text-dark small"><strong>Deprecación:</strong> PR-CA-001 (V1) archivado como Obsoleto.</p>
                                            <small class="text-muted" style="font-size: 11.5px;">Hace 12 min</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                                        <div>
                                            <p class="mb-0 text-dark small"><strong>Revisión IA:</strong> Análisis de coherencia ejecutado en SOL-041.</p>
                                            <small class="text-muted" style="font-size: 11.5px;">Hace 1 hora</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
