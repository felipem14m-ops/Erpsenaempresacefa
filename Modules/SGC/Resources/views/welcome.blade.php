<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>SGC - Sistema de Gestión de Calidad | SENA Empresa</title>

    <meta name="description" content="Sistema de Gestión de Calidad (SGC) - Automatización y control del ciclo de vida documental en CFA La Angostura, SENA Regional Huila.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/assets/img/cefaempresa.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Nunito:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://sicefa.com.co/general/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --sena-green: #39A900;
            --sena-green-dark: #007832;
            --sena-green-light: #62E31D;
            --sena-navy: #002336;
            --sena-navy-dark: #001724;
            --sena-navy-light: #003652;
            --sena-bg-light: #f8faf9;
            --sena-border: #e3ebe6;
        }

        body {
            font-family: 'Poppins', 'Nunito', sans-serif;
            background-color: var(--sena-bg-light);
            color: #2c3e50;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Jost', sans-serif;
            font-weight: 700;
        }

        /* Navbar SGC */
        .sgc-navbar {
            background: rgba(0, 23, 36, 0.96) !important;
            backdrop-filter: blur(12px);
            border-bottom: 3px solid var(--sena-green);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
        }

        .sgc-nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 14px !important;
            border-radius: 8px;
            transition: all 0.25s ease;
        }

        .sgc-nav-link:hover, .sgc-nav-link.active {
            color: var(--sena-green-light) !important;
            background: rgba(57, 169, 0, 0.15);
        }

        /* Custom Cards & Buttons */
        .card-sgc {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--sena-border);
            box-shadow: 0 10px 30px rgba(0, 35, 54, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .card-sgc:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 35px rgba(0, 35, 54, 0.12);
            border-color: rgba(57, 169, 0, 0.4);
        }

        .btn-sena {
            background-color: var(--sena-green) !important;
            color: #ffffff !important;
            font-weight: 600;
            border-radius: 50px;
            padding: 10px 24px;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-sena:hover {
            background-color: var(--sena-green-dark) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(57, 169, 0, 0.35);
        }

        .btn-sena-outline {
            background: transparent;
            color: var(--sena-green) !important;
            border: 2px solid var(--sena-green) !important;
            font-weight: 600;
            border-radius: 50px;
            padding: 9px 22px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-sena-outline:hover {
            background: var(--sena-green) !important;
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        .btn-navy {
            background-color: var(--sena-navy) !important;
            color: #ffffff !important;
            font-weight: 600;
            border-radius: 50px;
            padding: 10px 24px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-navy:hover {
            background-color: var(--sena-navy-light) !important;
            color: var(--sena-green-light) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 35, 54, 0.35);
        }

        /* Step Timeline */
        .step-badge {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 18px;
        }

        /* Footer */
        .sgc-footer {
            background: var(--sena-navy-dark);
            color: #ffffff;
            border-top: 4px solid var(--sena-green);
        }
    </style>
</head>

<body>
    <!-- Navbar Header SGC -->
    <nav class="navbar navbar-expand-lg sgc-navbar sticky-top">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center text-white text-decoration-none" href="{{ url('/sgc') }}">
                <img src="{{ asset('general/assets/img/cefaempresa.png') }}" alt="Logo SENA Empresa" class="bg-white rounded-circle p-1 me-2" style="height: 42px; width: 42px; object-fit: contain;">
                <div>
                    <span class="fw-bold fs-5 text-white d-block lh-1">SGC • SENA</span>
                    <small class="text-white-50 fs-8" style="font-size: 11px;">Gestión de Calidad CFA La Angostura</small>
                </div>
            </a>

            <!-- Toggle Mobile Button -->
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSGC">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Nav Links -->
            <div class="collapse navbar-collapse" id="navbarSGC">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link sgc-nav-link" href="#inicio"><i class="fas fa-home me-1"></i> Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sgc-nav-link" href="#ciclo-documental"><i class="fas fa-arrows-spin me-1"></i> Ciclo de Vida</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sgc-nav-link" href="#roles"><i class="fas fa-users-gear me-1"></i> Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sgc-nav-link" href="#asistente-ia"><i class="fas fa-wand-magic-sparkles me-1 text-warning"></i> Asistente IA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sgc-nav-link" href="#trazabilidad"><i class="fas fa-shield-halved me-1"></i> Auditoría ISO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sgc-nav-link" href="#beneficios"><i class="fas fa-star me-1"></i> Beneficios</a>
                    </li>
                </ul>

                <!-- Right Action Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-2" title="Volver al Portal General ERP">
                        <i class="fas fa-arrow-left me-1"></i> Portal ERP
                    </a>
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-sm btn-success text-white rounded-pill px-3 py-2 dropdown-toggle d-flex align-items-center gap-2" style="background-color: var(--sena-green);" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i>
                                <span>{{ Auth::user()->full_name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                <li><span class="dropdown-item-text text-muted fs-7">Rol: <strong>{{ Auth::user()->primary_role }}</strong></span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item fw-semibold" href="{{ route('sgc.dashboard') }}"><i class="fas fa-gauge-high me-2 text-success"></i> Ir a mi Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login', ['redirect' => '/sgc']) }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-2">
                            <i class="fas fa-right-to-bracket me-1"></i> Ingresar
                        </a>
                        <a href="{{ route('register', ['redirect' => '/sgc']) }}" class="btn btn-sm text-white rounded-pill px-3 py-2" style="background-color: var(--sena-green);">
                            <i class="fas fa-user-plus me-1"></i> Registro
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- ======= HERO SECTION (Luminoso & Limpio) ======= -->
        <section id="inicio" class="position-relative py-5 overflow-hidden" style="background: linear-gradient(135deg, #f0f7f2 0%, #e6f4ea 45%, #ffffff 100%); border-bottom: 1px solid #dcece0;">
            <!-- Ambient subtle dot grid -->
            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-25 pointer-events-none" style="background-image: radial-gradient(#39A900 1px, transparent 1px); background-size: 24px 24px;"></div>
            
            <div class="container position-relative py-4">
                <div class="row align-items-center g-5">
                    <!-- Left Hero Column -->
                    <div class="col-lg-7">
                        <!-- Institutional Badge -->
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-3 bg-white shadow-sm border border-success border-opacity-25">
                            <img src="{{ asset('general/assets/img/cefaempresa.png') }}" alt="Logo SENA Empresa" style="height: 22px; width: 22px; object-fit: contain;" class="bg-white rounded-circle">
                            <span class="fs-7 fw-bold text-success" style="color: #007832 !important;">CFA "La Angostura" • SENA Regional Huila • Ficha 3288036</span>
                        </div>

                        <h1 class="display-4 fw-extrabold mb-3 lh-sm" style="color: #002336; font-weight: 800;">
                            Sistema de Gestión <br>
                            <span style="color: #39A900; text-shadow: 0 0 20px rgba(57, 169, 0, 0.2);">de Calidad (SGC)</span>
                        </h1>

                        <p class="fs-5 text-secondary mb-4 leading-relaxed" style="max-width: 620px; color: #4a5d6e !important;">
                            Plataforma digital para la <strong class="text-dark">automatización, control de versiones y auditoría integral</strong> del ciclo de vida de procedimientos, manuales y formatos institucionales del centro agroindustrial.
                        </p>

                        <!-- Interactive Action Buttons -->
                        <div class="d-flex flex-wrap gap-3 mb-5">
                            <a href="#ciclo-documental" class="btn btn-sena shadow-sm">
                                <i class="fas fa-arrows-spin"></i> Explorar Flujo de Trabajo
                            </a>
                            <a href="#asistente-ia" class="btn btn-sena-outline">
                                <i class="fas fa-wand-magic-sparkles text-warning"></i> Conocer Asistente IA
                            </a>
                            <button class="btn btn-navy rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalListadoMaestro">
                                <i class="fas fa-book-bookmark me-1 text-success"></i> Listado Maestro
                            </button>
                        </div>

                        <!-- Quick Metrics Ribbon (Light Cards) -->
                        <div class="row g-3 pt-4 border-top border-secondary border-opacity-15">
                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded-4 bg-white shadow-sm border border-light d-flex align-items-center gap-3">
                                    <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-user-shield fs-5" style="color: #39A900;"></i>
                                    </div>
                                    <div>
                                        <div class="fs-5 fw-bold text-dark lh-1">4 Roles</div>
                                        <small class="text-muted fs-8">Control Estricto</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded-4 bg-white shadow-sm border border-light d-flex align-items-center gap-3">
                                    <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-diagram-project fs-5 text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fs-5 fw-bold text-dark lh-1">4 Estados</div>
                                        <small class="text-muted fs-8">Ciclo Atómico</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded-4 bg-white shadow-sm border border-light d-flex align-items-center gap-3">
                                    <div class="p-2 rounded-3 bg-warning bg-opacity-15 text-warning">
                                        <i class="fas fa-robot fs-5 text-warning"></i>
                                    </div>
                                    <div>
                                        <div class="fs-5 fw-bold text-dark lh-1">IA Asistida</div>
                                        <small class="text-muted fs-8">Revisión Rápida</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="p-3 rounded-4 bg-white shadow-sm border border-light d-flex align-items-center gap-3">
                                    <div class="p-2 rounded-3 bg-success bg-opacity-10 text-success">
                                        <i class="fas fa-stamp fs-5" style="color: #007832;"></i>
                                    </div>
                                    <div>
                                        <div class="fs-5 fw-bold text-dark lh-1">ISO 9001</div>
                                        <small class="text-muted fs-8">Control y Calidad</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Hero Showcase Card (Clean Institutional Overview - Sin formulario) -->
                    <div class="col-lg-5">
                        <div class="card border-0 rounded-4 shadow-lg overflow-hidden bg-white border border-1 border-light">
                            <div class="card-header py-3 px-4 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #002336 0%, #003652 100%);">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success rounded-pill px-3 py-1 fs-8" style="background-color: #39A900 !important;">
                                        <i class="fas fa-circle-check me-1"></i> Sistema Activo
                                    </span>
                                    <span class="text-white-75 fs-7">Control Documental SGC</span>
                                </div>
                                <i class="fas fa-shield-halved text-success fs-5"></i>
                            </div>

                            <div class="card-body p-4">
                                <h5 class="fw-bold text-dark mb-1">Ecosistema Documental La Angostura</h5>
                                <p class="text-muted fs-7 mb-4">Estructura estandarizada para garantizar que sólo circulen versiones vigentes y autorizadas.</p>

                                <!-- Document Lifecycle Overview Items -->
                                <div class="d-flex flex-column gap-3 mb-3">
                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center text-success" style="background: rgba(57, 169, 0, 0.15); width: 40px; height: 40px;">
                                                <i class="fas fa-file-circle-check fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fs-7 fw-bold text-dark">Documentación Vigente</h6>
                                                <small class="text-muted fs-8">Manuales, Procedimientos y Formatos</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-success text-white">Vigente</span>
                                    </div>

                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center text-warning" style="background: rgba(255, 193, 7, 0.2); width: 40px; height: 40px;">
                                                <i class="fas fa-clock-rotate-left fs-5 text-warning"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fs-7 fw-bold text-dark">Flujo de Revisión y Aprobación</h6>
                                                <small class="text-muted fs-8">Asistido por Inteligencia Artificial</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-warning text-dark">En Revisión</span>
                                    </div>

                                    <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center text-secondary" style="background: rgba(108, 117, 125, 0.15); width: 40px; height: 40px;">
                                                <i class="fas fa-vault fs-5"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fs-7 fw-bold text-dark">Archivo Histórico y Bitácora</h6>
                                                <small class="text-muted fs-8">Custodia inmutable y auditoría total</small>
                                            </div>
                                        </div>
                                        <span class="badge bg-secondary text-white">Obsoleto</span>
                                    </div>
                                </div>

                                <div class="pt-3 border-top text-center">
                                    <a href="#ciclo-documental" class="text-decoration-none fw-bold fs-7" style="color: #39A900;">
                                        Conocer el ciclo de vida completo <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= SECTION 1: CICLO DE VIDA DOCUMENTAL ======= -->
        <section id="ciclo-documental" class="py-5 bg-white">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <span class="badge text-uppercase px-3 py-2 rounded-pill fw-bold text-success mb-2" style="background-color: rgba(57, 169, 0, 0.12); font-size: 13px;">
                        Flujo de Control Automatizado
                    </span>
                    <h2 class="fw-bold fs-2 text-dark">Ciclo de Vida del Documento</h2>
                    <p class="text-muted mx-auto fs-6" style="max-width: 720px;">
                        Cada documento transita por un flujo estructurado y atómico. Al aprobarse una nueva versión, la anterior pasa a estado obsoleto automáticamente, garantizando que nunca circulen versiones no autorizadas.
                    </p>
                </div>

                <!-- Flowchart Steps Grid -->
                <div class="row g-4 position-relative">
                    <!-- Step 1: Borrador -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-sgc h-100 p-4 border-start border-4 border-info">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="step-badge bg-info text-white">1</div>
                                <span class="badge bg-info bg-opacity-10 text-info fw-bold">Fase Inicial</span>
                            </div>
                            <h4 class="fw-bold fs-5 mb-2">Borrador</h4>
                            <p class="text-muted fs-7 mb-3">
                                El <strong>Líder de Área</strong> crea y carga la propuesta documental (procedimiento, manual o formato), detallando la justificación del cambio o creación.
                            </p>
                            <div class="mt-auto pt-3 border-top text-muted fs-8">
                                <i class="fas fa-user-pen me-1 text-info"></i> Radicado por el Área
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: En Revisión -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-sgc h-100 p-4 border-start border-4 border-warning position-relative">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning text-dark"><i class="fas fa-sparkles me-1"></i> Asistencia IA</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="step-badge bg-warning text-dark">2</div>
                            </div>
                            <h4 class="fw-bold fs-5 mb-2">En Revisión</h4>
                            <p class="text-muted fs-7 mb-3">
                                El <strong>Responsable de Calidad</strong> analiza la solicitud apoyado por el Asistente Inteligente (resumen ejecutivo, diff de cambios y palabras clave).
                            </p>
                            <div class="mt-auto pt-3 border-top text-muted fs-8">
                                <i class="fas fa-clipboard-check me-1 text-warning"></i> Criterio Humano + IA
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Vigente -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-sgc h-100 p-4 border-start border-4 border-success">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="step-badge bg-success text-white">3</div>
                                <span class="badge bg-success bg-opacity-10 text-success fw-bold">Publicación</span>
                            </div>
                            <h4 class="fw-bold fs-5 mb-2">Vigente</h4>
                            <p class="text-muted fs-7 mb-3">
                                Al ser aprobado, el documento se publica automáticamente en el <strong>Listado Maestro</strong> para consulta abierta de instructores y aprendices.
                            </p>
                            <div class="mt-auto pt-3 border-top text-muted fs-8">
                                <i class="fas fa-check-circle me-1 text-success"></i> Publicación Inmediata
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Obsoleto -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-sgc h-100 p-4 border-start border-4 border-secondary">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="step-badge bg-secondary text-white">4</div>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary fw-bold">Histórico</span>
                            </div>
                            <h4 class="fw-bold fs-5 mb-2">Obsoleto</h4>
                            <p class="text-muted fs-7 mb-3">
                                La versión anterior se marca atómicamente como obsoleta. Se archiva en la bitácora histórica sin riesgo de coexistencia de versiones.
                            </p>
                            <div class="mt-auto pt-3 border-top text-muted fs-8">
                                <i class="fas fa-vault me-1 text-secondary"></i> Custodia y Trazabilidad
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= SECTION 2: MODELO DE 4 ROLES ======= -->
        <section id="roles" class="py-5" style="background-color: #f8faf9;">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <span class="badge text-uppercase px-3 py-2 rounded-pill fw-bold text-success mb-2" style="background-color: rgba(57, 169, 0, 0.12); font-size: 13px;">
                        Estructura de Permisos
                    </span>
                    <h2 class="fw-bold fs-2 text-dark">Matriz de 4 Roles Diferenciados</h2>
                    <p class="text-muted mx-auto fs-6" style="max-width: 700px;">
                        El SGC asigna responsabilidades específicas a cada participante del ecosistema institucional, asegurando gobernanza y segregación de funciones.
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Rol 1: Administrador -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-sgc h-100 p-4 text-center">
                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 70px; height: 70px; background: rgba(0, 35, 54, 0.08); color: var(--sena-navy);">
                                <i class="fas fa-user-shield fs-2"></i>
                            </div>
                            <h4 class="fw-bold fs-5 mb-2">Administrador</h4>
                            <p class="text-muted fs-7 mb-3">
                                Gobierno general del módulo, administración de usuarios, asignación de roles y parametrización de procesos del ERP.
                            </p>
                            <ul class="list-unstyled text-start fs-8 text-muted border-top pt-3 mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Gestión de usuarios y accesos</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Configuración de áreas del centro</li>
                                <li><i class="fas fa-check text-success me-1"></i> Auditoría global del sistema</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Rol 2: Responsable de Calidad -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-sgc h-100 p-4 text-center border-2 border-success">
                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 70px; height: 70px; background: rgba(57, 169, 0, 0.12); color: var(--sena-green);">
                                <i class="fas fa-certificate fs-2"></i>
                            </div>
                            <h4 class="fw-bold fs-5 mb-2">Resp. de Calidad</h4>
                            <p class="text-muted fs-7 mb-3">
                                Revisa y aprueba o rechaza solicitudes documentales, validando que cumplan los estándares de calidad antes de oficializarlos.
                            </p>
                            <ul class="list-unstyled text-start fs-8 text-muted border-top pt-3 mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Aprobación y rechazo fundamentado</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Uso del Asistente Inteligente IA</li>
                                <li><i class="fas fa-check text-success me-1"></i> Control del Listado Maestro</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Rol 3: Líder de Área -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-sgc h-100 p-4 text-center">
                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 70px; height: 70px; background: rgba(13, 202, 240, 0.12); color: #087990;">
                                <i class="fas fa-user-tie fs-2"></i>
                            </div>
                            <h4 class="fw-bold fs-5 mb-2">Líder de Área</h4>
                            <p class="text-muted fs-7 mb-3">
                                Radica solicitudes de creación, modificación o eliminación de documentos para su respectiva unidad de producción o coordinación.
                            </p>
                            <ul class="list-unstyled text-start fs-8 text-muted border-top pt-3 mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Radicación de borradores</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Carga de anexos y versiones</li>
                                <li><i class="fas fa-check text-success me-1"></i> Seguimiento en tiempo real</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Rol 4: Consultante -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-sgc h-100 p-4 text-center">
                            <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 70px; height: 70px; background: rgba(255, 193, 7, 0.15); color: #997404;">
                                <i class="fas fa-users-viewfinder fs-2"></i>
                            </div>
                            <h4 class="fw-bold fs-5 mb-2">Aprendiz / Instructor</h4>
                            <p class="text-muted fs-7 mb-3">
                                Accede a la documentación vigente mediante enlace directo sin fricción ni necesidad de permisos administrativos.
                            </p>
                            <ul class="list-unstyled text-start fs-8 text-muted border-top pt-3 mb-0">
                                <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Consulta de formatos vigentes</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-1"></i> Descarga de manuales autorizados</li>
                                <li><i class="fas fa-check text-success me-1"></i> Acceso transparente y sin trabas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= SECTION 3: ASISTENTE INTELIGENTE CON IA ======= -->
        <section id="asistente-ia" class="py-5 bg-white position-relative">
            <div class="container py-4">
                <div class="row align-items-center g-5">
                    <!-- Left Details -->
                    <div class="col-lg-6">
                        <span class="badge text-uppercase px-3 py-2 rounded-pill fw-bold text-warning mb-2" style="background-color: rgba(255, 193, 7, 0.15); color: #997404 !important; font-size: 13px;">
                            <i class="fas fa-wand-magic-sparkles me-1"></i> Componente Diferenciador
                        </span>
                        <h2 class="fw-bold fs-2 text-dark mb-3">
                            Asistente Inteligente con IA Integrada
                        </h2>
                        <p class="text-muted fs-6 mb-4">
                            El SGC incorpora un asistente de inteligencia artificial en el módulo de aprobación para reducir drásticamente los tiempos de análisis del Responsable de Calidad sin reemplazar el criterio humano.
                        </p>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="p-2 rounded-circle bg-success bg-opacity-10 text-success mt-1">
                                    <i class="fas fa-file-waveform fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Resumen Ejecutivo Automático</h6>
                                    <p class="text-muted fs-7 mb-0">Sintetiza al instante los aspectos críticos del documento para quien debe aprobar.</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="p-2 rounded-circle bg-primary bg-opacity-10 text-primary mt-1">
                                    <i class="fas fa-code-compare fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Detección de Cambios y Diff entre Versiones</h6>
                                    <p class="text-muted fs-7 mb-0">Identifica palabras clave y resalta qué secciones fueron modificadas respecto a la versión previa.</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="p-2 rounded-circle bg-warning bg-opacity-10 text-warning mt-1">
                                    <i class="fas fa-shield-heart fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Degradación Elegante (Graceful Fallback)</h6>
                                    <p class="text-muted fs-7 mb-0">Si el servicio de IA no está disponible, el flujo de revisión continúa normalmente de forma manual sin bloquearse.</p>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#modalSimulacionIA">
                            <i class="fas fa-play me-2 text-warning"></i> Ver Simulación del Asistente IA
                        </button>
                    </div>

                    <!-- Right Interactive Mockup Showcase -->
                    <div class="col-lg-6">
                        <div class="card border-0 rounded-4 shadow-lg overflow-hidden bg-dark text-white p-4" style="background: linear-gradient(135deg, #001f30 0%, #002e48 100%);">
                            <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-white border-opacity-15 mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-warning text-dark"><i class="fas fa-brain me-1"></i> Motor IA Activo</span>
                                    <span class="text-white-50 fs-8">Análisis de Documento v2.0</span>
                                </div>
                                <span class="text-success fs-8"><i class="fas fa-bolt me-1"></i> Procesado en 1.2s</span>
                            </div>

                            <div class="bg-white bg-opacity-10 p-3 rounded-3 mb-3 border border-white border-opacity-10">
                                <h6 class="text-warning fs-7 fw-bold mb-1"><i class="fas fa-align-left me-1"></i> Resumen Ejecutivo Generado:</h6>
                                <p class="fs-8 text-white-75 mb-0">
                                    "Se actualiza el procedimiento de bioseguridad en la planta de lácteos, incorporando el protocolo de desinfección preventiva con amonio cuaternario y reduciendo el tiempo de recirculación a 15 minutos."
                                </p>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="p-2 rounded-2 bg-white bg-opacity-5 border border-white border-opacity-5">
                                        <small class="text-white-50 d-block fs-9">Cambios Clave Detectados</small>
                                        <span class="badge bg-success bg-opacity-75 text-white fs-9">+3 Cláusulas Nuevas</span>
                                        <span class="badge bg-danger bg-opacity-75 text-white fs-9">-1 Protocolo Anterior</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 rounded-2 bg-white bg-opacity-5 border border-white border-opacity-5">
                                        <small class="text-white-50 d-block fs-9">Palabras Clave</small>
                                        <span class="text-info fs-9">#Bioseguridad #Lácteos #ISO9001</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 pt-2 border-top border-white border-opacity-10">
                                <button class="btn btn-sm btn-outline-light rounded-pill px-3 fs-8">Rechazar Solicitud</button>
                                <button class="btn btn-sm btn-success text-white rounded-pill px-3 fs-8" style="background-color: #39A900;">Aprobar y Publicar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= SECTION 4: TRAZABILIDAD, AUDITORÍA Y ARQUITECTURA ======= -->
        <section id="trazabilidad" class="py-5" style="background-color: #f8faf9;">
            <div class="container py-4">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5">
                        <span class="badge text-uppercase px-3 py-2 rounded-pill fw-bold text-success mb-2" style="background-color: rgba(57, 169, 0, 0.12); font-size: 13px;">
                            Trazabilidad & Auditoría
                        </span>
                        <h2 class="fw-bold fs-2 text-dark mb-3">Bitácora Inmutable y Arquitectura ERP</h2>
                        <p class="text-muted fs-6 mb-4">
                            Alineado con los principios de la norma <strong>ISO 9001</strong>, cada acción queda registrada con fecha, hora, responsable y observaciones.
                        </p>

                        <div class="card p-3 border-0 rounded-3 shadow-sm mb-3 bg-white" style="border-left: 4px solid var(--sena-green) !important;">
                            <h6 class="fw-bold mb-1"><i class="fas fa-cubes-stacked me-2 text-success"></i> Módulo Integrado al ERP SENA Empresa</h6>
                            <p class="text-muted fs-7 mb-0">
                                Desarrollado en <strong>Laravel 13</strong> con arquitectura modular (<code>nwidart/laravel-modules</code>), compartiendo usuarios, autenticación y base de datos con los módulos estratégicos y misionales.
                            </p>
                        </div>

                        <div class="card p-3 border-0 rounded-3 shadow-sm bg-white" style="border-left: 4px solid var(--sena-navy) !important;">
                            <h6 class="fw-bold mb-1"><i class="fas fa-shield-halved me-2 text-primary"></i> Control de Versiones Atómico</h6>
                            <p class="text-muted fs-7 mb-0">
                                Previene colisiones y duplicidades, asegurando que sólo exista una versión vigente oficial por cada documento.
                            </p>
                        </div>
                    </div>

                    <!-- Right Table Mockup -->
                    <div class="col-lg-7">
                        <div class="card card-sgc border-0 overflow-hidden shadow-sm">
                            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-list-check me-2 text-success"></i> Registro Histórico de Bitácora (Audit Log)</h6>
                                <span class="badge bg-light text-dark border">En Tiempo Real</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 fs-7">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha / Hora</th>
                                            <th>Usuario</th>
                                            <th>Acción</th>
                                            <th>Documento</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">Hoy, 14:30</td>
                                            <td><strong>Coord. Calidad</strong></td>
                                            <td><span class="badge bg-success bg-opacity-15 text-success">Aprobación</span></td>
                                            <td>Manual Pecuario v2.0</td>
                                            <td><span class="badge bg-success">Vigente</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Hoy, 11:15</td>
                                            <td><strong>Líder Agrícola</strong></td>
                                            <td><span class="badge bg-info bg-opacity-15 text-info">Radicación</span></td>
                                            <td>Proc. Cosecha Café v1.2</td>
                                            <td><span class="badge bg-warning text-dark">En Revisión</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Ayer, 16:45</td>
                                            <td><strong>Sistema SGC</strong></td>
                                            <td><span class="badge bg-secondary bg-opacity-15 text-secondary">Obsolescencia</span></td>
                                            <td>Manual Pecuario v1.0</td>
                                            <td><span class="badge bg-secondary">Obsoleto</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer bg-white text-center py-2 border-top">
                                <small class="text-muted"><i class="fas fa-lock me-1"></i> Trazabilidad 100% auditada bajo estándares de calidad</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= SECTION 5: BENEFICIOS Y VALOR AGREGADO ======= -->
        <section id="beneficios" class="py-5 bg-white">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <span class="badge text-uppercase px-3 py-2 rounded-pill fw-bold text-success mb-2" style="background-color: rgba(57, 169, 0, 0.12); font-size: 13px;">
                        Impacto Institucional
                    </span>
                    <h2 class="fw-bold fs-2 text-dark">¿Qué Aporta este Proyecto?</h2>
                    <p class="text-muted mx-auto fs-6" style="max-width: 720px;">
                        Transformamos un proceso manual y fragmentado en un estándar digital de excelencia técnica y formativa.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card card-sgc h-100 p-4">
                            <div class="p-3 rounded-circle d-inline-flex bg-success bg-opacity-10 text-success mb-3">
                                <i class="fas fa-file-circle-check fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Cero Riesgo Documental</h5>
                            <p class="text-muted fs-7 mb-0">Elimina la circulación de copias desactualizadas o no oficiales de procedimientos institucionales.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-sgc h-100 p-4">
                            <div class="p-3 rounded-circle d-inline-flex bg-warning bg-opacity-10 text-warning mb-3">
                                <i class="fas fa-gauge-high fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Aprobación Ágil con IA</h5>
                            <p class="text-muted fs-7 mb-0">La IA asiste la toma de decisiones resumiendo y comparando versiones sin comprometer el criterio humano.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-sgc h-100 p-4">
                            <div class="p-3 rounded-circle d-inline-flex bg-primary bg-opacity-10 text-primary mb-3">
                                <i class="fas fa-magnifying-glass-chart fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Trazabilidad Total</h5>
                            <p class="text-muted fs-7 mb-0">Auditoría completa de cada cambio, aprobación y rechazo en cumplimiento de buenas prácticas de calidad.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-sgc h-100 p-4">
                            <div class="p-3 rounded-circle d-inline-flex bg-info bg-opacity-10 text-info mb-3">
                                <i class="fas fa-link fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Acceso Directo Sin Fricción</h5>
                            <p class="text-muted fs-7 mb-0">Instructores y aprendices consultan formatos y manuales vigentes de forma inmediata mediante enlaces limpios.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-sgc h-100 p-4">
                            <div class="p-3 rounded-circle d-inline-flex bg-success bg-opacity-10 text-success mb-3">
                                <i class="fas fa-network-wired fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Ecosistema ERP Unificado</h5>
                            <p class="text-muted fs-7 mb-0">Se integra al ERP SENA Empresa compartiendo base de datos, autenticación y módulos misionales.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-sgc h-100 p-4">
                            <div class="p-3 rounded-circle d-inline-flex bg-dark bg-opacity-10 text-dark mb-3">
                                <i class="fas fa-graduation-cap fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Valor Académico y Real</h5>
                            <p class="text-muted fs-7 mb-0">Demuestra la aplicación de ingeniería de software moderna, arquitectura modular e IA en un contexto real de formación.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======= SECTION 6: BANNER DE ACCIÓN ======= -->
        <section class="py-5 text-white" style="background: linear-gradient(135deg, #001724 0%, #002D45 60%, #39A900 100%);">
            <div class="container py-3">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <h3 class="fw-bold mb-2">¿Listo para consultar la documentación institucional?</h3>
                        <p class="text-white-50 mb-0 fs-6">Accede al listado maestro de formatos y procedimientos autorizados para el Centro La Angostura.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <button class="btn btn-sena btn-lg px-4 py-3" data-bs-toggle="modal" data-bs-target="#modalListadoMaestro">
                            <i class="fas fa-book-bookmark me-2"></i> Ver Listado Maestro
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal: Listado Maestro -->
    <div class="modal fade" id="modalListadoMaestro" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header bg-success text-white py-3 px-4" style="background-color: var(--sena-green) !important;">
                    <h5 class="modal-title fw-bold"><i class="fas fa-folder-open me-2"></i> Listado Maestro de Documentos Vigentes</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar por código, nombre o área...">
                    </div>

                    <div class="list-group list-group-flush border rounded-3">
                        <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <span class="badge bg-light text-dark border me-2">SGC-PR-01</span>
                                <strong class="text-dark">Manual de Procedimientos en Planta de Lácteos</strong>
                                <div class="text-muted fs-8 mt-1"><i class="fas fa-tag me-1"></i> Versión 2.0 • Área Pecuaria</div>
                            </div>
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Vigente</span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <span class="badge bg-light text-dark border me-2">SGC-FT-04</span>
                                <strong class="text-dark">Formato de Control de Calidad en Cosecha</strong>
                                <div class="text-muted fs-8 mt-1"><i class="fas fa-tag me-1"></i> Versión 1.3 • Área Agrícola</div>
                            </div>
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Vigente</span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                                <span class="badge bg-light text-dark border me-2">SGC-MN-02</span>
                                <strong class="text-dark">Manual de Inducción de Aprendices en Turnos</strong>
                                <div class="text-muted fs-8 mt-1"><i class="fas fa-tag me-1"></i> Versión 3.0 • SENA Empresa</div>
                            </div>
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Vigente</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Simulación Asistente IA -->
    <div class="modal fade" id="modalSimulacionIA" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header bg-dark text-white py-3 px-4 border-bottom border-secondary">
                    <h5 class="modal-title fw-bold"><i class="fas fa-wand-magic-sparkles me-2 text-warning"></i> Simulación: Asistente IA en Aprobación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="alert alert-warning border-0 rounded-3 d-flex align-items-center gap-2 mb-3">
                        <i class="fas fa-info-circle fs-5"></i>
                        <small>Esta simulación ilustra cómo el Asistente IA analiza un documento antes de que el Responsable de Calidad emita su decisión.</small>
                    </div>

                    <div class="card p-3 border-0 rounded-3 shadow-sm mb-3 bg-white">
                        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-file-lines me-2 text-primary"></i> Documento Analizado: Manual de BPM v2.0</h6>
                        <div class="p-3 bg-light rounded-2 border">
                            <div class="fw-bold text-success fs-7 mb-1"><i class="fas fa-check-double me-1"></i> Resumen Ejecutivo (IA):</div>
                            <p class="fs-8 text-muted mb-2">
                                "El documento introduce 4 nuevas medidas sanitarias en la manipulación de cárnicos, elimina el uso de cloro en favor de sanitizantes orgánicos y ajusta la frecuencia de limpieza a 2 veces por turno."
                            </p>
                            <div class="fw-bold text-primary fs-7 mb-1"><i class="fas fa-tags me-1"></i> Palabras Clave:</div>
                            <span class="badge bg-primary bg-opacity-10 text-primary me-1">Inocuidad</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary me-1">BPM</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary me-1">Cárnicos</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary">Sanitización</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white py-2">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Institucional SGC -->
    <footer class="sgc-footer pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4 pb-4 border-bottom border-secondary border-opacity-25">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('general/assets/img/cefaempresa.png') }}" alt="Logo" class="bg-white rounded-circle p-1 me-3" style="width: 48px; height: 48px; object-fit: contain;">
                        <div>
                            <h5 class="text-white mb-0 fw-bold">Sistema de Gestión de Calidad (SGC)</h5>
                            <span class="text-success fs-7 fw-semibold" style="color: #62E31D !important;">Proceso de Apoyo Documental • SENA Empresa</span>
                        </div>
                    </div>
                    <p class="text-white-50 fs-7 mb-3">
                        Plataforma digital para la automatización, control de versiones, revisión inteligente con IA y aseguramiento de la trazabilidad documental bajo lineamientos institucionales e ISO 9001 en el Centro de Formación Agroindustrial "La Angostura" (Ficha 3288036, Regional Huila).
                    </p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white fw-bold mb-3 border-start border-3 border-success ps-2">Secciones del Módulo</h6>
                    <ul class="list-unstyled text-white-50 fs-7">
                        <li class="mb-2"><a href="#ciclo-documental" class="text-white-50 text-decoration-none hover-green"><i class="fas fa-chevron-right me-1 fs-8 text-success"></i> Flujo de Estados</a></li>
                        <li class="mb-2"><a href="#roles" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-1 fs-8 text-success"></i> Matriz de 4 Roles</a></li>
                        <li class="mb-2"><a href="#asistente-ia" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-1 fs-8 text-success"></i> Asistente Inteligente IA</a></li>
                        <li class="mb-2"><a href="#trazabilidad" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-1 fs-8 text-success"></i> Bitácora y Auditoría</a></li>
                        <li><a href="#beneficios" class="text-white-50 text-decoration-none"><i class="fas fa-chevron-right me-1 fs-8 text-success"></i> Valor Agregado</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="text-white fw-bold mb-3 border-start border-3 border-success ps-2">Centro La Angostura</h6>
                    <p class="text-white-50 fs-7 mb-2">
                        <i class="fas fa-map-marker-alt text-success me-2"></i> Km 38 Vía al Sur Neiva - Campoalegre, Huila
                    </p>
                    <p class="text-white-50 fs-7 mb-2">
                        <i class="fas fa-layer-group text-success me-2"></i> Ecosistema ERP: 6 Módulos Integrados
                    </p>
                    <p class="text-white-50 fs-7">
                        <i class="fas fa-code-branch text-success me-2"></i> Arquitectura Modular Laravel 13
                    </p>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 text-white-50 fs-8">
                <span>&copy; {{ date('Y') }} SENA Empresa — Módulo SGC. Todos los derechos reservados.</span>
                <span>Regional Huila • Centro de Formación Agroindustrial "La Angostura"</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://sicefa.com.co/general/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
