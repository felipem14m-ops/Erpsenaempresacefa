@extends('sgc::layouts.master')

@section('title', 'SGC • Dashboard Líder de Área')

@section('content')
<!-- Header Title & Action Button -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Bienvenido, {{ Auth::user()->full_name ?? 'Líder de Área' }}</h2>
        <p class="text-muted small mb-0">Radica y gestiona los procedimientos, manuales y formatos de tu unidad de formación.</p>
    </div>

    <div>
        <a href="{{ route('sgc.lider_area.solicitudes.index') }}?abrir_modal=1" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;">
            <i class="fas fa-plus-circle"></i>
            <span>Radicar Nueva Solicitud</span>
        </a>
    </div>
</div>

<!-- 4 Stat Cards Grid -->
<div class="row g-3 mb-4">
    <!-- Stat 1: Documentos de mi Área -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('sgc.documentos.index') }}" class="text-decoration-none d-block h-100">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100" style="transition: transform 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                        <i class="fas fa-folder-closed fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Documentos de mi Área</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">18</div>
                        <small class="text-muted" style="font-size: 11.5px;">Procedimientos vigentes</small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Stat 2: Solicitudes en Trámite -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('sgc.lider_area.solicitudes.index') }}" class="text-decoration-none d-block h-100">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100" style="transition: transform 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #fef9e7; color: #eab308;">
                        <i class="fas fa-paper-plane fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Solicitudes en Trámite</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">4</div>
                        <small class="text-muted" style="font-size: 11.5px;">En revisión por Calidad</small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Stat 3: Formatos Oficiales -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('sgc.documentos.index') }}?tipo_doc_id=fo" class="text-decoration-none d-block h-100">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100" style="transition: transform 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #ebf5ff; color: #3b82f6;">
                        <i class="fas fa-file-excel fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Formatos Oficiales</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">24</div>
                        <small class="text-muted" style="font-size: 11.5px;">Plantillas descargables</small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Stat 4: Solicitudes Aprobadas -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f3e8ff; color: #9333ea;">
                    <i class="fas fa-circle-check fs-5"></i>
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Solicitudes Aprobadas</div>
                    <div class="fs-3 fw-bold text-dark lh-1 my-1">14</div>
                    <small class="text-muted" style="font-size: 11.5px;">Histórico total</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom 2-Column Section -->
<div class="row g-4">
    <!-- Left Column: Solicitudes Radicadas Recientes -->
    <div class="col-12 col-lg-8">
        <div class="card border rounded-4 bg-white shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0 fs-6">Mis Solicitudes Radicadas</h5>
                <a href="{{ route('sgc.lider_area.solicitudes.index') }}" class="text-decoration-none fw-semibold small" style="color: #39A900;">
                    Ver historial <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="table-responsive p-2">
                <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                    <thead class="table-light">
                        <tr class="text-muted text-uppercase" style="font-size: 12px;">
                            <th class="border-0 ps-3 py-3">Radicado</th>
                            <th class="border-0 py-3">Tipo</th>
                            <th class="border-0 py-3">Documento</th>
                            <th class="border-0 pe-3 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-3 fw-bold text-dark">SOL-042</td>
                            <td class="text-secondary small">Creación</td>
                            <td>Procedimiento de Manejo de Residuos Pecuarios</td>
                            <td class="pe-3"><span class="badge rounded-2 px-2 py-1" style="background-color: #f1f5f9; color: #475569;">Radicada</span></td>
                        </tr>
                        <tr>
                            <td class="ps-3 fw-bold text-dark">SOL-039</td>
                            <td class="text-secondary small">Creación</td>
                            <td>Manual de Laboratorio de Suelos</td>
                            <td class="pe-3"><span class="badge rounded-2 px-2 py-1" style="background-color: #fef3c7; color: #b45309;">En revisión</span></td>
                        </tr>
                        <tr>
                            <td class="ps-3 fw-bold text-dark">SOL-035</td>
                            <td class="text-secondary small">Modificación</td>
                            <td>Formato de Asistencia Técnica Agropecuaria</td>
                            <td class="pe-3"><span class="badge rounded-2 px-2 py-1" style="background-color: #def7ec; color: #03543f;">Aprobada (V2)</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Novedades de mi Área -->
    <div class="col-12 col-lg-4">
        <div class="card border rounded-4 bg-white shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0 fs-6">Novedades de mi Área</h5>
                <i class="fas fa-bell text-muted"></i>
            </div>
            <div class="card-body p-4 pt-2 d-flex flex-column gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                    <div>
                        <p class="mb-0 text-dark small"><strong>Calidad aprobó:</strong> SOL-035 quedó publicada como vigente.</p>
                        <small class="text-muted" style="font-size: 11.5px;">Ayer, 4:30 PM</small>
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);"></div>
                    <div>
                        <p class="mb-0 text-dark small"><strong>Radicado exitoso:</strong> Se generó código SOL-042 para revisión.</p>
                        <small class="text-muted" style="font-size: 11.5px;">Hoy, 9:15 AM</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
