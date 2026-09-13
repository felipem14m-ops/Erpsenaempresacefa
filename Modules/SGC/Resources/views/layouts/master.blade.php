<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SGC • Sistema de Gestión de Calidad') | SENA Empresa</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('general/assets/img/cefaempresa.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700;800&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <!-- AdminLTE 3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <style>
        body {
            font-family: 'Inter', 'Source Sans Pro', sans-serif !important;
            background-color: #f8fafc;
        }

        /* ======= ULTRA FLUID MINI SIDEBAR (60fps Hardware-Accelerated) ======= */
        :root {
            --sidebar-width: 260px;
            --sidebar-mini-width: 70px;
            --sidebar-ease: cubic-bezier(0.25, 1, 0.5, 1);
            --sidebar-speed: 0.32s;
        }

        .main-sidebar {
            width: var(--sidebar-width) !important;
            position: fixed !important;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1038;
            background-color: #ffffff !important;
            border-right: 1px solid #e2e8f0;
            transition: width var(--sidebar-speed) var(--sidebar-ease),
                        margin-left var(--sidebar-speed) var(--sidebar-ease),
                        transform var(--sidebar-speed) var(--sidebar-ease) !important;
            overflow: hidden !important;
            will-change: width, transform;
            backface-visibility: hidden;
        }

        .main-header {
            height: 60px;
            position: sticky;
            top: 0;
            z-index: 1030;
            background-color: #ffffff;
            transition: margin-left var(--sidebar-speed) var(--sidebar-ease) !important;
            will-change: margin-left;
        }

        .content-wrapper {
            transition: margin-left var(--sidebar-speed) var(--sidebar-ease) !important;
            will-change: margin-left;
        }

        /* Nav links fluid structure */
        .main-sidebar .nav-sidebar .nav-item .nav-link {
            border-radius: 10px !important;
            padding: 9px 12px !important;
            margin: 2px 0 !important;
            color: #475569 !important;
            font-size: 13.5px !important;
            font-weight: 500 !important;
            border: 1px solid transparent !important;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, padding var(--sidebar-speed) var(--sidebar-ease) !important;
            overflow: hidden !important;
            white-space: nowrap !important;
            display: flex !important;
            align-items: center !important;
        }

        .main-sidebar .nav-sidebar .nav-item .nav-link i.nav-icon {
            width: 22px !important;
            min-width: 22px !important;
            text-align: center !important;
            font-size: 16px !important;
            color: #64748b !important;
            flex-shrink: 0 !important;
            transition: color 0.2s ease, transform 0.2s ease, font-size var(--sidebar-speed) var(--sidebar-ease) !important;
        }

        /* Smooth Collapsible Text Container & Elements (Fading without sudden popping) */
        .main-sidebar .brand-text,
        .main-sidebar .brand-divider,
        .main-sidebar .sidebar-badge-container,
        .main-sidebar .nav-sidebar .nav-item .nav-link p,
        .main-sidebar .sidebar-logout-container a span {
            transition: opacity 0.2s ease, transform var(--sidebar-speed) var(--sidebar-ease), max-width var(--sidebar-speed) var(--sidebar-ease) !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            opacity: 1;
            transform: translateX(0);
        }

        /* Desktop View (>= 992px) */
        @media (min-width: 992px) {
            /* 1. Normal Expanded State */
            body:not(.sidebar-collapse) .main-sidebar {
                width: var(--sidebar-width) !important;
                margin-left: 0 !important;
                transform: translateX(0) !important;
            }
            body:not(.sidebar-collapse) .main-header,
            body:not(.sidebar-collapse) .content-wrapper {
                margin-left: var(--sidebar-width) !important;
            }

            /* 2. Mini Collapsed State */
            body.sidebar-collapse .main-sidebar {
                width: var(--sidebar-mini-width) !important;
                margin-left: 0 !important;
                transform: translateX(0) !important;
            }
            body.sidebar-collapse .main-header,
            body.sidebar-collapse .content-wrapper {
                margin-left: var(--sidebar-mini-width) !important;
            }

            /* Smoothly Fade Out & Hide Texts in Mini State */
            body.sidebar-collapse .main-sidebar .brand-text,
            body.sidebar-collapse .main-sidebar .brand-divider,
            body.sidebar-collapse .main-sidebar .sidebar-badge-container,
            body.sidebar-collapse .main-sidebar .nav-sidebar .nav-item .nav-link p,
            body.sidebar-collapse .main-sidebar .sidebar-logout-container a span {
                opacity: 0 !important;
                pointer-events: none !important;
                transform: translateX(-10px) !important;
                max-width: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Center Header Brand Logo in 70px */
            body.sidebar-collapse .main-sidebar .brand-link {
                padding-left: 17px !important;
                padding-right: 17px !important;
                justify-content: center !important;
            }
            body.sidebar-collapse .main-sidebar .brand-image {
                margin: 0 auto !important;
                transform: scale(1.05);
            }

            /* Center Nav Icons in 70px mini state */
            body.sidebar-collapse .main-sidebar .sidebar nav {
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-top: 8px !important;
                width: 100% !important;
            }
            body.sidebar-collapse .main-sidebar .nav-sidebar {
                padding-left: 0 !important;
                padding-right: 0 !important;
                width: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
            }
            body.sidebar-collapse .main-sidebar .nav-sidebar .nav-item {
                width: 100% !important;
                display: flex !important;
                justify-content: center !important;
                margin: 3px 0 !important;
                padding: 0 !important;
            }
            body.sidebar-collapse .main-sidebar .nav-sidebar .nav-item .nav-link {
                justify-content: center !important;
                align-items: center !important;
                padding: 0 !important;
                width: 42px !important;
                height: 42px !important;
                min-width: 42px !important;
                max-width: 42px !important;
                margin: 0 auto !important;
                gap: 0 !important;
                border-radius: 8px !important;
                box-sizing: border-box !important;
            }
            body.sidebar-collapse .main-sidebar .nav-sidebar .nav-item .nav-link i.nav-icon {
                margin: 0 auto !important;
                font-size: 16px !important;
                width: auto !important;
                min-width: unset !important;
                text-align: center !important;
            }
            body.sidebar-collapse .main-sidebar .nav-sidebar .nav-item .nav-link p {
                display: none !important;
            }

            /* Center Logout Button in 70px mini state */
            body.sidebar-collapse .main-sidebar .sidebar-logout-container {
                padding: 12px 0 !important;
                width: 100% !important;
                display: flex !important;
                justify-content: center !important;
            }
            body.sidebar-collapse .main-sidebar .sidebar-logout-container a {
                justify-content: center !important;
                align-items: center !important;
                padding: 0 !important;
                width: 42px !important;
                height: 42px !important;
                min-width: 42px !important;
                max-width: 42px !important;
                margin: 0 auto !important;
                gap: 0 !important;
                border-radius: 8px !important;
                box-sizing: border-box !important;
            }
            body.sidebar-collapse .main-sidebar .sidebar-logout-container a i {
                margin: 0 auto !important;
                font-size: 16px !important;
            }
            body.sidebar-collapse .main-sidebar .sidebar-logout-container a span {
                display: none !important;
            }
        }

        /* Mobile View (< 992px) */
        @media (max-width: 991.98px) {
            .main-sidebar {
                width: var(--sidebar-width) !important;
                margin-left: calc(-1 * var(--sidebar-width)) !important;
                transform: translateX(-100%) !important;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }
            .main-header,
            .content-wrapper {
                margin-left: 0 !important;
            }

            body.sidebar-open .main-sidebar {
                margin-left: 0 !important;
                transform: translateX(0) !important;
            }

            .sidebar-backdrop {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(15, 23, 42, 0.45);
                backdrop-filter: blur(2px);
                z-index: 1035;
                transition: opacity 0.25s ease;
            }
            body.sidebar-open .sidebar-backdrop {
                display: block;
            }
        }

        /* Nav item hover */
        .main-sidebar .nav-sidebar .nav-item .nav-link:hover:not(.active) {
            background-color: #f8fafc !important;
            color: #1e293b !important;
            border-color: #f1f5f9 !important;
        }
        .main-sidebar .nav-sidebar .nav-item .nav-link:hover:not(.active) i.nav-icon {
            color: #39A900 !important;
            transform: scale(1.08);
        }

        /* Nav item ACTIVE state - Clean, Soft & Elegant (No harsh box border) */
        .main-sidebar .nav-sidebar .nav-item .nav-link.active {
            background-color: #eaf8ea !important;
            color: #007832 !important;
            font-weight: 600 !important;
            border: 1px solid rgba(57, 169, 0, 0.22) !important;
            box-shadow: 0 1px 3px rgba(57, 169, 0, 0.05) !important;
        }
        .main-sidebar .nav-sidebar .nav-item .nav-link.active i.nav-icon {
            color: #39A900 !important;
        }
        .main-sidebar .nav-sidebar .nav-item .nav-link.active p {
            color: #007832 !important;
            font-weight: 600 !important;
        }

        /* ======= PREVENT SIDEBAR HORIZONTAL SCROLLBAR ======= */
        .main-sidebar, .sidebar, .sidebar > div, .brand-link {
            overflow-x: hidden !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition layout-fixed bg-light">

    <div class="wrapper">

        <!-- Mobile Backdrop Overlay -->
        <div class="sidebar-backdrop"></div>

        <!-- ======= NAVBAR ======= -->
        @include('sgc::layouts.NavbarAdmin')

        <!-- ======= DYNAMIC SIDEBAR ======= -->
        @php
            $userRolName = strtolower(auth()->user()->rol->nombre ?? '');
            $isLider = request()->routeIs('sgc.lider_area.*') || (auth()->check() && (auth()->user()->rol_id == 3 || str_contains($userRolName, 'lider')));
            $isCalidad = request()->routeIs('sgc.resp_calidad.*') || (auth()->check() && (auth()->user()->rol_id == 2 || str_contains($userRolName, 'calidad') || str_contains($userRolName, 'responsable')));
        @endphp

        @if($isLider)
            @include('sgc::layouts.SidebarLider')
        @elseif($isCalidad)
            @include('sgc::layouts.SidebarRespCalidad')
        @else
            @include('sgc::layouts.SidebarAdmin')
        @endif

        <!-- ======= MAIN CONTENT WRAPPER ======= -->
        <div class="content-wrapper p-4 p-lg-5" style="background-color: #f8fafc; min-height: calc(100vh - 60px);">

            <!-- Global Flash Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                    <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                    <i class="fas fa-triangle-exclamation me-2"></i> Corrige los siguientes errores:
                    <ul class="mb-0 mt-2 small">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Injected Page Content -->
            @yield('content')

        </div>

    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Restore persistent collapsed state from localStorage (desktop only)
            if ($(window).width() >= 992) {
                if (localStorage.getItem('sgc_sidebar_collapsed') === 'true') {
                    $('body').addClass('sidebar-collapse');
                }
            }

            // Unbind any duplicate PushMenu handlers to prevent conflicting double-toggles
            $(document).off('click', '[data-widget="pushmenu"]');

            // Robust Toggle Click Handler
            $(document).on('click', '[data-widget="pushmenu"]', function (e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                if ($(window).width() <= 991.98) {
                    $('body').toggleClass('sidebar-open');
                } else {
                    $('body').toggleClass('sidebar-collapse');
                    const isCollapsed = $('body').hasClass('sidebar-collapse');
                    localStorage.setItem('sgc_sidebar_collapsed', isCollapsed);
                }
            });

            // Close sidebar on mobile backdrop or content click
            $(document).on('click', '.sidebar-backdrop, body.sidebar-open .content-wrapper', function (e) {
                if ($(window).width() <= 991.98 && $('body').hasClass('sidebar-open')) {
                    $('body').removeClass('sidebar-open');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
