<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SGC • Dashboard Líder de Área | SENA Empresa</title>

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
                            <i class="fas fa-layer-group fs-5"></i>
                        </div>
                        <div class="lh-1">
                            <span class="fw-bold text-dark d-block fs-6">SENA</span>
                            <small class="fw-bold text-success" style="font-size: 11px; letter-spacing: 0.5px; color: #39A900 !important;">LÍDER DE ÁREA</small>
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
                            <i class="fas fa-file-circle-plus text-muted" style="width: 20px;"></i>
                            <span>Radicar Solicitud</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-folder-open text-muted" style="width: 20px;"></i>
                            <span>Documentos de mi Área</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-table-list text-muted" style="width: 20px;"></i>
                            <span>Formatos y Registros</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-clock-rotate-left text-muted" style="width: 20px;"></i>
                            <span>Historial de Radicados</span>
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
                        <span class="text-muted small">Gestión Documental por Área Funcional</span>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-light border-0 rounded-circle position-relative p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Notificaciones">
                            <i class="far fa-bell text-secondary"></i>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle"></span>
                        </button>

                        <div class="d-flex align-items-center gap-2">
                            <div class="text-end d-none d-sm-block">
                                <span class="fw-bold d-block text-dark lh-1" style="font-size: 13.5px;">{{ Auth::user()->full_name ?? 'Líder de Área' }}</span>
                                <span class="badge rounded-pill px-2 py-1 mt-1 fw-bold" style="background-color: #ebf5ff; color: #1d4ed8; font-size: 11px;">
                                    Líder de Área
                                </span>
                            </div>
                            <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background-color: #3b82f6; font-size: 13px;">
                                {{ Auth::user()->initials ?? 'LA' }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Dashboard Body -->
                <div class="p-4 p-lg-5 flex-grow-1">

                    <!-- Welcome Title & Action Button -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Bienvenido, {{ Auth::user()->full_name ?? 'Líder de Área' }}</h2>
                            <p class="text-muted small mb-0">Radica y gestiona los procedimientos, manuales y formatos de tu unidad de formación.</p>
                        </div>

                        <div>
                            <a href="javascript:void(0)" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;">
                                <i class="fas fa-plus-circle"></i>
                                <span>Radicar Nueva Solicitud</span>
                            </a>
                        </div>
                    </div>

                    <!-- 4 Stat Cards Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                                        <i class="fas fa-folder-closed fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Documentos de mi Área</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">18</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Procedimientos vigentes</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #fef9e7; color: #eab308;">
                                        <i class="fas fa-paper-plane fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Solicitudes en Trámite</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">4</div>
                                        <small class="text-muted" style="font-size: 11.5px;">En revisión por Calidad</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #ebf5ff; color: #3b82f6;">
                                        <i class="fas fa-file-excel fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Formatos Oficiales</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">24</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Plantillas descargables</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #f3e8ff; color: #9333ea;">
                                        <i class="fas fa-circle-check fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Solicitudes Aprobadas</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">14</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Histórico total</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom 2 Columns -->
                    <div class="row g-4">
                        <div class="col-12 col-lg-8">
                            <div class="card border rounded-4 bg-white shadow-sm h-100 overflow-hidden">
                                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold text-dark mb-0 fs-6">Mis Solicitudes Radicadas</h5>
                                    <a href="javascript:void(0)" class="text-decoration-none fw-semibold small" style="color: #39A900;">Ver historial <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                                <div class="table-responsive p-2">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                                        <thead class="table-light">
                                            <tr class="text-muted text-uppercase" style="font-size: 12px;">
                                                <th class="border-0 ps-3 py-3">Radicado</th>
                                                <th class="border-0 py-3">Tipo</th>
                                                <th class="border-0 py-3">Documento</th>
                                                <th class="border-0 pe-3 py-3">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-3 fw-bold text-dark">SOL-042</td>
                                                <td class="text-secondary small">Creación</td>
                                                <td>Procedimiento de Manejo de Residuos Pecuarios</td>
                                                <td class="pe-3"><span class="badge rounded-2 px-2 py-1" style="background-color: #f1f5f9; color: #475569;">Radicada</span></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3 fw-bold text-dark">SOL-039</td>
                                                <td class="text-secondary small">Creación</td>
                                                <td>Manual de Laboratorio de Suelos</td>
                                                <td class="pe-3"><span class="badge rounded-2 px-2 py-1" style="background-color: #fef3c7; color: #b45309;">En revisión</span></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3 fw-bold text-dark">SOL-035</td>
                                                <td class="text-secondary small">Modificación</td>
                                                <td>Formato de Asistencia Técnica Agropecuaria</td>
                                                <td class="pe-3"><span class="badge rounded-2 px-2 py-1" style="background-color: #def7ec; color: #03543f;">Aprobada (V2)</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="card border rounded-4 bg-white shadow-sm h-100">
                                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold text-dark mb-0 fs-6">Novedades de mi Área</h5>
                                    <i class="fas fa-bell text-muted"></i>
                                </div>
                                <div class="card-body p-4 pt-2 d-flex flex-column gap-3">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                                        <div>
                                            <p class="mb-0 text-dark small"><strong>Calidad aprobó:</strong> SOL-035 quedó publicada como vigente.</p>
                                            <small class="text-muted" style="font-size: 11.5px;">Ayer, 4:30 PM</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);"></div>
                                        <div>
                                            <p class="mb-0 text-dark small"><strong>Radicado exitoso:</strong> Se generó código SOL-042 para revisión.</p>
                                            <small class="text-muted" style="font-size: 11.5px;">Hoy, 9:15 AM</small>
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
