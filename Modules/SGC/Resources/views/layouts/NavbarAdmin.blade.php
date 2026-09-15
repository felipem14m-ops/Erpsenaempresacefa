<!-- ======= TOP NAVBAR (AdminLTE & Bootstrap Header) ======= -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom px-3 d-flex justify-content-between align-items-center" style="height: 60px; z-index: 1030;">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
            <a class="nav-link text-secondary rounded-3 p-2 d-flex align-items-center justify-content-center" id="pushmenu-toggle-btn" data-widget="pushmenu" href="javascript:void(0)" role="button" title="Colapsar / Expandir Menú" style="width: 38px; height: 38px; cursor: pointer; transition: background-color 0.2s;">
                <i class="fas fa-bars fs-5"></i>
            </a>
        </li>
        <li class="nav-item d-flex align-items-center ms-2">
            <a href="{{ route('sgc.index') }}" class="text-decoration-none d-flex align-items-center gap-2">
                <strong class="fs-6 fw-extrabold" style="font-family: 'Outfit', sans-serif; font-weight: 800; background: linear-gradient(135deg, rgba(0, 23, 36, 0.95) 0%, rgba(0, 77, 32, 0.92) 50%, rgba(57, 169, 0, 0.96) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">SGC</strong>
                <span class="mx-1 text-secondary opacity-50">|</span>
                <span class="text-muted small d-none d-sm-inline" style="font-family: 'Plus Jakarta Sans', sans-serif;">Sistema de Gestión de Calidad</span>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto align-items-center gap-3">
        <!-- Notifications Bell -->
        <li class="nav-item dropdown">
            <button class="btn btn-light border-0 rounded-circle position-relative p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Notificaciones" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="far fa-bell text-secondary"></i>
                @if(isset($notificacionesSinLeer) && $notificacionesSinLeer->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle text-dark" style="font-size: 10px; font-weight: bold; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;">
                        {{ $notificacionesSinLeer->count() }}
                    </span>
                @endif
            </button>
            
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="width: 300px; max-height: 400px; overflow-y: auto;">
                <li><h6 class="dropdown-header fw-bold text-dark border-bottom pb-2">Notificaciones</h6></li>
                @if(isset($notificacionesSinLeer) && $notificacionesSinLeer->count() > 0)
                    @foreach($notificacionesSinLeer as $notificacion)
                        <li>
                            <a class="dropdown-item py-2 text-wrap" href="#">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark" style="font-size: 13px;">{{ $notificacion->titulo }}</span>
                                    <small class="text-muted" style="font-size: 11px;">{{ $notificacion->creado_en->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 text-muted" style="font-size: 12px; line-height: 1.3;">
                                    {{ $notificacion->mensaje }}
                                </p>
                            </a>
                        </li>
                    @endforeach
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-center text-primary" href="#" style="font-size: 13px;">Ver todas</a></li>
                @else
                    <li>
                        <div class="dropdown-item text-center text-muted py-3">
                            <i class="far fa-bell-slash mb-2" style="font-size: 20px;"></i>
                            <p class="mb-0" style="font-size: 13px;">No hay notificaciones nuevas</p>
                        </div>
                    </li>
                @endif
            </ul>
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
