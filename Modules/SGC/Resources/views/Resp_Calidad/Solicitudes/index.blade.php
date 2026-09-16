@extends('sgc::layouts.master')

@section('title', 'SGC • Gestión de Solicitudes Documentales')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= PAGE HEADER ======= -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
            Gestión de Solicitudes Documentales
        </h2>
        <p class="text-muted small mb-0" style="font-size: 13.5px;">
            Administre y controle el ciclo de aprobación de formatos, guías y procedimientos.
        </p>
    </div>

    <!-- ======= FLASH MESSAGES ======= -->
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

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #fef9e7; color: #d97706;">
                <i class="fas fa-circle-exclamation fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Notificación de Dictamen</strong>
                <span class="text-secondary small">{{ session('warning') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ======= SEARCH AND FILTER BAR ======= -->
    <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
        <form method="GET" action="{{ route('sgc.solicitudes.index') }}" class="row g-2 align-items-center">
            
            <!-- Search Bar -->
            <div class="col-12 col-md-8 col-lg-9">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted ps-3" style="border-color: #e2e8f0;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           class="form-control bg-light border-start-0 ps-2" 
                           placeholder="Buscar solicitudes por número, solicitante, justificación o tema..." 
                           style="font-size: 13.5px; border-color: #e2e8f0;">
                </div>
            </div>

            <!-- State Filter Dropdown -->
            <div class="col-12 col-md-4 col-lg-3">
                <select name="estado" class="form-select bg-light" onchange="this.form.submit()" style="font-size: 13.5px;">
                    <option value="all" {{ request('estado') == 'all' || !request('estado') ? 'selected' : '' }}>Filtrar por Estado: Todos</option>
                    <option value="radicada" {{ request('estado') == 'radicada' ? 'selected' : '' }}>Radicada</option>
                    <option value="en_revision" {{ request('estado') == 'en_revision' ? 'selected' : '' }}>En revisión</option>
                    <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                    <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                </select>
            </div>

        </form>
    </div>

    <!-- ======= SOLICITUDES TABLE CONTAINER ======= -->
    <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead class="table-light">
                    <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.5px;">
                        <th class="border-0 ps-4 py-3">Número</th>
                        <th class="border-0 py-3">Tipo</th>
                        <th class="border-0 py-3">Solicitante</th>
                        <th class="border-0 py-3">Área</th>
                        <th class="border-0 py-3">Fecha Radicación</th>
                        <th class="border-0 py-3">Estado</th>
                        <th class="border-0 pe-4 py-3 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $sol)
                        <tr>
                            <!-- 1. Número -->
                            <td class="ps-4 py-3">
                                <a href="{{ route('sgc.solicitudes.evaluar', $sol->id) }}" class="fw-bold text-decoration-none font-monospace" style="color: #39A900; font-size: 13.5px;">
                                    {{ $sol->numero }}
                                </a>
                            </td>

                            <!-- 2. Tipo -->
                            <td class="py-3 text-secondary text-capitalize">
                                {{ $sol->tipo }}
                            </td>

                            <!-- 3. Solicitante -->
                            <td class="py-3 text-dark fw-medium">
                                {{ $sol->solicitante->nombre_completo ?? ($sol->solicitante->nombre_usuario ?? 'Líder de Área') }}
                            </td>

                            <!-- 4. Área -->
                            <td class="py-3 text-secondary">
                                {{ $sol->area->nombre ?? ($sol->documento->area->nombre ?? 'General') }}
                            </td>

                            <!-- 5. Fecha Radicación -->
                            <td class="py-3 text-secondary">
                                {{ $sol->fecha_radicacion ? $sol->fecha_radicacion->translatedFormat('d-M-Y') : ($sol->creado_en ? $sol->creado_en->translatedFormat('d-M-Y') : 'Hoy') }}
                            </td>

                            <!-- 6. Estado -->
                            <td class="py-3">
                                @if($sol->estado === 'radicada')
                                    <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #fef3c7; color: #b45309; font-size: 11.5px;">
                                        Radicada
                                    </span>
                                @elseif($sol->estado === 'en_revision')
                                    <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #ebf5ff; color: #1d4ed8; font-size: 11.5px;">
                                        En revisión
                                    </span>
                                @elseif($sol->estado === 'aprobada')
                                    <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #eaf8ea; color: #2b8000; font-size: 11.5px;">
                                        Aprobada
                                    </span>
                                @elseif(in_array($sol->estado, ['rechazada', 'devuelta', 'cancelada']))
                                    <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #ffebee; color: #dc2626; font-size: 11.5px;">
                                        Rechazada
                                    </span>
                                @else
                                    <span class="badge rounded-2 px-2 py-1 bg-light text-secondary border fw-semibold" style="font-size: 11.5px;">
                                        {{ ucfirst($sol->estado) }}
                                    </span>
                                @endif
                            </td>

                            <!-- 7. Acciones -->
                            <td class="pe-4 py-3 text-end">
                                <a href="{{ route('sgc.solicitudes.evaluar', $sol->id) }}" class="btn btn-sm btn-outline-success rounded-2 px-2.5 py-1 d-inline-flex align-items-center gap-1.5" title="Evaluar y Dictaminar Solicitud">
                                    <i class="fas fa-clipboard-check"></i>
                                    <span>Evaluar</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <i class="fas fa-file-circle-xmark fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                    <h6 class="fw-bold text-dark mb-1">No se encontraron solicitudes</h6>
                                    <p class="text-secondary small mb-0">No hay trámites documentales que coincidan con los filtros seleccionados.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card Footer with Pagination -->
        <div class="card-footer bg-white border-top px-4 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="text-muted small">
                Mostrando {{ $solicitudes->firstItem() ?? 0 }}-{{ $solicitudes->lastItem() ?? 0 }} de {{ $solicitudes->total() }} solicitudes documentales
            </div>
            <div>
                {{ $solicitudes->links('sgc::layouts.partials.pagination') }}
            </div>
        </div>
    </div>

</div>
@endsection
