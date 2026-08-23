<!-- ======= MAIN SIDEBAR ADMIN (AdminLTE & Bootstrap) ======= -->
<aside class="main-sidebar sidebar-light-success elevation-1" style="background-color: #ffffff !important; border-right: 1px solid #e2e8f0;">
    
    <!-- Brand Logo Header -->
    <a href="{{ route('sgc.index') }}" class="brand-link d-flex align-items-center gap-3 text-decoration-none p-3 border-bottom" style="background: #ffffff; border-color: #f1f5f9 !important;">
        <div class="rounded-3 d-flex align-items-center justify-content-center text-white shadow-sm flex-shrink-0" style="width: 40px; height: 40px; background-color: #39A900; border-radius: 10px;">
            <i class="fas fa-leaf fs-5"></i>
        </div>
        <div class="brand-text lh-1">
            <span class="fw-bold text-dark d-block" style="font-size: 15px;">SENA</span>
            <small class="fw-bold text-success" style="font-size: 11px; letter-spacing: 0.5px; color: #39A900 !important;">REGIONAL HUILA</small>
        </div>
    </a>

    <!-- Sidebar Container -->
    <div class="sidebar p-0 d-flex flex-column justify-content-between" style="min-height: calc(100vh - 75px);">
        <div>
            <!-- Center Subtitle -->
            <div class="px-3 pt-3 pb-2">
                <small class="text-muted d-block" style="font-size: 11.5px; line-height: 1.35;">
                    Centro de Formación Agroindustrial<br>
                    <strong class="text-dark">La Angostura</strong>
                </small>
            </div>

            <!-- Sidebar Navigation Menu -->
            <nav class="mt-2 px-2">
                <ul class="nav nav-pills nav-sidebar flex-column gap-1" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <!-- 1. Inicio / Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('sgc.admin.dashboard') }}" class="nav-link d-flex align-items-center gap-3 rounded-3 py-2 px-3 {{ request()->routeIs('sgc.admin.dashboard') || request()->routeIs('sgc.dashboard') ? 'active' : 'text-secondary fw-medium' }}" style="{{ request()->routeIs('sgc.admin.dashboard') || request()->routeIs('sgc.dashboard') ? 'background-color: #eaf8ea !important; color: #39A900 !important; border: 1.5px solid #39A900 !important; font-weight: 600 !important;' : '' }}">
                            <i class="nav-icon fas fa-house" style="width: 20px; font-size: 16px; color: {{ request()->routeIs('sgc.admin.dashboard') || request()->routeIs('sgc.dashboard') ? '#39A900' : '#64748b' }};"></i>
                            <p class="mb-0">Inicio</p>
                        </a>
                    </li>

                    <!-- 2. Gestión de Usuarios -->
                    <li class="nav-item">
                        <a href="{{ route('sgc.usuarios.index') }}" class="nav-link d-flex align-items-center gap-3 rounded-3 py-2 px-3 {{ request()->routeIs('sgc.usuarios.*') || request()->routeIs('sgc.users.*') ? 'active' : 'text-secondary fw-medium' }}" style="{{ request()->routeIs('sgc.usuarios.*') || request()->routeIs('sgc.users.*') ? 'background-color: #eaf8ea !important; color: #39A900 !important; border: 1.5px solid #39A900 !important; font-weight: 600 !important;' : '' }}">
                            <i class="nav-icon fas fa-users-gear" style="width: 20px; font-size: 16px; color: {{ request()->routeIs('sgc.usuarios.*') || request()->routeIs('sgc.users.*') ? '#39A900' : '#64748b' }};"></i>
                            <p class="mb-0">Usuarios</p>
                        </a>
                    </li>

                    <!-- 3. Documentos -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center gap-3 rounded-3 py-2 px-3 text-secondary fw-medium">
                            <i class="nav-icon fas fa-file-lines text-muted" style="width: 20px; font-size: 16px;"></i>
                            <p class="mb-0">Documentos</p>
                        </a>
                    </li>

                    <!-- 4. Solicitudes -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center gap-3 rounded-3 py-2 px-3 text-secondary fw-medium">
                            <i class="nav-icon fas fa-file-circle-plus text-muted" style="width: 20px; font-size: 16px;"></i>
                            <p class="mb-0">Solicitudes</p>
                        </a>
                    </li>

                    <!-- 5. Versiones -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center gap-3 rounded-3 py-2 px-3 text-secondary fw-medium">
                            <i class="nav-icon fas fa-code-fork text-muted" style="width: 20px; font-size: 16px;"></i>
                            <p class="mb-0">Versiones</p>
                        </a>
                    </li>

                    <!-- 6. Trazabilidad -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center gap-3 rounded-3 py-2 px-3 text-secondary fw-medium">
                            <i class="nav-icon fas fa-chart-line text-muted" style="width: 20px; font-size: 16px;"></i>
                            <p class="mb-0">Trazabilidad</p>
                        </a>
                    </li>

                    <!-- 7. Reportes -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center gap-3 rounded-3 py-2 px-3 text-secondary fw-medium">
                            <i class="nav-icon fas fa-clock-rotate-left text-muted" style="width: 20px; font-size: 16px;"></i>
                            <p class="mb-0">Reportes</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>

        <!-- Sidebar Bottom: Logout -->
        <div class="p-3 border-top bg-white mt-auto">
            <a href="{{ route('logout') }}" class="text-danger text-decoration-none fw-bold d-flex align-items-center gap-2 px-2 py-1 rounded-2">
                <i class="fas fa-arrow-right-from-bracket"></i>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </div>

</aside>
