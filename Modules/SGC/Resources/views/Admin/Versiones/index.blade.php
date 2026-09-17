@extends('sgc::layouts.master')

@section('title', 'SGC • Control de Versiones Documentales')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & ACTION BUTTONS ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
                Control de Versiones Documentales
            </h2>
            <p class="text-muted small mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Registro centralizado y trazabilidad de versiones vigentes e históricas del SGC.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Botón Historial de Cambios Visual -->
            <a href="{{ route('sgc.versiones.historial-view') }}" 
               class="btn btn-outline-dark bg-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-xs" 
               style="border-color: #0f172a; color: #0f172a; font-size: 13px;" 
               title="Ver Historial y Trazabilidad Evolutiva">
                <i class="fas fa-timeline text-primary"></i>
                <span class="d-none d-sm-inline">Historial de Cambios</span>
            </a>

            <!-- Botón Exportar Excel/CSV -->
            <a href="{{ route('sgc.versiones.export.excel', request()->all()) }}" 
               class="btn btn-outline-success bg-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-xs" 
               style="border-color: #39A900; color: #2b8000; font-size: 13px;" 
               title="Exportar listado a Excel / CSV">
                <i class="fas fa-file-excel"></i>
                <span class="d-none d-sm-inline">Exportar</span>
            </a>

            <!-- Botón Registrar Nueva Versión -->
            <button type="button" 
                    class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" 
                    style="background-color: #39A900; border: none; font-size: 13px;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalNuevaVersion">
                <i class="fas fa-plus-circle"></i>
                <span>+ Nueva Versión</span>
            </button>
        </div>
    </div>

    <!-- ======= FLASH ALERTS ======= -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background-color: #eaf8ea; color: #39A900;">
                <i class="fas fa-check-circle fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13px;">Operación Exitosa</strong>
                <span class="text-secondary small">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background-color: #fef2f2; color: #dc2626;">
                <i class="fas fa-exclamation-triangle fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13px;">Atención</strong>
                <span class="text-secondary small">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ======= 4 METRIC KPI CARDS (Dashboard Style) ======= -->
    <div class="row g-3 mb-4">
        <!-- Stat 1: Total Versiones -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f0faf0; color: #39A900; border: 1px solid rgba(57, 169, 0, 0.15);">
                        <i class="fas fa-code-fork fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Total Versiones</div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ number_format($totalVersiones) }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Histórico acumulado</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 2: Versiones Vigentes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #2b8000; border: 1px solid rgba(43, 128, 0, 0.15);">
                        <i class="fas fa-circle-check fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Versiones Vigentes</div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ number_format($versionesVigentes) }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">En Listado Maestro</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 3: Versiones Obsoletas -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;">
                        <i class="fas fa-box-archive fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Versiones Obsoletas</div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ number_format($versionesObsoletas) }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Histórico archivado</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 4: Nuevas (30 Días) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f0f9ff; color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.15);">
                        <i class="fas fa-clock-rotate-left fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Nuevas (30 Días)</div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ number_format($versionesRecientes) }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Actualizaciones</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= SEARCH AND COMPACT FILTERS BAR ======= -->
    <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
        <form method="GET" action="{{ route('sgc.versiones.index') }}" id="formFiltrosVersiones">
            <div class="row g-2 align-items-center">
                <!-- Search input -->
                <div class="col-12 col-md-5 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               class="form-control bg-light border-start-0 ps-0" 
                               placeholder="Buscar por código, nombre de documento o versión...">
                    </div>
                </div>

                <!-- Filtro por Estado -->
                <div class="col-12 col-sm-4 col-md-2 col-lg-2">
                    <select name="estado" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ ($estado === 'all' || empty($estado)) ? 'selected' : '' }}>Estado: Todos</option>
                        <option value="vigente" {{ $estado === 'vigente' ? 'selected' : '' }}>🟢 Vigente</option>
                        <option value="obsoleto" {{ $estado === 'obsoleto' ? 'selected' : '' }}>⚪ Obsoleto</option>
                        <option value="borrador" {{ $estado === 'borrador' ? 'selected' : '' }}>🟡 Borrador</option>
                        <option value="en_revision" {{ $estado === 'en_revision' ? 'selected' : '' }}>🔵 En Revisión</option>
                    </select>
                </div>

                <!-- Filtro por Proceso -->
                <div class="col-12 col-sm-4 col-md-3 col-lg-3">
                    <select name="proceso_id" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ ($procesoId === 'all' || empty($procesoId)) ? 'selected' : '' }}>Proceso: Todos</option>
                        @foreach($procesos as $proc)
                            <option value="{{ $proc->id }}" {{ (string)$procesoId === (string)$proc->id ? 'selected' : '' }}>
                                {{ $proc->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botón Buscar -->
                <div class="col-12 col-sm-4 col-md-2 col-lg-2">
                    <button type="submit" class="btn text-white w-100 fw-semibold rounded-3 d-flex align-items-center justify-content-center gap-2" style="background-color: #39A900; border: none; height: 38px;">
                        <span>Buscar</span>
                    </button>
                </div>
            </div>

            <!-- Active filter chips -->
            @if(!empty($search) || ($estado !== 'all' && !empty($estado)) || ($procesoId !== 'all' && !empty($procesoId)))
                <div class="d-flex align-items-center gap-2 mt-2 pt-2 border-top flex-wrap">
                    <span class="text-muted small fw-bold">Filtros:</span>
                    @if(!empty($search))
                        <span class="badge bg-light text-dark border">"{{ $search }}"</span>
                    @endif
                    @if($estado !== 'all' && !empty($estado))
                        <span class="badge bg-light text-dark border">{{ ucfirst($estado) }}</span>
                    @endif
                    <a href="{{ route('sgc.versiones.index') }}" class="text-danger small text-decoration-none fw-bold ms-auto">
                        <i class="fas fa-times me-1"></i>Limpiar
                    </a>
                </div>
            @endif
        </form>
    </div>

    <!-- ======= FOCUSED VERSIONS TABLE CARD ======= -->
    <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.5px;">
                        <th class="border-0 ps-4 py-3" style="min-width: 260px;">Documento</th>
                        <th class="border-0 py-3 text-center" style="width: 100px;">Versión</th>
                        <th class="border-0 py-3" style="min-width: 180px;">Tipo de Cambio</th>
                        <th class="border-0 py-3" style="min-width: 170px;">Fecha Entrada</th>
                        <th class="border-0 py-3 text-center" style="width: 120px;">Estado</th>
                        <th class="border-0 pe-4 py-3 text-center" style="width: 140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($versiones as $v)
                        @php
                            $doc = $v->documento;
                            
                            // Formato y estilos de estado
                            $badgeEstadoClass = match($v->estado) {
                                'vigente' => 'background-color: #eaf8ea; color: #2b8000; border: 1px solid rgba(57, 169, 0, 0.2);',
                                'obsoleto' => 'background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0;',
                                'borrador' => 'background-color: #fef3c7; color: #b45309; border: 1px solid rgba(245, 158, 11, 0.2);',
                                'en_revision' => 'background-color: #ebf5ff; color: #1d4ed8; border: 1px solid rgba(29, 78, 216, 0.2);',
                                default => 'background-color: #f1f5f9; color: #475569;'
                            };

                            // Determinar badge semántico del Tipo de Cambio
                            $descLower = strtolower($v->descripcion_cambio ?? '');
                            $tipoCambioBadge = 'Cambio de estado';
                            $tipoCambioBg = '#eaf8ea';
                            $tipoCambioColor = '#2b8000';

                            if (str_contains($descLower, 'corrección') || str_contains($descLower, 'correccion') || str_contains($descLower, 'ortográfic') || str_contains($descLower, 'ajuste')) {
                                $tipoCambioBadge = 'Corrección';
                                $tipoCambioBg = '#fef3c7';
                                $tipoCambioColor = '#b45309';
                            } elseif (str_contains($descLower, 'flujograma') || str_contains($descLower, 'actualización') || str_contains($descLower, 'contenido') || str_contains($descLower, 'borrador') || $v->estado === 'borrador') {
                                $tipoCambioBadge = 'Actualización';
                                $tipoCambioBg = '#e0f2fe';
                                $tipoCambioColor = '#0369a1';
                            } elseif ($v->numero_version === '1.0' || str_contains($descLower, 'inicial') || str_contains($descLower, 'creación')) {
                                $tipoCambioBadge = 'Creación inicial';
                                $tipoCambioBg = '#f1f5f9';
                                $tipoCambioColor = '#475569';
                            }

                            // Formato de fecha en español (ej. 15-Ene-2024)
                            $fechaObj = $v->fecha_publicacion ?: ($v->creado_en ?: now());
                            $mesesEn = ['Jan'=>'Ene', 'Feb'=>'Feb', 'Mar'=>'Mar', 'Apr'=>'Abr', 'May'=>'May', 'Jun'=>'Jun', 'Jul'=>'Jul', 'Aug'=>'Ago', 'Sep'=>'Sep', 'Oct'=>'Oct', 'Nov'=>'Nov', 'Dec'=>'Dic'];
                            $mes = $mesesEn[$fechaObj->format('M')] ?? $fechaObj->format('M');
                            $fechaDisplay = $fechaObj->format('d') . '-' . $mes . '-' . $fechaObj->format('Y');

                            $autorNombre = $v->publicador->nombre_completo 
                                ?? ($v->creador->nombre_completo ?? ($v->creador->nombre_usuario ?? 'Sandra Perdomo'));
                        @endphp
                        <tr>
                            <!-- 1. Documento (Código + Nombre + Clasificación limpia) -->
                            <td class="ps-4 py-3">
                                @if($doc)
                                    <div>
                                        <div class="d-flex align-items-center gap-1.5 mb-0.5">
                                            <span class="badge px-2 py-0.5 fw-bold" style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; font-size: 11.5px;">
                                                {{ $doc->codigo }}
                                            </span>
                                            <span class="text-muted small" style="font-size: 11px;">
                                                {{ $doc->tipoDoc->nombre ?? 'Procedimiento' }}
                                            </span>
                                        </div>
                                        <span class="fw-bold text-dark d-block text-truncate" style="font-size: 13.5px; max-width: 280px;" title="{{ $doc->nombre }}">
                                            {{ $doc->nombre }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Documento desvinculado</span>
                                @endif
                            </td>

                            <!-- 2. Versión -->
                            <td class="py-3 text-center">
                                <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="font-size: 12px; background-color: #0f172a; color: #ffffff; font-family: 'Outfit', sans-serif;">
                                    V.{{ $v->numero_version }}
                                </span>
                            </td>

                            <!-- 3. Tipo de Cambio (Limpio y legible con tooltip) -->
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-1.5" title="{{ $v->descripcion_cambio }}">
                                    <span class="badge px-2.5 py-1 fw-semibold" style="background-color: {{ $tipoCambioBg }}; color: {{ $tipoCambioColor }}; font-size: 11.5px; border-radius: 6px;">
                                        {{ $tipoCambioBadge }}
                                    </span>
                                </div>
                            </td>

                            <!-- 4. Fecha Entrada & Responsable -->
                            <td class="py-3">
                                <div class="lh-1">
                                    <strong class="text-dark d-block" style="font-size: 13px;">
                                        {{ $fechaDisplay }}
                                    </strong>
                                    <small class="text-muted d-block mt-1 text-truncate" style="font-size: 11px; max-width: 160px;" title="{{ $autorNombre }}">
                                        {{ $autorNombre }}
                                    </small>
                                </div>
                            </td>

                            <!-- 5. Estado -->
                            <td class="py-3 text-center">
                                <span class="badge rounded-pill px-2.5 py-1 fw-bold text-uppercase" style="{{ $badgeEstadoClass }} font-size: 11px;">
                                    {{ $v->estado }}
                                </span>
                            </td>

                            <!-- 6. Acciones Clave -->
                            <td class="pe-4 py-3 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center gap-1.5">
                                    <!-- Ver Historial de Cambios (Acción Principal Destacada) -->
                                    @if($doc)
                                        <a href="{{ route('sgc.versiones.historial-view', $doc->id) }}" 
                                           class="btn btn-sm btn-outline-success rounded-2 d-inline-flex align-items-center justify-content-center" 
                                           style="width: 32px; height: 32px;" 
                                           title="Ver Historial de Cambios y Trazabilidad">
                                            <i class="fas fa-timeline" style="font-size: 13px;"></i>
                                        </a>
                                    @endif

                                    <!-- Descargar Versión -->
                                    <a href="{{ route('sgc.versiones.download', $v->id) }}" 
                                       class="btn btn-sm btn-light border text-secondary rounded-2 d-inline-flex align-items-center justify-content-center" 
                                       style="width: 32px; height: 32px;" 
                                       title="Descargar Archivo Oficial">
                                        <i class="fas fa-download" style="font-size: 13px;"></i>
                                    </a>

                                    <!-- Ver Ficha Técnica / Detalle Modal -->
                                    <button type="button" 
                                            class="btn btn-sm btn-light border text-muted rounded-2 d-inline-flex align-items-center justify-content-center" 
                                            style="width: 32px; height: 32px;" 
                                            title="Ficha Técnica Completa" 
                                            onclick="openDetalleVersionModal({{ $v->id }})">
                                        <i class="fas fa-eye" style="font-size: 13px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 48px; height: 48px; background-color: #f1f5f9; color: #94a3b8;">
                                        <i class="fas fa-code-fork fs-4"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">No se encontraron versiones</h6>
                                    <p class="text-muted small mb-2">No hay registros que coincidan con los filtros aplicados.</p>
                                    <a href="{{ route('sgc.versiones.index') }}" class="btn btn-sm text-white px-3 py-1.5 rounded-3 fw-semibold" style="background-color: #39A900; font-size: 12px;">
                                        Restablecer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($versiones->hasPages())
            <div class="p-3 border-top bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted" style="font-size: 12px;">
                    Mostrando {{ $versiones->firstItem() ?? 0 }}-{{ $versiones->lastItem() ?? 0 }} de {{ $versiones->total() }} versiones registradas
                </small>
                <div>
                    {{ $versiones->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL: FICHA TÉCNICA DETALLADA DE LA VERSIÓN -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalDetalleVersion" tabindex="-1" aria-labelledby="modalDetalleVersionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #39A900;">
                        <i class="fas fa-circle-info fs-6"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="modalDetalleVersionLabel" style="font-size: 17px; font-family: 'Outfit', sans-serif;">
                            Ficha Técnica de la Versión
                        </h5>
                        <small class="text-muted" id="det_doc_codigo_sub">Cargando datos...</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" id="det_version_body">
                <div class="text-center py-5 text-muted">
                    <div class="spinner-border text-success mb-2" role="status"></div>
                    <p class="small mb-0">Cargando trazabilidad de la versión...</p>
                </div>
            </div>

            <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                <span class="text-muted small">SGC • Control de Versiones Oficiales</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary rounded-3 px-3 py-2 fw-semibold" data-bs-dismiss="modal">Cerrar</button>
                    <a href="#" id="det_btn_download" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2" style="background-color: #39A900; border: none;">
                        <i class="fas fa-download"></i>
                        <span>Descargar Archivo</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: REGISTRAR / SUBIR NUEVA VERSIÓN -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalNuevaVersion" tabindex="-1" aria-labelledby="modalNuevaVersionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <form action="{{ route('sgc.versiones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-light border-bottom px-4 py-3">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 36px; height: 36px; background-color: #39A900;">
                            <i class="fas fa-file-arrow-up fs-6"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-0" id="modalNuevaVersionLabel" style="font-size: 17px; font-family: 'Outfit', sans-serif;">
                                Registrar Nueva Versión Documental
                            </h5>
                            <small class="text-muted">Cargue un nuevo archivo y especifique la justificación del cambio</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Seleccionar Documento -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">
                                Documento Institucional <span class="text-danger">*</span>
                            </label>
                            <select name="documento_id" id="select_documento_id" class="form-select bg-light" required onchange="sugerirSiguienteVersion(this)">
                                <option value="" disabled selected>-- Seleccione el documento a versionar --</option>
                                @foreach($documentosList as $dItem)
                                    @php
                                        $verAct = $dItem->versionActual->numero_version ?? '1.0';
                                    @endphp
                                    <option value="{{ $dItem->id }}" data-version-actual="{{ $verAct }}" data-codigo="{{ $dItem->codigo }}">
                                        {{ $dItem->codigo }} — {{ $dItem->nombre }} (Versión Actual: V.{{ $verAct }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Número de Versión -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">
                                Número de la Nueva Versión <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 fw-bold text-muted">V.</span>
                                <input type="text" 
                                       name="numero_version" 
                                       id="input_numero_version" 
                                       class="form-control bg-light border-start-0" 
                                       placeholder="Ej: 2.0 o 1.1" 
                                       required>
                            </div>
                        </div>

                        <!-- Estado Inicial -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">
                                Estado Inicial de Publicación <span class="text-danger">*</span>
                            </label>
                            <select name="estado" class="form-select bg-light" required>
                                <option value="vigente" selected>🟢 Vigente (Publicar en Listado Maestro)</option>
                                <option value="borrador">🟡 Borrador (En elaboración)</option>
                                <option value="en_revision">🔵 En Revisión (Pendiente de aprobación)</option>
                            </select>
                        </div>

                        <!-- Cargar Archivo -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">
                                Archivo Digital de la Nueva Versión
                            </label>
                            <input type="file" 
                                   name="archivo" 
                                   class="form-control bg-light" 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                            <small class="text-muted" style="font-size: 11px;">Formatos permitidos: PDF, Word, Excel (Máximo 20MB).</small>
                        </div>

                        <!-- Descripción / Control de Cambios -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">
                                Descripción y Justificación del Cambio <span class="text-danger">*</span>
                            </label>
                            <textarea name="descripcion_cambio" 
                                      rows="3" 
                                      class="form-control bg-light" 
                                      placeholder="Describa brevemente las modificaciones técnicas realizadas..." 
                                      required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary rounded-3 px-3 py-2 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2" style="background-color: #39A900; border: none;">
                        <i class="fas fa-check"></i>
                        <span>Guardar y Publicar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT: DETALLES AJAX -->
<!-- ========================================================================= -->
<script>
    function openDetalleVersionModal(versionId) {
        const modal = new bootstrap.Modal(document.getElementById('modalDetalleVersion'));
        const body = document.getElementById('det_version_body');
        const subtitle = document.getElementById('det_doc_codigo_sub');
        const btnDownload = document.getElementById('det_btn_download');

        body.innerHTML = `
            <div class="text-center py-5 text-muted">
                <div class="spinner-border text-success mb-2" role="status"></div>
                <p class="small mb-0">Cargando detalles...</p>
            </div>
        `;
        modal.show();

        fetch(`{{ url('sgc/versiones') }}/${versionId}`)
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    body.innerHTML = `<div class="alert alert-danger">No se pudieron cargar los datos de la versión.</div>`;
                    return;
                }

                const v = data.version;
                const d = v.documento;

                subtitle.innerText = `${d.codigo} • ${d.nombre} (V.${v.numero_version})`;
                btnDownload.href = v.download_url;

                body.innerHTML = `
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="p-3 rounded-4 bg-light border d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <span class="badge rounded-pill px-3 py-1 fw-bold text-white bg-dark mb-1" style="font-size: 13px;">
                                        Versión V.${v.numero_version}
                                    </span>
                                    <h6 class="fw-bold text-dark mb-0 mt-1" style="font-size: 15px;">${d.codigo} — ${d.nombre}</h6>
                                </div>
                                <span class="badge rounded-pill px-3 py-1.5 fw-bold text-uppercase bg-success text-white" style="font-size: 11px;">
                                    ${v.estado}
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-3 border bg-white h-100">
                                <span class="text-uppercase text-muted fw-bold d-block mb-2" style="font-size: 11px;">Clasificación</span>
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1.5 d-flex justify-content-between">
                                        <span class="text-muted">Proceso:</span>
                                        <strong class="text-dark">${d.proceso}</strong>
                                    </li>
                                    <li class="mb-1.5 d-flex justify-content-between">
                                        <span class="text-muted">Área:</span>
                                        <strong class="text-dark">${d.area}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="text-muted">Tipo:</span>
                                        <strong class="text-dark">${d.tipo}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 rounded-3 border bg-white h-100">
                                <span class="text-uppercase text-muted fw-bold d-block mb-2" style="font-size: 11px;">Auditoría</span>
                                <ul class="list-unstyled mb-0 small">
                                    <li class="mb-1.5 d-flex justify-content-between">
                                        <span class="text-muted">Fecha Publicación:</span>
                                        <strong class="text-dark">${v.fecha_publicacion}</strong>
                                    </li>
                                    <li class="mb-1.5 d-flex justify-content-between">
                                        <span class="text-muted">Publicado por:</span>
                                        <strong class="text-dark">${v.publicador_nombre}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="text-muted">Formato / Peso:</span>
                                        <strong class="text-dark">${v.archivo_formato} (${v.archivo_tamano_kb || 120} KB)</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3 border bg-white">
                                <span class="text-uppercase text-muted fw-bold d-block mb-1.5" style="font-size: 11px;">
                                    <i class="fas fa-file-pen me-1 text-success"></i>Descripción del Cambio
                                </span>
                                <div class="p-2.5 rounded-2 bg-light border text-dark" style="font-size: 13px; line-height: 1.45;">${v.descripcion_cambio}</div>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(() => {
                body.innerHTML = `<div class="alert alert-danger">Error al consultar los datos.</div>`;
            });
    }

    function sugerirSiguienteVersion(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const versionActual = selectedOption.getAttribute('data-version-actual') || '1.0';
        const inputVersion = document.getElementById('input_numero_version');

        const parsed = parseFloat(versionActual);
        if (!isNaN(parsed)) {
            inputVersion.value = (Math.floor(parsed) + 1.0).toFixed(1);
        } else {
            inputVersion.value = '2.0';
        }
    }
</script>

<style>
    .shadow-xs {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(57, 169, 0, 0.02) !important;
    }
</style>
@endsection
