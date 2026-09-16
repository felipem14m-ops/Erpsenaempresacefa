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
        <!-- Interactive Notifications Dropdown -->
        <li class="nav-item dropdown">
            <a class="btn btn-light border-0 rounded-circle position-relative p-2 d-flex align-items-center justify-content-center" 
               href="javascript:void(0)" 
               id="navbarNotificacionesDropdown" 
               role="button" 
               data-bs-toggle="dropdown" 
               aria-expanded="false" 
               style="width: 38px; height: 38px;" 
               title="Notificaciones del Sistema">
                <i class="far fa-bell text-secondary fs-6"></i>
                <span id="notif-badge-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm d-none" style="font-size: 10px; padding: 3px 6px;">
                    0
                </span>
            </a>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-0 mt-2" 
                 aria-labelledby="navbarNotificacionesDropdown" 
                 style="width: 340px; max-width: 90vw; overflow: hidden; z-index: 1050;">
                
                <!-- Dropdown Header -->
                <div class="d-flex justify-content-between align-items-center px-3 py-2.5 bg-light border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-bell text-success" style="color: #39A900 !important;"></i>
                        <span class="fw-bold text-dark" style="font-size: 13px;">Notificaciones</span>
                    </div>
                    <button type="button" class="btn btn-link text-decoration-none p-0 text-muted" style="font-size: 11px;" onclick="marcarTodasNotificacionesLeidas()">
                        Marcar todas leídas
                    </button>
                </div>

                <!-- Dropdown Notification List Container -->
                <div id="notif-dropdown-list" style="max-height: 320px; overflow-y: auto;">
                    <div class="text-center py-4 text-muted small">
                        <div class="spinner-border spinner-border-sm text-success" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Footer -->
                @php
                    $isLiderUserNotif = auth()->check() && (auth()->user()->rol_id == 3 || str_contains(strtolower(auth()->user()->rol->nombre ?? ''), 'lider'));
                    $solicitudesRoute = $isLiderUserNotif ? route('sgc.lider_area.solicitudes.index') : route('sgc.solicitudes.index');
                    $solicitudesText = $isLiderUserNotif ? 'Ver Mis Solicitudes' : 'Ver Centro de Solicitudes';
                @endphp
                <div class="text-center py-2 bg-light border-top">
                    <a href="{{ $solicitudesRoute }}" class="text-decoration-none fw-bold" style="font-size: 11.5px; color: #39A900;">
                        {{ $solicitudesText }} <i class="fas fa-chevron-right ms-1" style="font-size: 9px;"></i>
                    </a>
                </div>
            </div>
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

<!-- JavaScript para Notificaciones en Tiempo Real -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        cargarNotificaciones();

        // Polling cada 30 segundos
        setInterval(cargarNotificaciones, 30000);

        const notifBtn = document.getElementById('navbarNotificacionesDropdown');
        if (notifBtn) {
            notifBtn.addEventListener('click', cargarNotificaciones);
        }
    });

    function cargarNotificaciones() {
        const badge = document.getElementById('notif-badge-count');
        const listContainer = document.getElementById('notif-dropdown-list');

        fetch('{{ route("sgc.notificaciones.index") }}')
            .then(res => res.json())
            .then(data => {
                const unread = data.unread_count || 0;
                if (unread > 0) {
                    badge.innerText = unread > 99 ? '99+' : unread;
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }

                if (!listContainer) return;

                if (!data.notificaciones || data.notificaciones.length === 0) {
                    listContainer.innerHTML = `
                        <div class="text-center py-4 text-muted px-3">
                            <i class="far fa-bell-slash fs-4 d-block mb-1 text-secondary opacity-50"></i>
                            <span class="small d-block">No tienes notificaciones pendientes</span>
                        </div>
                    `;
                    return;
                }

                let html = '<div class="list-group list-group-flush">';
                data.notificaciones.forEach(n => {
                    const bgClass = n.leida ? 'bg-white' : 'bg-light';
                    const fwClass = n.leida ? 'fw-normal' : 'fw-bold';
                    html += `
                        <a href="javascript:void(0)" onclick="clickNotificacion(${n.id}, '${n.url}')" class="list-group-item list-group-item-action px-3 py-2.5 border-bottom ${bgClass} d-flex align-items-start gap-2.5 transition-all">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 28px; height: 28px; background-color: rgba(57,169,0,0.1); color: ${n.icon_color || '#39A900'}; font-size: 12px;">
                                <i class="${n.icon_class || 'fas fa-bell'}"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden" style="min-width: 0;">
                                <div class="d-flex justify-content-between align-items-center mb-0.5">
                                    <strong class="text-dark text-truncate d-block ${fwClass}" style="font-size: 12px;">${n.titulo}</strong>
                                    <small class="text-muted ms-1 flex-shrink-0" style="font-size: 10px;">${n.tiempo}</small>
                                </div>
                                <p class="text-muted mb-0 text-truncate" style="font-size: 11px;" title="${n.mensaje}">
                                    ${n.mensaje}
                                </p>
                            </div>
                        </a>
                    `;
                });
                html += '</div>';
                listContainer.innerHTML = html;
            })
            .catch(() => {});
    }

    function clickNotificacion(id, url) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch(`{{ url('sgc/notificaciones') }}/${id}/leer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        }).finally(() => {
            if (url && url !== 'javascript:void(0)') {
                window.location.href = url;
            } else {
                cargarNotificaciones();
            }
        });
    }

    function marcarTodasNotificacionesLeidas() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        fetch('{{ route("sgc.notificaciones.leer-todas") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        }).finally(() => {
            cargarNotificaciones();
        });
    }
</script>

