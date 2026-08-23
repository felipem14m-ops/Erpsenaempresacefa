<!-- ======= TOP NAVBAR (AdminLTE & Bootstrap Header) ======= -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom px-3 d-flex justify-content-between align-items-center" style="height: 60px; z-index: 1030;">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
            <a class="nav-link text-secondary" data-widget="pushmenu" href="javascript:void(0)" role="button" title="Colapsar / Expandir Menú">
                <i class="fas fa-bars fs-5"></i>
            </a>
        </li>
        <li class="nav-item d-flex align-items-center ms-2">
            <a href="{{ route('sgc.index') }}" class="text-decoration-none d-flex align-items-center">
                <strong class="fs-6 text-dark">SGC</strong>
                <span class="mx-2 text-secondary opacity-50">|</span>
                <span class="text-muted small d-none d-sm-inline">Sistema de Gestión de Calidad</span>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto align-items-center gap-3">
        <!-- Notifications Bell -->
        <li class="nav-item">
            <button class="btn btn-light border-0 rounded-circle position-relative p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Notificaciones">
                <i class="far fa-bell text-secondary"></i>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle"></span>
            </button>
        </li>

        <!-- User Profile Display -->
        <li class="nav-item d-flex align-items-center gap-2">
            <div class="text-end d-none d-sm-block">
                <span class="fw-bold d-block text-dark lh-1" style="font-size: 13.5px;">
                    {{ Auth::user()->full_name ?? 'Carlos Alberto Ruiz' }}
                </span>
                <span class="badge rounded-pill px-2 py-1 mt-1 fw-bold" style="background-color: #eaf8ea; color: #2b8000; font-size: 11px;">
                    {{ Auth::user()->primary_role ?? 'Administrador' }}
                </span>
            </div>
            <div class="rounded-circle text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; background-color: #39A900; font-size: 13px;">
                {{ Auth::user()->initials ?? 'AD' }}
            </div>
        </li>
    </ul>
</nav>
