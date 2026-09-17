@extends('sgc::layouts.master')

@section('title', 'SGC • Gestión de Mis Solicitudes Documentales')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & ACTION BUTTON ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">
                Gestión de Mis Solicitudes Documentales
            </h2>
            <p class="text-secondary small mb-0" style="font-size: 13.5px;">
                Consulte el estado de sus trámites radicados ante Calidad, descargue anexos y radique nuevas solicitudes.
            </p>
        </div>

        <div>
            <button type="button" class="btn text-white rounded-3 px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-xs" style="background-color: #39A900; border: none; font-size: 14px;" data-bs-toggle="modal" data-bs-target="#modalNuevaSolicitudAdmin">
                <i class="fas fa-file-circle-plus fs-6"></i>
                <span>+ Radicar Nueva Solicitud</span>
            </button>
        </div>
    </div>

    <!-- ======= FLASH ALERTS ======= -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border shadow-2xs p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7;">
                <i class="fas fa-circle-check fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Operación Exitosa</strong>
                <span class="text-secondary small">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border shadow-2xs p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #fef2f2; color: #ef4444; border: 1px solid #fee2e2;">
                <i class="fas fa-triangle-exclamation fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Atención</strong>
                <span class="text-secondary small">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-warning alert-dismissible fade show rounded-4 border shadow-2xs p-3 mb-4 bg-white" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-circle-exclamation text-warning fs-5"></i>
                <strong class="text-dark" style="font-size: 13.5px;">Se encontraron observaciones:</strong>
            </div>
            <ul class="mb-0 text-secondary small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ======= 4 METRIC STAT CARDS GRID ======= -->
    <div class="row g-3 mb-4">
        <!-- Stat 1: Total Radicadas -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-2xs h-100 stat-hover-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;">
                        <i class="fas fa-file-lines fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Total Radicadas</div>
                        <div class="fw-bolder text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $totalRadicadas }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Mis trámites realizados</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 2: En Trámite / Revisión -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-2xs h-100 stat-hover-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #fefce8; color: #ca8a04; border: 1px solid #fef08a;">
                        <i class="fas fa-clock-rotate-left fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">En Trámite</div>
                        <div class="fw-bolder text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $enTramite }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">En revisión por Calidad</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 3: Aprobadas / Publicadas -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-2xs h-100 stat-hover-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7;">
                        <i class="fas fa-circle-check fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Aprobadas</div>
                        <div class="fw-bolder text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $aprobadas }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Solicitudes aprobadas</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 4: Con Observaciones / Rechazadas -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-2xs h-100 stat-hover-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #fef2f2; color: #ef4444; border: 1px solid #fee2e2;">
                        <i class="fas fa-triangle-exclamation fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Con Observaciones</div>
                        <div class="fw-bolder text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $rechazadas }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Requieren ajustes</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= SEARCH AND FILTERS BAR ======= -->
    <div class="card border rounded-4 bg-white shadow-2xs p-3 mb-4">
        <form method="GET" action="{{ route('sgc.admin.solicitudes.index') }}">
            <!-- Search row -->
            <div class="row g-2 mb-3">
                <div class="col-12 col-md-10 col-lg-10">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0 ps-0" placeholder="Buscar por código de radicado (SOL-...), documento o justificación...">
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn text-white w-100 fw-semibold rounded-3 shadow-xs" style="background-color: #39A900; border: none;">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                </div>
            </div>

            <!-- Filters dropdown row -->
            <div class="row g-2">
                <div class="col-12 col-sm-6 col-md-3">
                    <select name="tipo" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ request('tipo') == 'all' || !request('tipo') ? 'selected' : '' }}>Tipo: Todos</option>
                        <option value="creacion" {{ request('tipo') == 'creacion' ? 'selected' : '' }}>Creación</option>
                        <option value="modificacion" {{ request('tipo') == 'modificacion' ? 'selected' : '' }}>Modificación</option>
                        <option value="eliminacion" {{ request('tipo') == 'eliminacion' ? 'selected' : '' }}>Eliminación</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <select name="estado" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ request('estado') == 'all' || !request('estado') ? 'selected' : '' }}>Estado: Todos</option>
                        <option value="radicada" {{ request('estado') == 'radicada' ? 'selected' : '' }}>Radicada</option>
                        <option value="en_revision" {{ request('estado') == 'en_revision' ? 'selected' : '' }}>En revisión</option>
                        <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                        <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Con observaciones</option>
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <select name="proceso_id" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ request('proceso_id') == 'all' || !request('proceso_id') ? 'selected' : '' }}>Proceso: Todos</option>
                        @foreach($procesos as $proc)
                            <option value="{{ $proc->id }}" {{ request('proceso_id') == $proc->id ? 'selected' : '' }}>
                                {{ $proc->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <select name="area_id" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ request('area_id') == 'all' || !request('area_id') ? 'selected' : '' }}>Área: Todas</option>
                        @foreach($areas as $ar)
                            <option value="{{ $ar->id }}" {{ request('area_id') == $ar->id ? 'selected' : '' }}>
                                {{ $ar->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if(request()->hasAny(['search', 'tipo', 'estado', 'proceso_id', 'area_id']))
                <div class="mt-2 text-end">
                    <a href="{{ route('sgc.admin.solicitudes.index') }}" class="btn btn-sm btn-link text-muted text-decoration-none">
                        <i class="fas fa-rotate-left me-1"></i> Limpiar filtros
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- ======= LISTADO DE SOLICITUDES RADICADAS (TABLA) ======= -->
    <div class="card border rounded-4 bg-white shadow-2xs overflow-hidden mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0 fs-6" style="font-family: 'Outfit', sans-serif;">Listado de Solicitudes Radicadas</h5>
            <span class="badge bg-light text-secondary border px-2.5 py-1.5 fw-bold">
                {{ $solicitudes->total() }} Solicitud(es)
            </span>
        </div>

        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead class="table-light">
                    <tr class="text-secondary text-uppercase fw-bold" style="font-size: 11.5px; letter-spacing: 0.5px;">
                        <th class="border-0 ps-3 py-3">Radicado / Fecha</th>
                        <th class="border-0 py-3">Tipo de Trámite</th>
                        <th class="border-0 py-3">Documento / Proceso</th>
                        <th class="border-0 py-3">Justificación</th>
                        <th class="border-0 py-3">Borrador</th>
                        <th class="border-0 py-3">Estado</th>
                        <th class="border-0 pe-3 py-3 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $sol)
                        <tr>
                            <!-- 1. Radicado / Fecha -->
                            <td class="ps-3 py-3">
                                <span class="fw-bold d-block text-dark font-monospace" style="font-size: 13.5px;">
                                    {{ $sol->numero }}
                                </span>
                                <small class="text-muted" style="font-size: 11px;">
                                    {{ $sol->fecha_radicacion ? $sol->fecha_radicacion->format('d/m/Y h:i A') : ($sol->creado_en ? $sol->creado_en->format('d/m/Y h:i A') : 'N/A') }}
                                </small>
                            </td>

                            <!-- 2. Tipo de Trámite -->
                            <td class="py-3">
                                @if($sol->tipo === 'creacion' || $sol->tipo === 'Creación')
                                    <span class="badge rounded-pill px-2.5 py-1 text-primary bg-primary-subtle fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-circle-plus me-1"></i> Creación
                                    </span>
                                @elseif($sol->tipo === 'modificacion' || $sol->tipo === 'Modificación')
                                    <span class="badge rounded-pill px-2.5 py-1 text-warning-emphasis bg-warning-subtle fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-pen-to-square me-1"></i> Modificación
                                    </span>
                                @elseif($sol->tipo === 'eliminacion' || $sol->tipo === 'Eliminación')
                                    <span class="badge rounded-pill px-2.5 py-1 text-danger bg-danger-subtle fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-trash-can me-1"></i> Eliminación
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-2.5 py-1 bg-light text-secondary border fw-semibold">
                                        {{ ucfirst($sol->tipo) }}
                                    </span>
                                @endif
                            </td>

                            <!-- 3. Documento / Proceso -->
                            <td class="py-3">
                                @if($sol->documento)
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 260px;" title="{{ $sol->documento->nombre }}">
                                        <span class="badge bg-light text-dark border me-1">{{ $sol->documento->codigo }}</span>
                                        {{ $sol->documento->nombre }}
                                    </div>
                                    <small class="text-muted d-block" style="font-size: 11px;">
                                        {{ $sol->proceso->nombre ?? ($sol->documento->proceso->nombre ?? '') }} • {{ $sol->area->nombre ?? ($sol->documento->area->nombre ?? '') }}
                                    </small>
                                @else
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 260px;" title="{{ $sol->nombre_propuesto }}">
                                        {{ $sol->nombre_propuesto ?: ($sol->tipoDoc->nombre ?? 'Documento sin título') }}
                                    </div>
                                    <small class="text-muted d-block" style="font-size: 11px;">
                                        {{ $sol->proceso->nombre ?? 'Sin proceso' }} • {{ $sol->area->nombre ?? 'Sin área' }}
                                    </small>
                                @endif
                            </td>

                            <!-- 4. Justificación -->
                            <td class="py-3" style="max-width: 220px;">
                                <span class="d-inline-block text-truncate text-secondary" style="max-width: 200px;" title="{{ $sol->justificacion }}">
                                    {{ $sol->justificacion }}
                                </span>
                            </td>

                            <!-- 5. Borrador / Anexo -->
                            <td class="py-3">
                                @if($sol->adjunto_ruta)
                                    <a href="{{ route('sgc.admin.solicitudes.download-adjunto', $sol->id) }}" class="btn btn-sm btn-outline-success rounded-2 px-2 py-1 d-inline-flex align-items-center gap-1" title="Descargar borrador adjunto" style="font-size: 11.5px;">
                                        <i class="fas fa-file-arrow-down"></i>
                                        <span>Anexo</span>
                                    </a>
                                @else
                                    <span class="text-muted small fst-italic" style="font-size: 11px;">Sin anexo</span>
                                @endif
                            </td>

                            <!-- 6. Estado -->
                            <td class="py-3">
                                @if($sol->estado === 'radicada')
                                    <span class="badge rounded-pill px-2.5 py-1 text-secondary bg-light border fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-clock me-1"></i> Radicada
                                    </span>
                                @elseif($sol->estado === 'en_revision')
                                    <span class="badge rounded-pill px-2.5 py-1 text-warning-emphasis bg-warning-subtle fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-spinner fa-spin me-1"></i> En revisión
                                    </span>
                                @elseif($sol->estado === 'aprobada')
                                    <span class="badge rounded-pill px-2.5 py-1 text-success bg-success-subtle fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-circle-check me-1"></i> Aprobada
                                    </span>
                                @elseif(in_array($sol->estado, ['rechazada', 'devuelta']))
                                    <span class="badge rounded-pill px-2.5 py-1 text-danger bg-danger-subtle fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-circle-xmark me-1"></i> Con Observaciones
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-2.5 py-1 bg-light text-secondary border fw-semibold">
                                        {{ ucfirst($sol->estado) }}
                                    </span>
                                @endif
                            </td>

                            <!-- 7. Acciones -->
                            <td class="pe-3 py-3 text-end">
                                <button type="button" class="btn btn-sm btn-light border rounded-2 px-2.5 py-1 text-dark fw-medium d-inline-flex align-items-center gap-1.5 shadow-2xs" data-bs-toggle="modal" data-bs-target="#modalDetalleAdmin{{ $sol->id }}" title="Ver Detalles de la Solicitud">
                                    <i class="fas fa-eye text-secondary"></i>
                                    <span>Detalle</span>
                                </button>
                            </td>
                        </tr>

                        <!-- ======= MODAL DETALLE DE SOLICITUD ======= -->
                        <div class="modal fade" id="modalDetalleAdmin{{ $sol->id }}" tabindex="-1" aria-labelledby="modalDetalleAdminLabel{{ $sol->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                                    <div class="modal-header border-bottom px-4 py-3 bg-white">
                                        <div class="d-flex align-items-center gap-3">
                                            <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalDetalleAdminLabel{{ $sol->id }}" style="font-family: 'Outfit', sans-serif;">
                                                Solicitud {{ $sol->numero }}
                                            </h5>
                                            @if($sol->estado === 'aprobada')
                                                <span class="badge rounded-pill px-2.5 py-1 text-success bg-success-subtle fw-semibold" style="font-size: 11.5px;">Aprobada</span>
                                            @elseif($sol->estado === 'radicada')
                                                <span class="badge rounded-pill px-2.5 py-1 text-secondary bg-light border fw-semibold" style="font-size: 11.5px;">Radicada</span>
                                            @elseif($sol->estado === 'en_revision')
                                                <span class="badge rounded-pill px-2.5 py-1 text-warning-emphasis bg-warning-subtle fw-semibold" style="font-size: 11.5px;">En revisión</span>
                                            @else
                                                <span class="badge rounded-pill px-2.5 py-1 text-danger bg-danger-subtle fw-semibold" style="font-size: 11.5px;">Con Observaciones</span>
                                            @endif
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body p-4" style="background-color: #f8fafc;">
                                        <div class="row g-4 align-items-start">
                                            <!-- Left Col -->
                                            <div class="col-12 col-lg-8">
                                                <div class="card border rounded-4 bg-white p-4 shadow-2xs">
                                                    <h6 class="fw-bold text-dark mb-3" style="font-size: 15px;">Información de la Solicitud</h6>
                                                    
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-4">
                                                            <small class="text-muted d-block" style="font-size: 11px;">Número</small>
                                                            <strong class="text-dark font-monospace" style="font-size: 13.5px;">{{ $sol->numero }}</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block" style="font-size: 11px;">Tipo de Solicitud</small>
                                                            <strong class="text-dark text-capitalize" style="font-size: 13.5px;">{{ $sol->tipo }}</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block" style="font-size: 11px;">Fecha Radicación</small>
                                                            <strong class="text-dark" style="font-size: 13.5px;">{{ $sol->fecha_radicacion ? $sol->fecha_radicacion->format('d/m/Y') : 'N/A' }}</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block" style="font-size: 11px;">Solicitante</small>
                                                            <strong class="text-dark" style="font-size: 13.5px;">{{ $sol->solicitante->nombre_completo ?? ($sol->solicitante->nombre_usuario ?? 'Administrador') }}</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block" style="font-size: 11px;">Área</small>
                                                            <strong class="text-dark" style="font-size: 13.5px;">{{ $sol->area->nombre ?? ($sol->documento->area->nombre ?? 'N/A') }}</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block" style="font-size: 11px;">Proceso</small>
                                                            <strong class="text-dark" style="font-size: 13.5px;">{{ $sol->proceso->nombre ?? ($sol->documento->proceso->nombre ?? 'N/A') }}</strong>
                                                        </div>
                                                    </div>

                                                    <div class="p-3 rounded-3 mb-3" style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                                                        <small class="text-muted fw-medium d-block mb-1" style="font-size: 11.5px;">Documento Relacionado</small>
                                                        <strong class="d-block" style="color: #007832; font-size: 13.5px;">
                                                            {{ $sol->documento ? ($sol->documento->codigo . ' — ' . $sol->documento->nombre) : ($sol->nombre_propuesto ?: 'Documento nuevo') }}
                                                        </strong>
                                                    </div>

                                                    <div class="p-3 rounded-3 mb-3" style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                                                        <small class="text-muted fw-medium d-block mb-1" style="font-size: 11.5px;">Justificación de la Solicitud</small>
                                                        <p class="text-secondary mb-0 small" style="line-height: 1.5; white-space: pre-wrap;">{{ $sol->justificacion }}</p>
                                                    </div>

                                                    @if($sol->estado === 'aprobada' || $sol->observaciones_resp)
                                                        <div class="p-3 rounded-3" style="background-color: #f0faf0; border: 1px solid #c8e6c9;">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <strong style="color: #007832; font-size: 13px;">Respuesta del Responsable de Calidad</strong>
                                                                <small class="text-muted" style="font-size: 11px;">Resuelto el: {{ $sol->fecha_resolucion ? $sol->fecha_resolucion->format('d/m/Y') : now()->format('d/m/Y') }}</small>
                                                            </div>
                                                            <p class="text-dark mb-0 small" style="line-height: 1.5;">{{ $sol->observaciones_resp ?: 'Se revisó la propuesta del borrador y se valida la coherencia frente al marco normativo institucional.' }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Right Col -->
                                            <div class="col-12 col-lg-4">
                                                <div class="card border rounded-4 bg-white p-4 shadow-2xs">
                                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">Borrador Adjunto</h6>
                                                    <small class="text-muted d-block mb-3" style="font-size: 11.5px;">Documento borrador cargado</small>

                                                    @if($sol->adjunto_ruta)
                                                        <div class="border rounded-3 p-3 d-flex align-items-center justify-content-between bg-white">
                                                            <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                                                <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background-color: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7;">
                                                                    <i class="fas fa-file-lines"></i>
                                                                </div>
                                                                <div class="text-truncate">
                                                                    <strong class="text-dark d-block text-truncate small" title="{{ basename($sol->adjunto_ruta) }}">{{ basename($sol->adjunto_ruta) }}</strong>
                                                                    <small class="text-muted" style="font-size: 10.5px;">{{ strtoupper(pathinfo($sol->adjunto_ruta, PATHINFO_EXTENSION)) }} · Adjunto</small>
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('sgc.admin.solicitudes.download-adjunto', $sol->id) }}" class="btn btn-light btn-sm border rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                                                <i class="fas fa-download text-secondary" style="font-size: 12px;"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="border rounded-3 p-3 text-center text-muted small" style="background-color: #f8fafc; border-style: dashed !important;">
                                                            No se adjuntó archivo borrador.
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-top px-4 py-3 bg-white">
                                        <a href="{{ route('sgc.admin.solicitudes.show', $sol->id) }}" class="btn btn-sm btn-outline-success rounded-3 px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 13px;">
                                            <i class="fas fa-up-right-from-square"></i>
                                            <span>Ver en Pantalla Completa</span>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light border rounded-3 px-3 py-1.5 text-secondary fw-medium" data-bs-dismiss="modal">
                                            Cerrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="d-flex flex-column align-items-center justify-content-center py-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; background-color: #f1f5f9; color: #94a3b8;">
                                        <i class="fas fa-inbox fs-4"></i>
                                    </div>
                                    <strong class="text-dark fs-6 mb-1">No ha realizado ninguna solicitud</strong>
                                    <p class="text-muted small mb-3">Utilice el botón "+ Radicar Nueva Solicitud" para solicitar la creación, modificación o eliminación de documentos.</p>
                                    <button type="button" class="btn text-white btn-sm rounded-3 px-3 py-2 fw-semibold" style="background-color: #39A900;" data-bs-toggle="modal" data-bs-target="#modalNuevaSolicitudAdmin">
                                        <i class="fas fa-plus me-1"></i> Radicar Solicitud
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($solicitudes->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Mostrando {{ $solicitudes->firstItem() }} - {{ $solicitudes->lastItem() }} de {{ $solicitudes->total() }} registros
                </div>
                <div>
                    {{ $solicitudes->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ======= MODAL RADICAR NUEVA SOLICITUD ======= -->
<div class="modal fade" id="modalNuevaSolicitudAdmin" tabindex="-1" aria-labelledby="modalNuevaSolicitudAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-bottom px-4 py-3 bg-white">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background-color: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7;">
                        <i class="fas fa-file-circle-plus"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalNuevaSolicitudAdminLabel" style="font-family: 'Outfit', sans-serif;">
                        Radicar Nueva Solicitud Documental
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('sgc.admin.solicitudes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body p-4 bg-white">
                    <!-- 1. Tipo de Solicitud -->
                    <div class="mb-4">
                        <label class="form-label text-secondary fw-bold small text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">
                            TIPO DE TRÁMITE <span class="text-danger">*</span>
                        </label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="tipo" id="admin_tipo_creacion" value="creacion" checked onchange="toggleFormAdminFields()">
                                <label class="btn btn-outline-success w-100 py-2.5 rounded-3 fw-semibold text-center" for="admin_tipo_creacion" style="font-size: 13px;">
                                    <i class="fas fa-plus-circle d-block mb-1 fs-5"></i>
                                    Creación
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="tipo" id="admin_tipo_modificacion" value="modificacion" onchange="toggleFormAdminFields()">
                                <label class="btn btn-outline-warning w-100 py-2.5 rounded-3 fw-semibold text-center" for="admin_tipo_modificacion" style="font-size: 13px;">
                                    <i class="fas fa-pen-to-square d-block mb-1 fs-5"></i>
                                    Modificación
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="tipo" id="admin_tipo_eliminacion" value="eliminacion" onchange="toggleFormAdminFields()">
                                <label class="btn btn-outline-danger w-100 py-2.5 rounded-3 fw-semibold text-center" for="admin_tipo_eliminacion" style="font-size: 13px;">
                                    <i class="fas fa-trash-can d-block mb-1 fs-5"></i>
                                    Eliminación
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Selección de Documento Existente (Visible para Modificación y Eliminación) -->
                    <div class="mb-3 d-none" id="admin_wrapper_documento_existente">
                        <label for="admin_documento_id" class="form-label text-secondary fw-bold small text-uppercase" style="font-size: 11px;">
                            DOCUMENTO A MODIFICAR / ELIMINAR <span class="text-danger">*</span>
                        </label>
                        <select name="documento_id" id="admin_documento_id" class="form-select rounded-3 py-2" onchange="autoFillAdminDocDetails(this)">
                            <option value="">-- Seleccione un documento vigente --</option>
                            @foreach($documentos as $d)
                                <option value="{{ $d->id }}" 
                                        data-proceso="{{ $d->proceso_id }}"
                                        data-area="{{ $d->area_id }}"
                                        data-tipodoc="{{ $d->tipo_doc_id }}">
                                    {{ $d->codigo }} — {{ $d->nombre }} (v{{ $d->versionActual->numero_version ?? '1.0' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Campos para Creación de Documento -->
                    <div id="admin_wrapper_creacion">
                        <div class="mb-3">
                            <label for="admin_nombre_propuesto" class="form-label text-secondary fw-bold small text-uppercase" style="font-size: 11px;">
                                NOMBRE PROPUESTO DEL DOCUMENTO <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre_propuesto" id="admin_nombre_propuesto" class="form-control rounded-3 py-2" placeholder="Ej: Instructivo de Almacenamiento Seguro de Insumos">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-4">
                                <label for="admin_tipo_doc_id" class="form-label text-secondary fw-bold small text-uppercase" style="font-size: 11px;">
                                    TIPO DE DOCUMENTO <span class="text-danger">*</span>
                                </label>
                                <select name="tipo_doc_id" id="admin_tipo_doc_id" class="form-select rounded-3 py-2">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($tiposDoc as $td)
                                        <option value="{{ $td->id }}">{{ $td->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="admin_proceso_id" class="form-label text-secondary fw-bold small text-uppercase" style="font-size: 11px;">
                                    PROCESO <span class="text-danger">*</span>
                                </label>
                                <select name="proceso_id" id="admin_proceso_id" class="form-select rounded-3 py-2">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($procesos as $p)
                                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="admin_area_id" class="form-label text-secondary fw-bold small text-uppercase" style="font-size: 11px;">
                                    ÁREA <span class="text-danger">*</span>
                                </label>
                                <select name="area_id" id="admin_area_id" class="form-select rounded-3 py-2">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($areas as $a)
                                        <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Justificación -->
                    <div class="mb-3">
                        <label for="admin_justificacion" class="form-label text-secondary fw-bold small text-uppercase" style="font-size: 11px;">
                            JUSTIFICACIÓN Y MOTIVO DE LA SOLICITUD <span class="text-danger">*</span>
                        </label>
                        <textarea name="justificacion" id="admin_justificacion" rows="3" class="form-control rounded-3 py-2" placeholder="Explique detalladamente la necesidad institucional o marco técnico que motiva este trámite..." required></textarea>
                    </div>

                    <!-- 5. Borrador Adjunto -->
                    <div class="mb-2" id="admin_wrapper_adjunto">
                        <label for="admin_adjunto" class="form-label text-secondary fw-bold small text-uppercase" style="font-size: 11px;">
                            DOCUMENTO BORRADOR ADJUNTO (.PDF, .DOCX, .XLSX)
                        </label>
                        <input type="file" name="adjunto" id="admin_adjunto" class="form-control rounded-3 py-2" accept=".pdf,.doc,.docx,.xls,.xlsx">
                        <small class="text-muted" style="font-size: 11px;">Cargue la propuesta en archivo digital para facilitar la revisión del Responsable de Calidad.</small>
                    </div>
                </div>

                <div class="modal-footer border-top px-4 py-3 bg-light">
                    <button type="button" class="btn btn-light border rounded-3 px-3 py-2 text-secondary fw-medium" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn text-white rounded-3 px-4 py-2 fw-bold shadow-xs" style="background-color: #39A900; border: none;">
                        <i class="fas fa-paper-plane me-1"></i> Radicar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .shadow-2xs {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.02);
    }
    .stat-hover-card {
        border-color: #e8edf2 !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-hover-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleFormAdminFields() {
        const isCreacion = document.getElementById('admin_tipo_creacion').checked;
        const isModificacion = document.getElementById('admin_tipo_modificacion').checked;
        const isEliminacion = document.getElementById('admin_tipo_eliminacion').checked;

        const wrapperDocExistente = document.getElementById('admin_wrapper_documento_existente');
        const wrapperCreacion = document.getElementById('admin_wrapper_creacion');
        const wrapperAdjunto = document.getElementById('admin_wrapper_adjunto');

        if (isCreacion) {
            wrapperDocExistente.classList.add('d-none');
            wrapperCreacion.classList.remove('d-none');
            wrapperAdjunto.classList.remove('d-none');
            document.getElementById('admin_nombre_propuesto').required = true;
            document.getElementById('admin_documento_id').required = false;
        } else {
            wrapperDocExistente.classList.remove('d-none');
            wrapperCreacion.classList.add('d-none');
            document.getElementById('admin_nombre_propuesto').required = false;
            document.getElementById('admin_documento_id').required = true;

            if (isEliminacion) {
                wrapperAdjunto.classList.add('d-none');
            } else {
                wrapperAdjunto.classList.remove('d-none');
            }
        }
    }

    function autoFillAdminDocDetails(selectEl) {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        if (!selectedOption.value) return;

        const procesoId = selectedOption.getAttribute('data-proceso');
        const areaId = selectedOption.getAttribute('data-area');
        const tipoDocId = selectedOption.getAttribute('data-tipodoc');

        if (procesoId) document.getElementById('admin_proceso_id').value = procesoId;
        if (areaId) document.getElementById('admin_area_id').value = areaId;
        if (tipoDocId) document.getElementById('admin_tipo_doc_id').value = tipoDocId;
    }
</script>
@endpush
@endsection
