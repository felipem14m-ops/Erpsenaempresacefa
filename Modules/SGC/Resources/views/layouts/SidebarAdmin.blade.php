<!-- ======= MAIN SIDEBAR ADMIN (AdminLTE & Bootstrap) ======= -->
<aside class="main-sidebar sidebar-light-success elevation-1" style="background-color: #ffffff !important; border-right: 1px solid #e2e8f0; overflow-x: hidden !important;">
    
    <!-- Brand Logo Header with Official SENA Logo & Translucent Typography -->
    <a href="{{ route('sgc.index') }}" class="brand-link d-flex align-items-center gap-2 text-decoration-none px-3 py-3 border-bottom overflow-hidden" style="background: #ffffff; border-color: #f1f5f9 !important; height: 60px; box-sizing: border-box;">
        <!-- SENA Official Logo -->
        <img src="{{ asset('modules/sgc/img/Logo.png') }}" alt="Logo SENA" class="img-fluid brand-image flex-shrink-0" style="height: 36px; width: auto; max-width: 36px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(57, 169, 0, 0.16));">
        
        <!-- Elegant Translucent Divider -->
        <div class="border-end mx-1 flex-shrink-0 brand-divider" style="height: 28px; opacity: 0.35; border-color: #94a3b8;"></div>
        
        <!-- Brand Typography: Translucent / Gradient Lettering -->
        <div class="brand-text d-flex flex-column justify-content-center lh-1 flex-grow-1" style="min-width: 0; overflow: hidden;">
            <div class="d-flex align-items-center gap-1 lh-1 text-truncate">
                <span class="fw-bolder flex-shrink-0" style="font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 800; letter-spacing: -0.02em; background: linear-gradient(135deg, rgba(0, 23, 36, 0.95) 0%, rgba(0, 77, 32, 0.92) 50%, rgba(57, 169, 0, 0.96) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">SGC</span>
                <span class="fw-bold text-truncate" style="font-size: 11px; color: #39A900; letter-spacing: 0.2px; font-family: 'Outfit', sans-serif;">• SENA EMPRESA</span>
            </div>
            <small class="text-muted text-truncate mt-1 d-block" style="font-size: 9.5px; font-weight: 500; font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; color: #64748b !important;">
                Gestión de Calidad • CFA La Angostura
            </small>
        </div>
    </a>

    <!-- Sidebar Container -->
    <div class="sidebar p-0 d-flex flex-column justify-content-between" style="min-height: calc(100vh - 60px); overflow-x: hidden !important;">
        <div style="overflow-x: hidden; width: 100%;">
            <!-- Center Institutional Pill Badge (Welcome Translucent Style) -->
            <div class="px-3 pt-3 pb-2 sidebar-badge-container" style="overflow: hidden; width: 100%;">
                <div class="d-flex align-items-center gap-2 px-2.5 py-1.5 rounded-pill shadow-xs" style="background: rgba(57, 169, 0, 0.05); border: 1px solid rgba(57, 169, 0, 0.18); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); min-width: 0; overflow: hidden;">
                    <span class="pulse-dot" style="width: 6px; height: 6px; background-color: #39A900; border-radius: 50%; display: inline-block; box-shadow: 0 0 6px rgba(57, 169, 0, 0.6); flex-shrink: 0;"></span>
                    <small class="fw-bold text-truncate" style="font-size: 9px; letter-spacing: 0.3px; color: #007832; font-family: 'Outfit', sans-serif; text-transform: uppercase; min-width: 0;">
                        Regional Huila • CFA La Angostura
                    </small>
                </div>
            </div>

            <!-- Sidebar Navigation Menu -->
            <nav class="mt-2 px-3" style="overflow-x: hidden; width: 100%;">
                <ul class="nav nav-pills nav-sidebar flex-column gap-1" data-widget="treeview" role="menu" data-accordion="false" style="overflow-x: hidden; width: 100%;">
                    
                    <!-- 1. Inicio / Dashboard -->
                    @php
                        $isAdminInicioActive = request()->routeIs('sgc.admin.dashboard') || request()->routeIs('sgc.dashboard');
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('sgc.admin.dashboard') }}" class="nav-link d-flex align-items-center gap-3 {{ $isAdminInicioActive ? 'active' : '' }}" title="Inicio">
                            <i class="nav-icon fas fa-house"></i>
                            <p class="mb-0 text-truncate">Inicio</p>
                        </a>
                    </li>

                    <!-- 2. Gestión de Usuarios -->
                    @php
                        $isUsuariosActive = request()->routeIs('sgc.usuarios.*') || request()->routeIs('sgc.users.*');
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('sgc.usuarios.index') }}" class="nav-link d-flex align-items-center gap-3 {{ $isUsuariosActive ? 'active' : '' }}" title="Usuarios">
                            <i class="nav-icon fas fa-users-gear"></i>
                            <p class="mb-0 text-truncate">Usuarios</p>
                        </a>
                    </li>

                    <!-- 2.1. Roles y Permisos SGC -->
                    @php
                        $isRolesActive = request()->routeIs('sgc.roles-permisos.*');
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('sgc.roles-permisos.index') }}" class="nav-link d-flex align-items-center gap-3 {{ $isRolesActive ? 'active' : '' }}" title="Roles y Permisos">
                            <i class="nav-icon fas fa-shield-halved"></i>
                            <p class="mb-0 text-truncate">Roles y Permisos</p>
                        </a>
                    </li>

                    <!-- 3. Documentos -->
                    @php
                        $isDocsAdminActive = request()->routeIs('sgc.documentos.*');
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('sgc.documentos.index') }}" class="nav-link d-flex align-items-center gap-3 {{ $isDocsAdminActive ? 'active' : '' }}" title="Documentos">
                            <i class="nav-icon fas fa-file-lines"></i>
                            <p class="mb-0 text-truncate">Documentos</p>
                        </a>
                    </li>

                    <!-- 3.1. Catálogos Maestros (Procesos, Áreas, Tipos) -->
                    @php
                        $isCatalogosAdminActive = request()->routeIs('sgc.catalogos.*') || request()->routeIs('sgc.procesos.*') || request()->routeIs('sgc.areas.*') || request()->routeIs('sgc.tipos-documento.*');
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('sgc.catalogos.index') }}" class="nav-link d-flex align-items-center gap-3 {{ $isCatalogosAdminActive ? 'active' : '' }}" title="Catálogos SGC">
                            <i class="nav-icon fas fa-folder-tree"></i>
                            <p class="mb-0 text-truncate">Catálogos SGC</p>
                        </a>
                    </li>
                    <!-- 5. Versiones -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center gap-3" title="Versiones">
                            <i class="nav-icon fas fa-code-fork"></i>
                            <p class="mb-0 text-truncate">Versiones</p>
                        </a>
                    </li>

                    <!-- 6. Trazabilidad -->
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link d-flex align-items-center gap-3" title="Trazabilidad">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p class="mb-0 text-truncate">Trazabilidad</p>
                        </a>
                    </li>

                    <!-- 7. Reportes -->
                    @php
                        $isReportesActive = request()->routeIs('sgc.reportes.*') || request()->routeIs('sgc.admin.reportes.*');
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('sgc.reportes.index') }}" class="nav-link d-flex align-items-center gap-3 {{ $isReportesActive ? 'active' : '' }}" title="Reportes">
                            <i class="nav-icon fas fa-clock-rotate-left"></i>
                            <p class="mb-0 text-truncate">Reportes</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>

        <!-- Sidebar Bottom: Logout -->
        <div class="p-3 border-top bg-white mt-auto sidebar-logout-container" style="overflow: hidden; width: 100%;">
            <a href="{{ route('logout') }}" class="text-danger text-decoration-none fw-bold d-flex align-items-center gap-2 px-2 py-1 rounded-2" title="Cerrar Sesión" style="width: 100%; overflow: hidden;">
                <i class="fas fa-arrow-right-from-bracket flex-shrink-0"></i>
                <span class="text-truncate">Cerrar Sesión</span>
            </a>
        </div>
    </div>

</aside>
