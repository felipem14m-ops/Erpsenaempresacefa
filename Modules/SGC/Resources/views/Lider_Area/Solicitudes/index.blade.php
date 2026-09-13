@extends('sgc::layouts.master')

@section('title', 'SGC • Gestión de Solicitudes Documentales')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & ACTION BUTTON ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">Gestión de Solicitudes Documentales</h2>
            <p class="text-muted small mb-0" style="font-size: 13.5px;">Consulte el estado de sus trámites ante Calidad, descargue anexos y radique nuevas solicitudes de creación, modificación o eliminación.</p>
        </div>

        <div>
            <button type="button" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none; font-size: 14px;" data-bs-toggle="modal" data-bs-target="#modalNuevaSolicitud">
                <i class="fas fa-file-circle-plus fs-6"></i>
                <span>+ Radicar Nueva Solicitud</span>
            </button>
        </div>
    </div>

    <!-- ======= FLASH ALERTS ======= -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #eaf8ea; color: #39A900;">
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
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #ffebee; color: #ef4444;">
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
        <div class="alert alert-warning alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white" role="alert">
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
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f1f5f9; color: #475569;">
                        <i class="fas fa-file-lines fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Total Radicadas</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">{{ $totalRadicadas ?? $solicitudes->total() }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Solicitudes generadas</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 2: En Trámite / Revisión -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #fef9e7; color: #eab308;">
                        <i class="fas fa-clock-rotate-left fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">En Trámite</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">{{ $enTramite ?? 0 }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">En revisión por Calidad</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 3: Aprobadas / Publicadas -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                        <i class="fas fa-circle-check fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Aprobadas</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">{{ $aprobadas ?? 0 }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Documentos aprobados</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 4: Con Observaciones / Rechazadas -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #ffebee; color: #ef4444;">
                        <i class="fas fa-triangle-exclamation fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Con Observaciones</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">{{ $rechazadas ?? 0 }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Requieren ajustes</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= SEARCH AND FILTERS BAR ======= -->
    <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
        <form method="GET" action="{{ route('sgc.lider_area.solicitudes.index') }}">
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
                    <button type="submit" class="btn text-white w-100 fw-semibold rounded-3" style="background-color: #39A900; border: none;">
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
                        <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada / Con observaciones</option>
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
                    <a href="{{ route('sgc.lider_area.solicitudes.index') }}" class="btn btn-sm btn-link text-muted text-decoration-none">
                        <i class="fas fa-rotate-left me-1"></i> Limpiar filtros
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- ======= LISTADO DE SOLICITUDES RADICADAS (TABLA) ======= -->
    <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0 fs-6">Listado de Solicitudes Radicadas</h5>
            <span class="badge bg-light text-secondary border px-2.5 py-1.5 fw-bold">
                {{ $solicitudes->total() }} Solicitud(es)
            </span>
        </div>

        <div class="table-responsive p-3">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.5px;">
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
                                @if($sol->tipo === 'creacion')
                                    <span class="badge rounded-pill px-2.5 py-1 text-primary bg-primary-subtle fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-plus-circle me-1"></i> Creación
                                    </span>
                                @elseif($sol->tipo === 'modificacion')
                                    <span class="badge rounded-pill px-2.5 py-1 text-warning-emphasis bg-warning-subtle fw-semibold" style="font-size: 11.5px;">
                                        <i class="fas fa-pen-to-square me-1"></i> Modificación
                                    </span>
                                @elseif($sol->tipo === 'eliminacion')
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
                                    <a href="{{ route('sgc.lider_area.solicitudes.download-adjunto', $sol->id) }}" class="btn btn-sm btn-outline-success rounded-2 px-2 py-1 d-inline-flex align-items-center gap-1" title="Descargar borrador adjunto" style="font-size: 11.5px;">
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
                                <a href="{{ route('sgc.lider_area.solicitudes.show', $sol->id) }}" class="btn btn-sm btn-light border rounded-2 px-2.5 py-1 text-dark fw-medium d-inline-flex align-items-center gap-1.5 shadow-2xs" title="Ver Detalles de la Solicitud">
                                    <i class="fas fa-eye text-secondary"></i>
                                    <span>Detalle</span>
                                </a>
                            </td>
                        </tr>

                        <!-- ======= MODAL DETALLE DE SOLICITUD ======= -->
                        <div class="modal fade" id="modalDetalle{{ $sol->id }}" tabindex="-1" aria-labelledby="modalDetalleLabel{{ $sol->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
                                    <div class="modal-header border-bottom px-4 py-3 bg-white">
                                        <div class="d-flex align-items-center gap-3">
                                            <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalDetalleLabel{{ $sol->id }}" style="font-family: 'Outfit', sans-serif;">
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
                                                <div class="card border rounded-4 bg-white p-4 shadow-xs">
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
                                                            <strong class="text-dark" style="font-size: 13.5px;">{{ $sol->fecha_radicacion ? $sol->fecha_radicacion->translatedFormat('d-M-Y') : 'N/A' }}</strong>
                                                        </div>
                                                        <div class="col-4">
                                                            <small class="text-muted d-block" style="font-size: 11px;">Solicitante</small>
                                                            <strong class="text-dark" style="font-size: 13.5px;">{{ $sol->solicitante->nombre_completo ?? ($sol->solicitante->nombre_usuario ?? 'Líder de Área') }}</strong>
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
                                                                <small class="text-muted" style="font-size: 11px;">Resuelto el: {{ $sol->fecha_resolucion ? $sol->fecha_resolucion->translatedFormat('d-M-Y') : now()->translatedFormat('d-M-Y') }}</small>
                                                            </div>
                                                            <p class="text-dark mb-0 small" style="line-height: 1.5;">{{ $sol->observaciones_resp ?: 'Se revisó la propuesta del borrador y se valida la coherencia frente al marco regulatorio. Procedimiento de cambio aplicado satisfactoriamente.' }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Right Col -->
                                            <div class="col-12 col-lg-4">
                                                <div class="card border rounded-4 bg-white p-4 shadow-xs">
                                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">Borrador Adjunto</h6>
                                                    <small class="text-muted d-block mb-3" style="font-size: 11.5px;">Documento borrador cargado por el solicitante</small>

                                                    @if($sol->adjunto_ruta)
                                                        <div class="border rounded-3 p-3 d-flex align-items-center justify-content-between bg-white">
                                                            <div class="d-flex align-items-center gap-2 text-truncate me-2">
                                                                <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background-color: #eaf8ea; color: #39A900;">
                                                                    <i class="fas fa-file-word"></i>
                                                                </div>
                                                                <div class="text-truncate">
                                                                    <strong class="text-dark d-block text-truncate small" title="{{ basename($sol->adjunto_ruta) }}">{{ basename($sol->adjunto_ruta) }}</strong>
                                                                    <small class="text-muted" style="font-size: 10.5px;">{{ strtoupper(pathinfo($sol->adjunto_ruta, PATHINFO_EXTENSION)) }} · Adjunto</small>
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('sgc.lider_area.solicitudes.download-adjunto', $sol->id) }}" class="btn btn-light btn-sm border rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
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
                                        <a href="{{ route('sgc.lider_area.solicitudes.show', $sol->id) }}" class="btn btn-sm btn-outline-success rounded-3 px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 13px;">
                                            <i class="fas fa-up-right-from-square"></i>
                                            <span>Ver en Pantalla Completa</span>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-secondary rounded-3 px-3 py-1.5" data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background-color: #f1f5f9; color: #94a3b8;">
                                        <i class="fas fa-folder-open fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">No se encontraron solicitudes</h6>
                                    <p class="text-muted small mb-3">No hay registros que coincidan con los criterios de búsqueda o aún no ha radicado solicitudes.</p>
                                    <button type="button" class="btn text-white rounded-3 px-3 py-2 fw-semibold" style="background-color: #39A900; border: none;" data-bs-toggle="modal" data-bs-target="#modalNuevaSolicitud">
                                        <i class="fas fa-plus-circle me-1"></i> Radicar Primera Solicitud
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($solicitudes->hasPages())
            <div class="card-footer bg-white border-0 px-4 py-3 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Mostrando {{ $solicitudes->firstItem() ?? 0 }} - {{ $solicitudes->lastItem() ?? 0 }} de {{ $solicitudes->total() }} registros
                </small>
                <div>
                    {{ $solicitudes->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ======= MODAL RADICAR NUEVA SOLICITUD (2-COLUMN DESIGN EXACTLY MATCHING USER'S IMAGE) ======= -->
<div class="modal fade" id="modalNuevaSolicitud" tabindex="-1" aria-labelledby="modalNuevaSolicitudLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">

            <!-- Modal Header -->
            <div class="modal-header border-bottom px-4 pt-4 pb-3 bg-white">
                <div>
                    <h4 class="fw-bold text-dark mb-1" id="modalNuevaSolicitudLabel" style="font-size: 22px; font-family: 'Outfit', sans-serif;">
                        Nueva Solicitud Documental
                    </h4>
                    <p class="text-muted small mb-0" style="font-size: 13px;">
                        Diligencie este formulario para radicar solicitudes de creación, modificación o eliminación ante la oficina de calidad.
                    </p>
                </div>
                <button type="button" class="btn-close align-self-start" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Container -->
            <form action="{{ route('sgc.solicitudes.store') }}" method="POST" enctype="multipart/form-data" id="formRadicarSolicitud">
                @csrf

                <div class="modal-body p-4" style="background-color: #f8fafc;">

                    <div class="row g-4 align-items-stretch">
                        
                        <!-- ======= LEFT COLUMN: MAIN FORM (Card) ======= -->
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="card border rounded-4 bg-white shadow-xs p-4 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    
                                    <!-- 1. Tipo de Solicitud (Radio buttons exactly as in image) -->
                                    <div class="mb-4">
                                        <label class="form-label small fw-semibold text-secondary mb-2" style="font-size: 13px;">
                                            Tipo de Solicitud <span class="text-danger">*</span>
                                        </label>
                                        <div class="d-flex flex-wrap align-items-center gap-4">
                                            <div class="form-check d-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input" type="radio" name="tipo" id="modal_tipo_creacion" value="creacion" checked onchange="toggleModalTipo('creacion')" style="cursor: pointer; width: 18px; height: 18px; accent-color: #39A900;">
                                                <label class="form-check-label fw-semibold text-dark" for="modal_tipo_creacion" style="cursor: pointer; font-size: 13.5px;">
                                                    Creación
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input" type="radio" name="tipo" id="modal_tipo_modificacion" value="modificacion" onchange="toggleModalTipo('modificacion')" style="cursor: pointer; width: 18px; height: 18px; accent-color: #39A900;">
                                                <label class="form-check-label fw-semibold text-dark" for="modal_tipo_modificacion" style="cursor: pointer; font-size: 13.5px;">
                                                    Modificación
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input" type="radio" name="tipo" id="modal_tipo_eliminacion" value="eliminacion" onchange="toggleModalTipo('eliminacion')" style="cursor: pointer; width: 18px; height: 18px; accent-color: #39A900;">
                                                <label class="form-check-label fw-semibold text-dark" for="modal_tipo_eliminacion" style="cursor: pointer; font-size: 13.5px;">
                                                    Eliminación
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. Row with 3 Columns: Proceso, Área, Tipo de Documento -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Proceso de la Solicitud <span class="text-danger">*</span>
                                            </label>
                                            <select name="proceso_id" id="modal_proceso_id" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required onchange="filterModalAreas(this.value)">
                                                <option value="" disabled selected>Seleccione un proceso...</option>
                                                @foreach($procesos as $proc)
                                                    <option value="{{ $proc->id }}">{{ $proc->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Área Solicitante <span class="text-danger">*</span>
                                            </label>
                                            <select name="area_id" id="modal_area_id" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                                <option value="" disabled selected>Área Agroindustrial</option>
                                                @foreach($areas as $ar)
                                                    <option value="{{ $ar->id }}" data-proceso-id="{{ $ar->proceso_id ?? '' }}">{{ $ar->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Tipo de Documento <span class="text-danger">*</span>
                                            </label>
                                            <select name="tipo_doc_id" id="modal_tipo_doc_id" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                                <option value="" disabled selected>Procedimiento</option>
                                                @foreach($tiposDoc as $td)
                                                    <option value="{{ $td->id }}">{{ $td->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- 3. Documento relacionado (Disabled for Creación, Enabled for Modificación/Eliminación) -->
                                    <div class="mb-3" id="wrapper_doc_relacionado">
                                        <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                            Documento relacionado <span class="text-muted fw-normal" style="font-size: 11.5px;">(Solo requerido para Modificación o Eliminación)</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 text-muted ps-3" style="border-color: #e2e8f0;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                                </svg>
                                            </span>
                                            <input type="text" 
                                                   id="input_buscar_doc_modal" 
                                                   class="form-control rounded-end-3 py-2 bg-light border-start-0" 
                                                   style="font-size: 13.5px; border-color: #e2e8f0;" 
                                                   placeholder="Buscar documento vigente para asociar..."
                                                   list="modalListDocumentos"
                                                   autocomplete="off"
                                                   disabled>
                                            <input type="hidden" name="documento_id" id="modal_hidden_doc_id">
                                            <datalist id="modalListDocumentos">
                                                @foreach($documentos as $doc)
                                                    <option value="{{ $doc->codigo }} — {{ $doc->nombre }}" 
                                                            data-id="{{ $doc->id }}"
                                                            data-proceso-id="{{ $doc->proceso_id }}"
                                                            data-area-id="{{ $doc->area_id }}"
                                                            data-tipo-doc-id="{{ $doc->tipo_doc_id }}"></option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div id="modal_doc_info_badge" class="mt-1 small text-success d-none">
                                            <i class="fas fa-check-circle me-1"></i> Documento vinculado: <strong id="modal_doc_info_text"></strong>
                                        </div>
                                    </div>

                                    <!-- 4. Justificación de la Solicitud -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                            Justificación de la Solicitud <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="justificacion" 
                                                  id="modal_justificacion" 
                                                  class="form-control rounded-3 py-2 px-3 bg-white border" 
                                                  style="font-size: 13.5px; border-color: #e2e8f0;" 
                                                  rows="4" 
                                                  placeholder="Explique detalladamente el motivo de la solicitud, necesidad técnica, normativa aplicable o mejoras identificadas..." 
                                                  required minlength="10">{{ old('justificacion') }}</textarea>
                                    </div>

                                </div>

                                <!-- 5. Action Buttons (Positioned exactly as in image at bottom right) -->
                                <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top mt-2">
                                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2 fw-semibold" style="font-size: 13.5px; border-color: #e2e8f0; color: #475569;" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="btn text-white rounded-3 px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #39A900; border: none; font-size: 13.5px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-check-fill" viewBox="0 0 16 16">
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                                        </svg>
                                        <span>Radicar Solicitud</span>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <!-- ======= RIGHT COLUMN: ADJUNTAR BORRADOR (Card) ======= -->
                        <div class="col-12 col-lg-5 col-xl-4">
                            <div class="card border rounded-4 bg-white shadow-xs p-4 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1" style="font-size: 15.5px;">Adjuntar Borrador</h5>
                                    <p class="text-muted small mb-3" style="font-size: 12.5px;">Sube un bosquejo o borrador inicial del documento (opcional)</p>

                                    <!-- Box de Carga de Borrador (Interactive dropzone) -->
                                    <div id="dropzoneBorradorModal" 
                                         class="p-4 rounded-4 text-center d-flex flex-column align-items-center justify-content-center position-relative" 
                                         style="background-color: #f8fafc; border: 1px solid #e2e8f0; min-height: 180px; cursor: pointer; transition: all 0.25s ease;">
                                        
                                        <input type="file" name="adjunto" id="fileBorradorModal" class="d-none" accept=".pdf,.docx,.doc,.xlsx,.xls,.png,.jpg">

                                        <!-- Estado Vacío -->
                                        <div id="borradorIdleContent" class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="mb-2 text-muted">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#64748b" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                                                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                                </svg>
                                            </div>
                                            <span class="text-secondary small fw-medium" style="font-size: 13px;">Seleccionar archivo borrador</span>
                                        </div>

                                        <!-- Estado Archivo Seleccionado -->
                                        <div id="borradorSelectedContent" class="d-none flex-column align-items-center justify-content-center w-100 py-1">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px; background-color: #eaf8ea; color: #39A900;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark-check-fill" viewBox="0 0 16 16">
                                                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                                                </svg>
                                            </div>
                                            <strong id="previewBorradorName" class="text-dark d-block text-truncate w-100 px-2" style="font-size: 13px;">borrador.docx</strong>
                                            <span id="previewBorradorSize" class="text-muted small d-block mb-2" style="font-size: 11px;">0 KB</span>
                                            <button type="button" id="btnRemoveBorrador" class="btn btn-sm btn-outline-danger rounded-2 px-3 py-0.5" style="font-size: 11.5px;">
                                                Cambiar
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // 1. Dynamic Toggle between Creación / Modificación / Eliminación in Modal
    function toggleModalTipo(tipo) {
        const inputBuscarDoc = document.getElementById('input_buscar_doc_modal');
        const hiddenDocId = document.getElementById('modal_hidden_doc_id');
        const docBadge = document.getElementById('modal_doc_info_badge');

        if (tipo === 'creacion') {
            if (inputBuscarDoc) {
                inputBuscarDoc.disabled = true;
                inputBuscarDoc.value = '';
                inputBuscarDoc.placeholder = 'Buscar documento vigente para asociar...';
                inputBuscarDoc.classList.add('bg-light');
                inputBuscarDoc.classList.remove('bg-white');
            }
            if (hiddenDocId) hiddenDocId.value = '';
            if (docBadge) docBadge.classList.add('d-none');
        } else {
            if (inputBuscarDoc) {
                inputBuscarDoc.disabled = false;
                inputBuscarDoc.placeholder = 'Escriba o seleccione el documento que desea ' + tipo + '...';
                inputBuscarDoc.classList.remove('bg-light');
                inputBuscarDoc.classList.add('bg-white');
                inputBuscarDoc.focus();
            }
        }
    }

    // 2. Filter Areas by Selected Proceso in Modal
    function filterModalAreas(procesoId) {
        const areaSelect = document.getElementById('modal_area_id');
        if (!areaSelect) return;

        let hasSelected = false;
        Array.from(areaSelect.options).forEach((opt, idx) => {
            if (idx === 0) return;
            const optProcId = opt.getAttribute('data-proceso-id');
            if (!procesoId || !optProcId || optProcId === procesoId) {
                opt.style.display = 'block';
                if (!hasSelected) {
                    areaSelect.value = opt.value;
                    hasSelected = true;
                }
            } else {
                opt.style.display = 'none';
            }
        });
    }

    // 3. Autocomplete and capture document_id and autofill metadata
    document.addEventListener('DOMContentLoaded', function () {
        const inputBuscarDoc = document.getElementById('input_buscar_doc_modal');
        const hiddenDocId = document.getElementById('modal_hidden_doc_id');
        const listDocs = document.getElementById('modalListDocumentos');
        const docBadge = document.getElementById('modal_doc_info_badge');
        const docText = document.getElementById('modal_doc_info_text');

        if (inputBuscarDoc && listDocs) {
            inputBuscarDoc.addEventListener('input', function () {
                const val = this.value.trim();
                const matchedOption = listDocs.querySelector(`option[value="${val}"]`);
                if (matchedOption) {
                    const docId = matchedOption.getAttribute('data-id');
                    const procId = matchedOption.getAttribute('data-proceso-id');
                    const areaId = matchedOption.getAttribute('data-area-id');
                    const tipoDocId = matchedOption.getAttribute('data-tipo-doc-id');

                    if (hiddenDocId) hiddenDocId.value = docId;
                    if (procId) document.getElementById('modal_proceso_id').value = procId;
                    if (areaId) document.getElementById('modal_area_id').value = areaId;
                    if (tipoDocId) document.getElementById('modal_tipo_doc_id').value = tipoDocId;

                    if (docBadge && docText) {
                        docText.textContent = val;
                        docBadge.classList.remove('d-none');
                    }
                } else {
                    if (hiddenDocId) hiddenDocId.value = '';
                    if (docBadge) docBadge.classList.add('d-none');
                }
            });
        }

        // 4. Drag and Drop for Borrador Dropzone
        const dropzone = document.getElementById('dropzoneBorradorModal');
        const fileInput = document.getElementById('fileBorradorModal');
        const idleContent = document.getElementById('borradorIdleContent');
        const selectedContent = document.getElementById('borradorSelectedContent');
        const previewName = document.getElementById('previewBorradorName');
        const previewSize = document.getElementById('previewBorradorSize');
        const btnRemove = document.getElementById('btnRemoveBorrador');

        if (dropzone && fileInput) {
            dropzone.addEventListener('click', function (e) {
                if (e.target !== btnRemove) {
                    fileInput.click();
                }
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.style.borderColor = '#39A900';
                    dropzone.style.backgroundColor = '#f0fdf4';
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.style.borderColor = '#e2e8f0';
                    dropzone.style.backgroundColor = '#f8fafc';
                }, false);
            });

            dropzone.addEventListener('drop', function (e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    updateBorradorPreview(files[0]);
                }
            });

            fileInput.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    updateBorradorPreview(this.files[0]);
                }
            });

            if (btnRemove) {
                btnRemove.addEventListener('click', function (e) {
                    e.stopPropagation();
                    fileInput.value = '';
                    idleContent.classList.remove('d-none');
                    idleContent.classList.add('d-flex');
                    selectedContent.classList.add('d-none');
                    selectedContent.classList.remove('d-flex');
                    fileInput.click();
                });
            }

            function updateBorradorPreview(file) {
                if (!file) return;
                previewName.textContent = file.name;
                const sizeKb = (file.size / 1024).toFixed(1);
                const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                previewSize.textContent = file.size > 1024 * 1024 ? `${sizeMb} MB` : `${sizeKb} KB`;

                idleContent.classList.add('d-none');
                idleContent.classList.remove('d-flex');
                selectedContent.classList.remove('d-none');
                selectedContent.classList.add('d-flex');
            }
        }

        // Auto open modal if query parameter abrir_modal is present
        @if(request('abrir_modal'))
            var myModal = new bootstrap.Modal(document.getElementById('modalNuevaSolicitud'));
            myModal.show();
        @endif
    });
</script>
@endpush
@endsection
