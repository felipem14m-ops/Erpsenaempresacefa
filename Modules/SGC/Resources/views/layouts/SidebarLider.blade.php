<!-- ======= MAIN SIDEBAR LÍDER DE ÁREA (AdminLTE & Bootstrap) ======= -->
<aside class="main-sidebar sidebar-light-success elevation-1" style="background-color: #ffffff !important; border-right: 1px solid #e2e8f0; overflow-x: hidden !important;">
    
    <!-- Brand Logo Header with Official SENA Logo & Translucent Typography (Identical to Admin) -->
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
                    
                    <!-- 1. Inicio / Dashboard Líder -->
                    @php
                        $isInicioActive = request()->routeIs('sgc.lider_area.dashboard') || (request()->routeIs('sgc.dashboard') && (auth()->check() && str_contains(strtolower(auth()->user()->rol->nombre ?? ''), 'lider')));
                    @endphp
                    <li class="nav-item">
                        <a href="{{ route('sgc.lider_area.dashboard') }}" 
                           class="nav-link d-flex align-items-center gap-3 {{ $isInicioActive ? 'active' : '' }}" 
                           title="Inicio">
                            <i class="nav-icon fas fa-house"></i>
                            <p class="mb-0 text-truncate">Inicio</p>
                        </a>
                    </li>

                    <!-- 2. Solicitudes -->
                    @if(auth()->check() && (auth()->user()->hasSuperAdmin() || auth()->user()->tieneAccesoModulo('SGC', 'consultar_solicitud|crear_solicitud|aprobar_solicitud|rechazar_solicitud')))
                        @php
                            $isHistorialActive = request()->routeIs('sgc.lider_area.solicitudes.*') || request()->routeIs('sgc.solicitudes.*');
                            $liderPendingCount = auth()->check() ? \Modules\SGC\Models\Solicitud::where('solicitado_por', auth()->id())->whereIn('estado', ['radicada', 'en_revision'])->count() : 0;
                        @endphp
                        <li class="nav-item">
                            <a href="{{ route('sgc.lider_area.solicitudes.index') }}" 
                               class="nav-link d-flex align-items-center justify-content-between gap-2 {{ $isHistorialActive ? 'active' : '' }}" 
                               title="Solicitudes">
                                <div class="d-flex align-items-center gap-3 overflow-hidden">
                                    <i class="nav-icon fas fa-file-circle-check"></i>
                                    <p class="mb-0 text-truncate">Solicitudes</p>
                                </div>
                                @if($liderPendingCount > 0)
                                    <span class="badge rounded-pill bg-warning text-dark px-2 py-0.5" style="font-size: 10px;">{{ $liderPendingCount }}</span>
                                @endif
                            </a>
                        </li>
                    @endif

                    <!-- 3. Documentos de mi Área -->
                    @if(auth()->check() && (auth()->user()->hasSuperAdmin() || auth()->user()->tieneAccesoModulo('SGC', 'consultar_documento')))
                        @php
                            $isDocsActive = request()->routeIs('sgc.documentos.*') && !request()->has('tipo_doc_id');
                        @endphp
                        <li class="nav-item">
                            <a href="{{ route('sgc.documentos.index') }}" 
                               class="nav-link d-flex align-items-center gap-3 {{ $isDocsActive ? 'active' : '' }}" 
                               title="Documentos de mi Área">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p class="mb-0 text-truncate">Documentos de mi Área</p>
                            </a>
                        </li>

                        <!-- 4. Formatos y Registros -->
                        @php
                            $isFormatosActive = request()->routeIs('sgc.documentos.*') && request()->has('tipo_doc_id');
                        @endphp
                        <li class="nav-item">
                            <a href="{{ route('sgc.documentos.index') }}?tipo_doc_id=fo" 
                               class="nav-link d-flex align-items-center gap-3 {{ $isFormatosActive ? 'active' : '' }}" 
                               title="Formatos y Registros">
                                <i class="nav-icon fas fa-table-list"></i>
                                <p class="mb-0 text-truncate">Formatos y Registros</p>
                            </a>
                        </li>
                    @endif

                    <!-- 5. Estructura y Procesos -->
                    @if(auth()->check() && (auth()->user()->hasSuperAdmin() || auth()->user()->tieneAccesoModulo('SGC', 'gestionar_catalogos')))
                        @php
                            $isCatalogosActive = request()->routeIs('sgc.catalogos.*');
                        @endphp
                        <li class="nav-item">
                            <a href="{{ route('sgc.catalogos.index') }}" 
                               class="nav-link d-flex align-items-center gap-3 {{ $isCatalogosActive ? 'active' : '' }}" 
                               title="Estructura y Procesos">
                                <i class="nav-icon fas fa-folder-tree"></i>
                                <p class="mb-0 text-truncate">Estructura y Procesos</p>
                            </a>
                        </li>
                    @endif

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
