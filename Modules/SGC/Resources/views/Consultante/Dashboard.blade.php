<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SGC • Repositorio Documental Consultante | SENA Empresa</title>

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
                            <i class="fas fa-book-bookmark fs-5"></i>
                        </div>
                        <div class="lh-1">
                            <span class="fw-bold text-dark d-block fs-6">SENA</span>
                            <small class="fw-bold text-success" style="font-size: 11px; letter-spacing: 0.5px; color: #39A900 !important;">CONSULTA SGC</small>
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
                            <i class="fas fa-book-open text-muted" style="width: 20px;"></i>
                            <span>Manuales Vigentes</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-list-check text-muted" style="width: 20px;"></i>
                            <span>Procedimientos</span>
                        </a>
                        <a href="javascript:void(0)" class="nav-link text-secondary rounded-3 py-2 px-3 d-flex align-items-center gap-3 fw-medium">
                            <i class="fas fa-file-arrow-down text-muted" style="width: 20px;"></i>
                            <span>Formatos Descargables</span>
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
                        <span class="text-muted small">Repositorio y Consulta Documental Vigente</span>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-end d-none d-sm-block">
                                <span class="fw-bold d-block text-dark lh-1" style="font-size: 13.5px;">{{ Auth::user()->full_name ?? 'Aprendiz / Instructor' }}</span>
                                <span class="badge rounded-pill px-2 py-1 mt-1 fw-bold" style="background-color: #f1f5f9; color: #475569; font-size: 11px;">
                                    Consultante
                                </span>
                            </div>
                            <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background-color: #39A900; font-size: 13px;">
                                {{ Auth::user()->initials ?? 'CO' }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Dashboard Body -->
                <div class="p-4 p-lg-5 flex-grow-1">

                    <!-- Welcome Title & Search Bar -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Bienvenido al Repositorio SGC</h2>
                            <p class="text-muted small mb-0">Consulta y descarga directa de documentación y formatos institucionales autorizados.</p>
                        </div>

                        <div style="min-width: 320px;">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" placeholder="Buscar procedimiento, formato o código...">
                            </div>
                        </div>
                    </div>

                    <!-- 4 Stat Cards Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                                        <i class="fas fa-file-circle-check fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Documentos Vigentes</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">47</div>
                                        <small class="text-muted" style="font-size: 11.5px;">100% autorizados</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #ebf5ff; color: #3b82f6;">
                                        <i class="fas fa-book fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Manuales</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">14</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Guías técnicas</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #fef9e7; color: #eab308;">
                                        <i class="fas fa-file-excel fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Formatos</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">25</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Plantillas en blanco</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #f3e8ff; color: #9333ea;">
                                        <i class="fas fa-robot fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Asistente IA</div>
                                        <div class="fs-3 fw-bold text-dark lh-1 my-1">Activo</div>
                                        <small class="text-muted" style="font-size: 11.5px;">Resúmenes ejecutivos</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Listado Maestro de Documentos Vigentes -->
                    <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0 fs-6">Listado Maestro de Documentos Vigentes</h5>
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1" style="color: #2b8000 !important;">Versiones Vigentes</span>
                        </div>

                        <div class="table-responsive p-2">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                                <thead class="table-light">
                                    <tr class="text-muted text-uppercase" style="font-size: 12px;">
                                        <th class="border-0 ps-3 py-3">Código</th>
                                        <th class="border-0 py-3">Título del Documento</th>
                                        <th class="border-0 py-3">Tipo</th>
                                        <th class="border-0 py-3">Versión</th>
                                        <th class="border-0 py-3">Fecha de Aprobación</th>
                                        <th class="border-0 text-end pe-3 py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-3 fw-bold text-dark">PR-CA-001</td>
                                        <td><span class="fw-semibold">Procedimiento de Control Documental</span></td>
                                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Procedimiento</span></td>
                                        <td><span class="badge bg-success bg-opacity-10 text-success fw-bold">V2</span></td>
                                        <td class="text-muted">15/08/2026</td>
                                        <td class="text-end pe-3">
                                            <button class="btn btn-sm btn-outline-success rounded-2 px-2 py-1" title="Descargar PDF"><i class="fas fa-file-pdf"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-bold text-dark">MA-GH-002</td>
                                        <td><span class="fw-semibold">Manual de Inducción y Reinducción</span></td>
                                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Manual</span></td>
                                        <td><span class="badge bg-success bg-opacity-10 text-success fw-bold">V1</span></td>
                                        <td class="text-muted">10/01/2026</td>
                                        <td class="text-end pe-3">
                                            <button class="btn btn-sm btn-outline-success rounded-2 px-2 py-1" title="Descargar PDF"><i class="fas fa-file-pdf"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ps-3 fw-bold text-dark">FT-AG-012</td>
                                        <td><span class="fw-semibold">Formato de Registro de Riego por Goteo</span></td>
                                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Formato</span></td>
                                        <td><span class="badge bg-success bg-opacity-10 text-success fw-bold">V3</span></td>
                                        <td class="text-muted">20/07/2026</td>
                                        <td class="text-end pe-3">
                                            <button class="btn btn-sm btn-outline-success rounded-2 px-2 py-1" title="Descargar Excel"><i class="fas fa-file-excel"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
