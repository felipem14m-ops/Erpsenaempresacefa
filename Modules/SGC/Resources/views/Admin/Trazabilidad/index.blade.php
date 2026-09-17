@extends('sgc::layouts.master')

@section('title', 'SGC • Bitácora de Trazabilidad Documental')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & ACTION BUTTON ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Bitácora de Trazabilidad Documental</h2>
            <p class="text-muted small mb-0">Consulte el registro de auditoría completo de todas las acciones del sistema.</p>
        </div>

        <div>
            <a href="{{ route('sgc.trazabilidad.export', request()->all()) }}" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                    <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                </svg>
                <span>Exportar Bitácora</span>
            </a>
        </div>
    </div>

    <!-- ======= FLASH ALERTS ======= -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #eaf8ea; color: #39A900;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Operación completada exitosamente</strong>
                <span class="text-secondary small">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ======= SEARCH AND FILTERS BAR ======= -->
    <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
        <form method="GET" action="{{ route('sgc.trazabilidad.index') }}">
            <!-- Search row -->
            <div class="row g-2 mb-3">
                <div class="col-12 col-md-10 col-lg-10">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control bg-light border-start-0 ps-0" placeholder="Buscar registros por usuario, módulo o detalles específicos de auditoría...">
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn text-white w-100 fw-semibold rounded-3" style="background-color: #39A900; border: none;">
                        Buscar
                    </button>
                </div>
            </div>

            <!-- Filters dropdown row -->
            <div class="row g-2 align-items-center">
                <div class="col-12 col-md-4 col-lg-4">
                    <select name="accion" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ ($accion === 'all' || empty($accion)) ? 'selected' : '' }}>Filtrar por Acción: Todas</option>
                        @foreach($accionesList as $acc)
                            @if($acc !== 'Todas')
                                <option value="{{ $acc }}" {{ $accion === $acc ? 'selected' : '' }}>
                                    {{ $acc }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4 col-lg-4">
                    <select name="usuario" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ ($usuario === 'all' || empty($usuario)) ? 'selected' : '' }}>Filtrar por Usuario: Todos</option>
                        <option value="sistema" {{ $usuario === 'sistema' ? 'selected' : '' }}>Sistema SGC</option>
                        @foreach($usuariosList as $u)
                            <option value="{{ $u->id }}" {{ (string)$usuario === (string)$u->id ? 'selected' : '' }}>
                                {{ $u->nombre_completo ?? $u->nombre_usuario }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4 col-lg-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                    <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                    <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                </svg>
                            </span>
                            <input type="date" name="fecha" value="{{ $fecha !== 'hoy' ? $fecha : '' }}" class="form-control bg-light border-start-0 ps-0" onchange="this.form.submit()" title="Filtrar por fecha">
                        </div>
                        @if(!empty($search) || ($accion !== 'all' && !empty($accion)) || ($usuario !== 'all' && !empty($usuario)) || !empty($fecha))
                            <a href="{{ route('sgc.trazabilidad.index') }}" class="btn btn-outline-secondary rounded-3 px-3 text-nowrap" title="Limpiar filtros" style="height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z"/>
                                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- ======= MAIN TRAZABILIDAD TABLE CARD ======= -->
    <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase" style="font-size: 12px; letter-spacing: 0.4px;">
                        <th class="border-0 ps-4 py-3" style="width: 14%;">Fecha y Hora</th>
                        <th class="border-0 py-3" style="width: 17%;">Usuario</th>
                        <th class="border-0 py-3" style="width: 14%;">Rol</th>
                        <th class="border-0 py-3" style="width: 13%;">Acción</th>
                        <th class="border-0 py-3" style="width: 14%;">Módulo Afectado</th>
                        <th class="border-0 py-3" style="width: 24%;">Detalle</th>
                        <th class="border-0 pe-4 py-3 text-center" style="width: 4%;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bitacoras as $log)
                        <tr>
                            <!-- 1. Fecha y Hora -->
                            <td class="ps-4 py-3 text-muted text-nowrap">
                                {{ $log->fecha_formateada }}
                            </td>

                            <!-- 2. Usuario -->
                            <td class="py-3 text-nowrap">
                                <span class="fw-bold text-dark d-block">{{ $log->usuario_nombre }}</span>
                            </td>

                            <!-- 3. Rol -->
                            <td class="py-3 text-muted text-nowrap">
                                {{ $log->usuario_rol }}
                            </td>

                            <!-- 4. Acción con Badge Estilizado Estandarizado -->
                            <td class="py-3">
                                @php
                                    $accNorm = $log->accion_normalizada;
                                    $bg = '#f1f5f9';
                                    $color = '#475569';

                                    if ($accNorm === 'Aprobación') {
                                        $bg = '#eaf8ea';
                                        $color = '#2b8000';
                                    } elseif ($accNorm === 'Creación' || $accNorm === 'Inicio Sesión') {
                                        $bg = '#ebf5ff';
                                        $color = '#1d4ed8';
                                    } elseif ($accNorm === 'Modificación') {
                                        $bg = '#fef3c7';
                                        $color = '#b45309';
                                    } elseif ($accNorm === 'Rechazo' || $accNorm === 'Acceso Fallido' || $accNorm === 'Eliminación') {
                                        $bg = '#ffebee';
                                        $color = '#dc2626';
                                    } elseif ($accNorm === 'Descarga') {
                                        $bg = '#f3e8ff';
                                        $color = '#7e22ce';
                                    }
                                @endphp
                                <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: {{ $bg }}; color: {{ $color }}; font-size: 11.5px;">
                                    {{ $accNorm }}
                                </span>
                            </td>

                            <!-- 5. Módulo Afectado -->
                            <td class="py-3 text-dark fw-medium text-nowrap">
                                {{ $log->modulo ?? 'Documentos' }}
                            </td>

                            <!-- 6. Detalle de la Operación -->
                            <td class="py-3 text-muted">
                                <span class="d-inline-block text-truncate" style="max-width: 320px;" title="{{ $log->descripcion }}">
                                    {{ $log->descripcion }}
                                </span>
                            </td>

                            <!-- 7. Botón de Detalle Modal Estandarizado -->
                            <td class="pe-4 py-3 text-center">
                                <button type="button" class="btn btn-sm btn-outline-success rounded-2 d-inline-flex align-items-center justify-content-center p-1" title="Ver detalles técnicos de auditoría" onclick="openAuditDetail({{ $log->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-clipboard-x d-block mx-auto mb-2 text-secondary opacity-50" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708"/>
                                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                                    </svg>
                                    <h6 class="fw-bold text-dark mb-1">No se encontraron registros de auditoría</h6>
                                    <p class="text-secondary small mb-2">No hay eventos que coincidan con los criterios de búsqueda o filtros seleccionados.</p>
                                    @if(!empty($search) || ($accion !== 'all' && !empty($accion)) || ($usuario !== 'all' && !empty($usuario)) || !empty($fecha))
                                        <a href="{{ route('sgc.trazabilidad.index') }}" class="btn btn-sm btn-outline-success rounded-3 px-3 fw-semibold">
                                            Restablecer Filtros
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card Footer with Standardized Pagination -->
        <div class="card-footer bg-white border-top py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="text-muted small">
                Mostrando {{ $bitacoras->firstItem() ?? 0 }}-{{ $bitacoras->lastItem() ?? 0 }} de {{ $bitacoras->total() }} registros de auditoría
            </div>
            <div>
                {{ $bitacoras->links('sgc::layouts.partials.pagination') }}
            </div>
        </div>
    </div>

</div>

<!-- ======= MODAL: DETALLES TÉCNICOS DE AUDITORÍA ======= -->
<div class="modal fade" id="modalAuditDetail" tabindex="-1" aria-labelledby="modalAuditDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow overflow-hidden">
            <div class="modal-header bg-light px-4 py-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #eaf8ea; color: #39A900;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16">
                            <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-dark mb-0" id="modalAuditDetailLabel">
                            Detalles de Registro de Auditoría
                        </h6>
                        <small class="text-muted" id="modalAuditSubtitle">Cargando...</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modalAuditBody">
                <div class="text-center py-4">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-2.5 border-top">
                <button type="button" class="btn btn-secondary btn-sm rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openAuditDetail(id) {
        const modal = new bootstrap.Modal(document.getElementById('modalAuditDetail'));
        const modalSubtitle = document.getElementById('modalAuditSubtitle');
        const modalBody = document.getElementById('modalAuditBody');

        modalSubtitle.innerText = 'Consultando registro #' + id;
        modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-success" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        `;
        modal.show();

        fetch(`{{ url('sgc/trazabilidad') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    const d = res.data;
                    modalSubtitle.innerText = `Registro #${d.id} • ${d.fecha_hora}`;

                    let datosPrev = d.datos_anteriores ? JSON.stringify(d.datos_anteriores, null, 2) : null;
                    let datosNew = d.datos_nuevos ? JSON.stringify(d.datos_nuevos, null, 2) : null;

                    modalBody.innerHTML = `
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Fecha y Hora</label>
                                <div class="fw-semibold text-dark">${d.fecha_hora}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Módulo y Entidad</label>
                                <div class="fw-semibold text-dark">${d.modulo} • ${d.entidad} ${d.entidad_id ? `(#${d.entidad_id})` : ''}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Usuario Responsable</label>
                                <div class="fw-bold text-dark">${d.usuario}</div>
                                <small class="text-muted">${d.rol}</small>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Acción y Resultado</label>
                                <div>
                                    <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #eaf8ea; color: #2b8000; font-size: 11.5px;">${d.accion}</span>
                                    <span class="badge rounded-2 px-2 py-1 fw-semibold bg-light text-dark border ms-1" style="font-size: 11.5px;">${d.resultado}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Descripción del Evento</label>
                                <div class="p-3 bg-light rounded-3 border text-secondary">${d.descripcion}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Dirección IP</label>
                                <div class="font-monospace text-dark small">${d.ip_address}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Navegador / User Agent</label>
                                <div class="text-truncate text-muted small" title="${d.user_agent}">${d.user_agent}</div>
                            </div>
                            ${datosPrev || datosNew ? `
                            <div class="col-12 mt-2">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Carga de Datos (JSON)</label>
                                <div class="row g-2">
                                    ${datosPrev ? `
                                    <div class="col-12 col-md-6">
                                        <small class="text-muted fw-bold d-block mb-1">Estado Previo:</small>
                                        <pre class="bg-light p-2.5 rounded-3 border small mb-0 font-monospace text-secondary" style="max-height: 180px; overflow-y: auto;">${datosPrev}</pre>
                                    </div>` : ''}
                                    ${datosNew ? `
                                    <div class="col-12 ${datosPrev ? 'col-md-6' : 'col-12'}">
                                        <small class="text-muted fw-bold d-block mb-1">Estado Nuevo:</small>
                                        <pre class="bg-light p-2.5 rounded-3 border small mb-0 font-monospace text-dark" style="max-height: 180px; overflow-y: auto;">${datosNew}</pre>
                                    </div>` : ''}
                                </div>
                            </div>` : ''}
                        </div>
                    `;
                } else {
                    modalBody.innerHTML = `<div class="alert alert-danger mb-0">No se pudo obtener la información de auditoría.</div>`;
                }
            })
            .catch(() => {
                modalBody.innerHTML = `<div class="alert alert-danger mb-0">Error al comunicarse con el servidor.</div>`;
            });
    }
</script>
@endpush
