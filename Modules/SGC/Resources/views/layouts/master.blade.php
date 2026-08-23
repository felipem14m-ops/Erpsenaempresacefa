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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

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

        /* ======= PURE ADMINLTE COLLAPSE TRANSITIONS ======= */
        .main-sidebar, .main-header, .content-wrapper {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        @media (min-width: 992px) {
            body.sidebar-collapse .main-sidebar {
                margin-left: -250px !important;
            }
            body.sidebar-collapse .main-header,
            body.sidebar-collapse .content-wrapper {
                margin-left: 0 !important;
            }
        }

        @media (max-width: 991.98px) {
            .main-sidebar {
                margin-left: -250px !important;
            }
            .main-header, .content-wrapper {
                margin-left: 0 !important;
            }
            body.sidebar-open .main-sidebar {
                margin-left: 0 !important;
            }
        }

        /* Nav item hover */
        .nav-sidebar .nav-item .nav-link:hover {
            background-color: #f0fdf4 !important;
            color: #39A900 !important;
        }
        .nav-sidebar .nav-item .nav-link:hover i {
            color: #39A900 !important;
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed bg-light">

    <div class="wrapper">

        <!-- ======= NAVBAR ======= -->
        @include('sgc::layouts.NavbarAdmin')

        <!-- ======= SIDEBAR ADMIN ======= -->
        @include('sgc::layouts.SidebarAdmin')

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

    <script>
        $(document).ready(function () {
            $(document).on('click', '[data-widget="pushmenu"]', function (e) {
                e.preventDefault();
                if ($(window).width() <= 991.98) {
                    $('body').toggleClass('sidebar-open');
                } else {
                    $('body').toggleClass('sidebar-collapse');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
