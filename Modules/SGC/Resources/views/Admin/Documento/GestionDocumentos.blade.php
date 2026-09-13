@extends('sgc::layouts.master')

@section('title', 'SGC • Documentos Vigentes — Listado Maestro')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & ACTION BUTTON ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Documentos Vigentes — Listado Maestro</h2>
            <p class="text-muted small mb-0">Consulte o descargue los documentos oficiales y procedimientos aprobados del Centro Agroindustrial.</p>
        </div>

        <div>
            <button type="button" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;" data-bs-toggle="modal" data-bs-target="#modalCreateDoc">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                <span>+ Nuevo Documento</span>
            </button>
        </div>
    </div>

    <!-- ======= TOP CARDS: DOCUMENTOS FRECUENTES ======= -->
    <div class="mb-4">
        <div class="text-uppercase text-secondary fw-bold mb-3" style="font-size: 11.5px; letter-spacing: 0.6px;">
            Documentos Frecuentes
        </div>
        <div class="row g-3">
            @forelse($frecuentes as $frecItem)
                @php
                    $versionActual = $frecItem->versionActual->numero_version ?? '1.0';
                @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border rounded-4 bg-white shadow-sm p-3 h-100 transition-hover">
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background-color: #eaf8ea; color: #39A900;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list-nested" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.5 11.5A.5.5 0 0 1 5 11h10a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5m-2-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m-2-4A.5.5 0 0 1 1 3h10a.5.5 0 0 1 0 1H1a.5.5 0 0 1-.5-.5"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="fw-bold d-block text-success" style="font-size: 11.5px; color: #39A900 !important;">
                                        {{ $frecItem->codigo }} • V.{{ $versionActual }}
                                    </span>
                                    <span class="fw-bold text-dark d-block text-truncate" style="font-size: 13.5px; max-width: 200px;" title="{{ $frecItem->nombre }}">
                                        {{ $frecItem->nombre }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('sgc.documentos.download', $frecItem->id) }}" class="btn btn-sm btn-light text-secondary rounded-2 border-0 p-2" title="Descargar documento">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                        <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="p-3 bg-white rounded-3 border text-center text-muted small">
                        No hay documentos frecuentes registrados aún.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ======= SEARCH AND FILTERS BAR ======= -->
    <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
        <form method="GET" action="{{ route('sgc.documentos.index') }}">
            <!-- Search row -->
            <div class="row g-2 mb-3">
                <div class="col-12 col-md-10 col-lg-10">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0 ps-0" placeholder="Escriba código o palabra clave de búsqueda...">
                    </div>
                </div>
                <div class="col-12 col-md-2 col-lg-2">
                    <button type="submit" class="btn text-white w-100 fw-semibold rounded-3" style="background-color: #39A900; border: none;">
                        Buscar
                    </button>
                </div>
            </div>

            <!-- Filters dropdown row -->
            <div class="row g-2">
                <div class="col-12 col-md-4 col-lg-4">
                    <select name="proceso_id" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ request('proceso_id') == 'all' || !request('proceso_id') ? 'selected' : '' }}>Proceso: Todos</option>
                        @foreach($procesos as $procItem)
                            <option value="{{ $procItem->id }}" {{ request('proceso_id') == $procItem->id ? 'selected' : '' }}>
                                {{ $procItem->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <select name="area_id" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ request('area_id') == 'all' || !request('area_id') ? 'selected' : '' }}>Área: Todos</option>
                        @foreach($areas as $areaItem)
                            <option value="{{ $areaItem->id }}" {{ request('area_id') == $areaItem->id ? 'selected' : '' }}>
                                {{ $areaItem->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <select name="tipo_doc_id" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="all" {{ request('tipo_doc_id') == 'all' || !request('tipo_doc_id') ? 'selected' : '' }}>Tipo Documental: Todos</option>
                        @foreach($tiposDoc as $tipoItem)
                            <option value="{{ $tipoItem->id }}" {{ request('tipo_doc_id') == $tipoItem->id ? 'selected' : '' }}>
                                {{ $tipoItem->nombre }} ({{ $tipoItem->codigo }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- ======= MAIN DATA TABLE CARD ======= -->
    <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase" style="font-size: 12px; letter-spacing: 0.4px;">
                        <th class="border-0 ps-4 py-3">Código</th>
                        <th class="border-0 py-3">Nombre del Documento</th>
                        <th class="border-0 py-3">Proceso</th>
                        <th class="border-0 py-3">Versión</th>
                        <th class="border-0 py-3">Fecha Pub.</th>
                        <th class="border-0 py-3 text-center">Estado</th>
                        <th class="border-0 pe-4 py-3 text-center" style="width: 140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentos as $docItem)
                        @php
                            $verNum = $docItem->versionActual->numero_version ?? '1.0';
                            $fechaPub = $docItem->fecha_publicacion ? \Carbon\Carbon::parse($docItem->fecha_publicacion)->translatedFormat('d-M-Y') : (\Carbon\Carbon::parse($docItem->creado_en)->translatedFormat('d-M-Y'));
                            
                            $estadoLabel = 'Vigente';
                            $badgeBg = '#eaf8ea';
                            $badgeColor = '#16a34a';

                            if ($docItem->estado === 'borrador') {
                                $estadoLabel = 'Borrador';
                                $badgeBg = '#fef3c7';
                                $badgeColor = '#b45309';
                            } elseif ($docItem->estado === 'en_revision') {
                                $estadoLabel = 'En Revisión';
                                $badgeBg = '#eff6ff';
                                $badgeColor = '#1d4ed8';
                            } elseif ($docItem->estado === 'obsoleto') {
                                $estadoLabel = 'Obsoleto';
                                $badgeBg = '#f1f5f9';
                                $badgeColor = '#64748b';
                            }
                        @endphp
                        <tr>
                            <!-- Código (Verde destacado como en la imagen) -->
                            <td class="ps-4 py-3">
                                <span class="fw-bold" style="color: #39A900; font-weight: 700;">{{ $docItem->codigo }}</span>
                            </td>

                            <!-- Nombre -->
                            <td class="py-3">
                                <span class="fw-bold text-dark d-block">{{ $docItem->nombre }}</span>
                                @if($docItem->area)
                                    <small class="text-muted" style="font-size: 11.5px;">Área: {{ $docItem->area->nombre }}</small>
                                @endif
                            </td>

                            <!-- Proceso -->
                            <td class="py-3 text-muted">
                                {{ $docItem->proceso->nombre ?? 'N/A' }}
                            </td>

                            <!-- Versión -->
                            <td class="py-3 text-muted">
                                {{ $verNum }}
                            </td>

                            <!-- Fecha Publicación -->
                            <td class="py-3 text-muted">
                                {{ $fechaPub }}
                            </td>

                            <!-- Estado -->
                            <td class="py-3 text-center">
                                <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: {{ $badgeBg }}; color: {{ $badgeColor }}; font-size: 11.5px;">
                                    {{ $estadoLabel }}
                                </span>
                            </td>

                            <!-- Acciones -->
                            <td class="pe-4 py-3 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                    <!-- Ver Detalle / Historial / Trazabilidad (Ojo SVG) -->
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-2 d-inline-flex align-items-center justify-content-center" title="Ver Detalle y Trazabilidad" onclick="openDetailModal({{ $docItem->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                        </svg>
                                    </button>

                                    <!-- Descargar Archivo (Descarga SVG) -->
                                    <a href="{{ route('sgc.documentos.download', $docItem->id) }}" class="btn btn-sm btn-outline-success rounded-2 d-inline-flex align-items-center justify-content-center" title="Descargar Documento">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 .5-.5v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                                        </svg>
                                    </a>

                                    <!-- Editar Documento (Lápiz SVG) -->
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-2 d-inline-flex align-items-center justify-content-center" title="Editar Datos" onclick="openEditDocModal({{ json_encode($docItem) }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                        </svg>
                                    </button>

                                    <!-- Eliminar Documento (Canasta SVG con SweetAlert2) -->
                                    <form id="form-delete-doc-{{ $docItem->id }}" action="{{ route('sgc.documentos.destroy', $docItem->id) }}" method="POST" class="d-inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-2 d-inline-flex align-items-center justify-content-center" title="Eliminar Documento" onclick="confirmDeleteDoc({{ $docItem->id }}, '{{ addslashes($docItem->codigo) }}', '{{ addslashes($docItem->nombre) }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 0-.5-.5"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-folder-x d-block mx-auto mb-2 text-secondary opacity-50" viewBox="0 0 16 16">
                                    <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H9.828a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981L1.5 5.5h-1zM11.854 10.146a.5.5 0 0 0-.708.708L12.293 12l-1.147 1.146a.5.5 0 0 0 .708.708L13 12.707l1.146 1.147a.5.5 0 0 0 .708-.708L13.707 12l1.147-1.146a.5.5 0 0 0-.708-.708L13 11.293z"/>
                                </svg>
                                <span class="fw-medium">No se encontraron documentos para los criterios seleccionados.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="card-footer bg-white border-top py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="text-muted small">
                Mostrando {{ $documentos->firstItem() ?? 0 }}-{{ $documentos->lastItem() ?? 0 }} de {{ $documentos->total() }} documentos registrados
            </div>
            <div>
                {{ $documentos->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</div>

<!-- ======= MODAL: REGISTRAR NUEVO DOCUMENTO (FLUJO 1) ======= -->
<!-- ======= MODAL: REGISTRAR NUEVO DOCUMENTO (FLUJO 1) ======= -->
<div class="modal fade" id="modalCreateDoc" tabindex="-1" aria-labelledby="modalCreateDocLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-white border-bottom px-4 py-3">
                <div>
                    <h5 class="modal-title fw-bold text-dark mb-0 fs-5" id="modalCreateDocLabel">Registrar Documento Oficial</h5>
                    <p class="text-muted small mb-0" style="font-size: 13px;">Ingrese la información para la publicación de un nuevo documento en el listado maestro.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sgc.documentos.store') }}" method="POST" enctype="multipart/form-data" id="formModalCreateDoc">
                @csrf
                <div class="modal-body p-4 bg-light">
                    <div class="row g-4 align-items-stretch">
                        
                        <!-- Columna Izquierda: Formulario de Metadatos -->
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="card border rounded-4 bg-white shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <!-- Nombre del Documento -->
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                            Nombre del Documento <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="nombre" 
                                               class="form-control rounded-3 py-2 px-3 bg-white border" 
                                               style="font-size: 13.5px; border-color: #e2e8f0;"
                                               placeholder="Ej: Procedimiento para Compras y Adquisiciones" 
                                               required>
                                    </div>

                                    <!-- Fila 1: Código + Versión -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Código de Documento <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="codigo" 
                                                   class="form-control rounded-3 py-2 px-3 bg-white border text-uppercase font-monospace" 
                                                   style="font-size: 13.5px; border-color: #e2e8f0;"
                                                   placeholder="PR-CA-001" 
                                                   required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Versión Vigente <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="numero_version" 
                                                   class="form-control rounded-3 py-2 px-3 bg-white border" 
                                                   style="font-size: 13.5px; border-color: #e2e8f0;"
                                                   placeholder="1.0" 
                                                   value="1.0" 
                                                   required>
                                        </div>
                                    </div>

                                    <!-- Fila 2: Proceso + Área -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Proceso Asociado <span class="text-danger">*</span>
                                            </label>
                                            <select name="proceso_id" id="modalSelectProceso" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                                <option value="">Seleccione un proceso...</option>
                                                @foreach($procesos as $proc)
                                                    <option value="{{ $proc->id }}">{{ $proc->nombre }} ({{ $proc->codigo }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Área Solicitante <span class="text-danger">*</span>
                                            </label>
                                            <select name="area_id" id="modalSelectArea" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                                <option value="">Seleccione un área...</option>
                                                @foreach($areas as $area)
                                                    <option value="{{ $area->id }}" data-proceso-id="{{ $area->proceso_id }}">{{ $area->nombre }} ({{ $area->codigo }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Fila 3: Tipo Documental + Responsable -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Tipo Documental <span class="text-danger">*</span>
                                            </label>
                                            <select name="tipo_doc_id" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                                <option value="">Seleccione tipo documental...</option>
                                                @foreach($tiposDoc as $tipo)
                                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }} ({{ $tipo->codigo }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Responsable Asignado <span class="text-danger">*</span>
                                            </label>
                                            <select name="responsable_id" class="form-select rounded-3 py-2 px-3 bg-white border" style="font-size: 13.5px; border-color: #e2e8f0;" required>
                                                <option value="">Seleccione responsable...</option>
                                                @foreach($responsables as $resp)
                                                    <option value="{{ $resp->id }}">{{ $resp->nombre_completo ?? $resp->nombre_usuario }} ({{ $resp->rol->nombre ?? 'Resp. Calidad' }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Fila 4: Fecha Elaboración + Fecha Próxima Revisión -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Fecha de Elaboración <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted ps-3" style="border-color: #e2e8f0;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                        <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                                        <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                                    </svg>
                                                </span>
                                                <input type="date" 
                                                       name="fecha_elaboracion" 
                                                       class="form-control rounded-end-3 py-2 bg-white border-start-0" 
                                                       style="font-size: 13.5px; border-color: #e2e8f0;"
                                                       value="{{ date('Y-m-d') }}" 
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label small fw-semibold text-secondary mb-1" style="font-size: 13px;">
                                                Fecha Próxima Revisión <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0 text-muted ps-3" style="border-color: #e2e8f0;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                                        <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                                                        <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                                    </svg>
                                                </span>
                                                <input type="date" 
                                                       name="fecha_proxima_revision" 
                                                       class="form-control rounded-end-3 py-2 bg-white border-start-0" 
                                                       style="font-size: 13.5px; border-color: #e2e8f0;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones en modal -->
                                <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top mt-3">
                                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="font-size: 13.5px;">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="btn text-white rounded-3 px-4 py-2 fw-bold shadow-sm" style="background-color: #39A900; border: none; font-size: 13.5px;">
                                        Registrar Documento
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha: Archivo del Documento & Seguridad -->
                        <div class="col-12 col-lg-5 col-xl-4">
                            <div class="card border rounded-4 bg-white shadow-sm p-4 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;">Archivo del Documento</h5>

                                    <!-- Dropzone Modal -->
                                    <div id="modalDropzoneDoc" 
                                         class="dropzone-area p-4 rounded-4 text-center d-flex flex-column align-items-center justify-content-center position-relative" 
                                         style="border: 2px dashed #86efac; background-color: #f8fafc; min-height: 220px; cursor: pointer; transition: all 0.25s ease;">
                                        
                                        <input type="file" name="archivo" id="modalFileDoc" class="d-none" accept=".pdf,.docx,.doc" required>

                                        <!-- Estado Vacío -->
                                        <div id="modalDropzoneIdle" class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; background-color: transparent;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#22c55e" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                                                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                                </svg>
                                            </div>
                                            <div class="fw-bold text-dark mb-1" style="font-size: 15px;">Arrastre el documento aquí</div>
                                            <div class="text-muted small mb-2" style="font-size: 13px;">o haga clic para seleccionar</div>
                                            <span class="text-muted" style="font-size: 11.5px;">Formatos soportados: PDF o DOCX (Máx. 15MB)</span>
                                        </div>

                                        <!-- Estado Seleccionado -->
                                        <div id="modalDropzoneSelected" class="d-none flex-column align-items-center justify-content-center w-100 py-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-file-earmark-check-fill" viewBox="0 0 16 16">
                                                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                                                </svg>
                                            </div>
                                            <strong id="modalPreviewFileName" class="text-dark d-block text-truncate w-100 px-3" style="font-size: 13.5px;">archivo.pdf</strong>
                                            <span id="modalPreviewFileSize" class="text-muted small d-block mb-3" style="font-size: 11.5px;">0 KB</span>
                                            <button type="button" id="modalBtnRemoveFile" class="btn btn-sm btn-outline-danger rounded-2 px-3 py-1" style="font-size: 12px;">
                                                Cambiar archivo
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                <!-- Security callout -->
                                <div class="rounded-3 p-3 mt-4 d-flex align-items-start gap-2" style="background-color: #f0fdf4; border: 1px solid #dcfce7;">
                                    <div class="flex-shrink-0 text-success pt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#16a34a" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                            <path d="M8 1a2 2 0 0 0-2 2v4H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2m0 1a1 1 0 0 1 1 1v4H7V3a1 1 0 0 1 1-1"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <strong class="d-block" style="color: #15803d; font-size: 13px;">Documentos Seguros</strong>
                                        <p class="mb-0 text-secondary" style="font-size: 11.5px; line-height: 1.45;">
                                            El sistema restringe la descarga pública de borradores sin su debida firma digital y marca de agua oficial de SENA.
                                        </p>
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

<!-- ======= MODAL: EDITAR DOCUMENTO (FLUJO 3) ======= -->
<div class="modal fade" id="modalEditDoc" tabindex="-1" aria-labelledby="modalEditDocLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 bg-white border text-primary shadow-sm d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalEditDocLabel">Modificar Datos del Documento</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Actualización de metadatos y trazabilidad en el SGC</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditDoc" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Código</label>
                            <input type="text" id="edit_codigo" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre del Documento <span class="text-danger">*</span></label>
                            <input type="text" id="edit_nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Proceso <span class="text-danger">*</span></label>
                            <select id="edit_proceso_id" name="proceso_id" class="form-select" required>
                                @foreach($procesos as $procOpt)
                                    <option value="{{ $procOpt->id }}">{{ $procOpt->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Área <span class="text-danger">*</span></label>
                            <select id="edit_area_id" name="area_id" class="form-select" required>
                                @foreach($areas as $areaOpt)
                                    <option value="{{ $areaOpt->id }}">{{ $areaOpt->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Tipo Documental <span class="text-danger">*</span></label>
                            <select id="edit_tipo_doc_id" name="tipo_doc_id" class="form-select" required>
                                @foreach($tiposDoc as $tipoOpt)
                                    <option value="{{ $tipoOpt->id }}">{{ $tipoOpt->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Funcionario Responsable <span class="text-danger">*</span></label>
                            <select id="edit_responsable_id" name="responsable_id" class="form-select" required>
                                @foreach($responsables as $respOpt)
                                    <option value="{{ $respOpt->id }}">{{ $respOpt->nombre_completo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Próxima Revisión</label>
                            <input type="date" id="edit_fecha_proxima_revision" name="fecha_proxima_revision" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Actualizar Archivo (Opcional)</label>
                            <input type="file" name="archivo" class="form-control" accept=".pdf,.docx,.doc">
                            <div class="form-text text-muted" style="font-size: 11.5px;">Dejar vacío si no desea sustituir el archivo vigente actual.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Descripción</label>
                            <textarea id="edit_descripcion" name="descripcion" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted"><span class="text-danger">*</span> Campos obligatorios</small>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success px-4 text-white" style="background-color: #39A900; border-color: #39A900;">Guardar Cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======= MODAL: DETALLE Y TRAZABILIDAD / HISTORIAL (FLUJO 2) ======= -->
<div class="modal fade" id="modalDetailDoc" tabindex="-1" aria-labelledby="modalDetailDocLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 bg-white border text-secondary shadow-sm d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                            <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                            <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="detail_header_title">Detalle del Documento</h5>
                        <p class="text-muted small mb-0" id="detail_header_subtitle" style="font-size: 12.5px;">Metadatos, historial de versiones y bitácora de trazabilidad</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs mb-3" id="detailDocTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-semibold" id="tab-meta-tab" data-bs-toggle="tab" data-bs-target="#tab-meta" type="button" role="tab">Metadatos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="tab-versiones-tab" data-bs-toggle="tab" data-bs-target="#tab-versiones" type="button" role="tab">Historial de Versiones</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="tab-bitacora-tab" data-bs-toggle="tab" data-bs-target="#tab-bitacora" type="button" role="tab">Bitácora de Trazabilidad</button>
                    </li>
                </ul>

                <div class="tab-content" id="detailDocTabsContent">
                    <!-- Tab 1: Metadatos -->
                    <div class="tab-pane fade show active" id="tab-meta" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted d-block">Código</small>
                                    <span class="fw-bold fs-6" id="detail_codigo" style="color: #39A900;">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted d-block">Estado</small>
                                    <span class="fw-bold fs-6 text-dark" id="detail_estado">-</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted d-block">Nombre del Documento</small>
                                    <span class="fw-bold text-dark" id="detail_nombre">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted d-block">Proceso</small>
                                    <span class="fw-semibold text-dark" id="detail_proceso">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted d-block">Área</small>
                                    <span class="fw-semibold text-dark" id="detail_area">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted d-block">Tipo Documental</small>
                                    <span class="fw-semibold text-dark" id="detail_tipo">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted d-block">Funcionario Responsable</small>
                                    <span class="fw-semibold text-dark" id="detail_responsable">-</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-3">
                                    <small class="text-muted d-block">Descripción / Objeto</small>
                                    <p class="mb-0 text-dark small" id="detail_descripcion">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Historial de Versiones -->
                    <div class="tab-pane fade" id="tab-versiones" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Versión</th>
                                        <th>Descripción del Cambio</th>
                                        <th>Formato</th>
                                        <th>Tamaño</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="detail_versiones_tbody">
                                    <!-- Inyectado vía JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab 3: Bitácora de Trazabilidad -->
                    <div class="tab-pane fade" id="tab-bitacora" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" style="font-size: 12.5px;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fecha y Hora</th>
                                        <th>Acción</th>
                                        <th>Usuario</th>
                                        <th>Detalle / Auditoría</th>
                                    </tr>
                                </thead>
                                <tbody id="detail_bitacora_tbody">
                                    <!-- Inyectado vía JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top px-4 py-3">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Abre el modal de edición de documento (Flujo 3)
     */
    function openEditDocModal(doc) {
        document.getElementById('formEditDoc').action = '/sgc/documentos/' + doc.id;
        document.getElementById('edit_codigo').value = doc.codigo || '';
        document.getElementById('edit_nombre').value = doc.nombre || '';
        document.getElementById('edit_proceso_id').value = doc.proceso_id || '';
        document.getElementById('edit_area_id').value = doc.area_id || '';
        document.getElementById('edit_tipo_doc_id').value = doc.tipo_doc_id || '';
        document.getElementById('edit_responsable_id').value = doc.responsable_id || '';
        document.getElementById('edit_fecha_proxima_revision').value = doc.fecha_proxima_revision ? doc.fecha_proxima_revision.substring(0, 10) : '';
        document.getElementById('edit_descripcion').value = doc.descripcion || '';

        var modal = new bootstrap.Modal(document.getElementById('modalEditDoc'));
        modal.show();
    }

    /**
     * Carga y muestra los metadatos, versiones y bitácora del documento en el modal de detalle (Flujo 2)
     */
    function openDetailModal(docId) {
        fetch('/sgc/documentos/' + docId, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const doc = data.documento;
                const bitacoras = data.bitacoras;

                document.getElementById('detail_header_title').innerText = doc.codigo + ' — ' + doc.nombre;
                document.getElementById('detail_codigo').innerText = doc.codigo;
                document.getElementById('detail_nombre').innerText = doc.nombre;
                document.getElementById('detail_estado').innerText = doc.estado ? doc.estado.toUpperCase() : 'VIGENTE';
                document.getElementById('detail_proceso').innerText = doc.proceso ? doc.proceso.nombre : 'N/A';
                document.getElementById('detail_area').innerText = doc.area ? doc.area.nombre : 'N/A';
                document.getElementById('detail_tipo').innerText = doc.tipo_doc ? doc.tipo_doc.nombre : 'N/A';
                document.getElementById('detail_responsable').innerText = doc.responsable ? doc.responsable.nombre_completo : 'N/A';
                document.getElementById('detail_descripcion').innerText = doc.descripcion || 'Sin descripción adicional.';

                // Poblar Versiones
                const verTbody = document.getElementById('detail_versiones_tbody');
                verTbody.innerHTML = '';
                if (doc.versiones && doc.versiones.length > 0) {
                    doc.versiones.forEach(v => {
                        verTbody.innerHTML += `
                            <tr>
                                <td class="fw-bold text-success">V.${v.numero_version}</td>
                                <td>${v.descripcion_cambio || 'Sin descripción'}</td>
                                <td><span class="badge bg-secondary text-uppercase">${v.archivo_formato || 'PDF'}</span></td>
                                <td>${v.archivo_tamano_kb ? v.archivo_tamano_kb + ' KB' : 'N/A'}</td>
                                <td>${v.creado_en ? v.creado_en.substring(0, 10) : '-'}</td>
                                <td><span class="badge ${v.estado === 'vigente' ? 'bg-success' : 'bg-warning text-dark'}">${v.estado}</span></td>
                            </tr>
                        `;
                    });
                } else {
                    verTbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">No hay versiones registradas.</td></tr>';
                }

                // Poblar Bitácora
                const bitTbody = document.getElementById('detail_bitacora_tbody');
                bitTbody.innerHTML = '';
                if (bitacoras && bitacoras.length > 0) {
                    bitacoras.forEach(b => {
                        bitTbody.innerHTML += `
                            <tr>
                                <td>${b.registrado_en ? b.registrado_en.substring(0, 19).replace('T', ' ') : '-'}</td>
                                <td class="fw-semibold text-primary">${b.accion}</td>
                                <td>${b.usuario ? b.usuario.nombre_completo : 'Sistema'}</td>
                                <td>${b.descripcion}</td>
                            </tr>
                        `;
                    });
                } else {
                    bitTbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No hay eventos de trazabilidad registrados.</td></tr>';
                }

                var modal = new bootstrap.Modal(document.getElementById('modalDetailDoc'));
                modal.show();
            }
        })
        .catch(err => {
            console.error('Error cargando detalle del documento:', err);
        });
    }

    /**
     * Confirmación con SweetAlert2 para eliminar un documento
     */
    function confirmDeleteDoc(docId, docCode, docName) {
        Swal.fire({
            title: '¿Eliminar documento?',
            html: `¿Está seguro de eliminar el documento <strong>${docCode}</strong>?<br><span class="text-muted small">${docName}</span><br><br><small class="text-danger">Esta acción eliminará el archivo y sus versiones asociadas.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash3 me-1"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger px-3 me-2',
                cancelButton: 'btn btn-outline-secondary px-3'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-doc-' + docId).submit();
            }
        });
    }

    // Inicialización de Dropzone y Filtros en Modal Create
    document.addEventListener('DOMContentLoaded', function () {
        // Filtrado dinámico de Área según Proceso en el modal
        const modalSelectProceso = document.getElementById('modalSelectProceso');
        const modalSelectArea = document.getElementById('modalSelectArea');

        if (modalSelectProceso && modalSelectArea) {
            const allAreaOpts = Array.from(modalSelectArea.querySelectorAll('option:not([value=""])'));

            modalSelectProceso.addEventListener('change', function () {
                const procId = this.value;
                modalSelectArea.innerHTML = '<option value="">Seleccione un área...</option>';

                allAreaOpts.forEach(opt => {
                    const optProcId = opt.getAttribute('data-proceso-id');
                    if (!procId || optProcId === procId) {
                        modalSelectArea.appendChild(opt.cloneNode(true));
                    }
                });
            });
        }

        // Drag & Drop en Modal Create
        const modalDropzone = document.getElementById('modalDropzoneDoc');
        const modalFileInput = document.getElementById('modalFileDoc');
        const modalIdle = document.getElementById('modalDropzoneIdle');
        const modalSelected = document.getElementById('modalDropzoneSelected');
        const modalPreviewName = document.getElementById('modalPreviewFileName');
        const modalPreviewSize = document.getElementById('modalPreviewFileSize');
        const modalBtnRemove = document.getElementById('modalBtnRemoveFile');

        if (modalDropzone && modalFileInput) {
            modalDropzone.addEventListener('click', function (e) {
                if (e.target !== modalBtnRemove) {
                    modalFileInput.click();
                }
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                modalDropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    modalDropzone.style.borderColor = '#22c55e';
                    modalDropzone.style.backgroundColor = '#f0fdf4';
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                modalDropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    modalDropzone.style.borderColor = '#86efac';
                    modalDropzone.style.backgroundColor = '#f8fafc';
                }, false);
            });

            modalDropzone.addEventListener('drop', function (e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    modalFileInput.files = files;
                    updateModalFilePreview(files[0]);
                }
            });

            modalFileInput.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    updateModalFilePreview(this.files[0]);
                }
            });

            if (modalBtnRemove) {
                modalBtnRemove.addEventListener('click', function (e) {
                    e.stopPropagation();
                    modalFileInput.value = '';
                    modalIdle.classList.remove('d-none');
                    modalIdle.classList.add('d-flex');
                    modalSelected.classList.add('d-none');
                    modalSelected.classList.remove('d-flex');
                    modalFileInput.click();
                });
            }

            function updateModalFilePreview(file) {
                if (!file) return;
                modalPreviewName.textContent = file.name;
                const sizeKb = (file.size / 1024).toFixed(1);
                const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                modalPreviewSize.textContent = file.size > 1024 * 1024 ? `${sizeMb} MB` : `${sizeKb} KB`;

                modalIdle.classList.add('d-none');
                modalIdle.classList.remove('d-flex');
                modalSelected.classList.remove('d-none');
                modalSelected.classList.add('d-flex');
            }
        }
    });
</script>
@endpush
