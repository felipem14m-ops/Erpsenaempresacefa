@extends('sgc::layouts.master')

@section('title', 'SGC • Repositorio Documental Consultante')

@section('content')
<!-- Welcome Title & Search Bar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Bienvenido al Repositorio SGC</h2>
        <p class="text-muted small mb-0">Consulta y descarga directa de documentación y formatos institucionales autorizados.</p>
    </div>

    <div style="min-width: 320px;">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" placeholder="Buscar procedimiento, formato o código...">
        </div>
    </div>
</div>

<!-- 4 Stat Cards Grid -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('sgc.documentos.index') }}" class="text-decoration-none d-block h-100">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100" style="transition: transform 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                        <i class="fas fa-file-circle-check fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Documentos Vigentes</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">47</div>
                        <small class="text-muted" style="font-size: 11.5px;">100% autorizados</small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('sgc.documentos.index') }}?tipo_doc_id=ma" class="text-decoration-none d-block h-100">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100" style="transition: transform 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #ebf5ff; color: #3b82f6;">
                        <i class="fas fa-book fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Manuales</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">14</div>
                        <small class="text-muted" style="font-size: 11.5px;">Guías técnicas</small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('sgc.documentos.index') }}?tipo_doc_id=fo" class="text-decoration-none d-block h-100">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100" style="transition: transform 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #fef9e7; color: #eab308;">
                        <i class="fas fa-file-excel fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Formatos</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">25</div>
                        <small class="text-muted" style="font-size: 11.5px;">Plantillas en blanco</small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f3e8ff; color: #9333ea;">
                    <i class="fas fa-robot fs-5"></i>
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Asistente IA</div>
                    <div class="fs-3 fw-bold text-dark lh-1 my-1">Activo</div>
                    <small class="text-muted" style="font-size: 11.5px;">Resúmenes ejecutivos</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Listado Maestro de Documentos Vigentes -->
<div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark mb-0 fs-6">Listado Maestro de Documentos Vigentes</h5>
        <span class="badge bg-success bg-opacity-10 text-success fw-bold px-2 py-1" style="color: #2b8000 !important;">Versiones Vigentes</span>
    </div>

    <div class="table-responsive p-2">
        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
            <thead class="table-light">
                <tr class="text-muted text-uppercase" style="font-size: 12px;">
                    <th class="border-0 ps-3 py-3">Código</th>
                    <th class="border-0 py-3">Título del Documento</th>
                    <th class="border-0 py-3">Tipo</th>
                    <th class="border-0 py-3">Versión</th>
                    <th class="border-0 py-3">Fecha de Aprobación</th>
                    <th class="border-0 text-end pe-3 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ps-3 fw-bold text-dark">PR-CA-001</td>
                    <td><span class="fw-semibold">Procedimiento de Control Documental</span></td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Procedimiento</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success fw-bold">V2</span></td>
                    <td class="text-muted">15/08/2026</td>
                    <td class="text-end pe-3">
                        <button class="btn btn-sm btn-outline-success rounded-2 px-2 py-1" title="Descargar PDF"><i class="fas fa-file-pdf"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="ps-3 fw-bold text-dark">MA-GH-002</td>
                    <td><span class="fw-semibold">Manual de Inducción y Reinducción</span></td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Manual</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success fw-bold">V1</span></td>
                    <td class="text-muted">10/01/2026</td>
                    <td class="text-end pe-3">
                        <button class="btn btn-sm btn-outline-success rounded-2 px-2 py-1" title="Descargar PDF"><i class="fas fa-file-pdf"></i></button>
                    </td>
                </tr>
                <tr>
                    <td class="ps-3 fw-bold text-dark">FT-AG-012</td>
                    <td><span class="fw-semibold">Formato de Registro de Riego por Goteo</span></td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Formato</span></td>
                    <td><span class="badge bg-success bg-opacity-10 text-success fw-bold">V3</span></td>
                    <td class="text-muted">20/07/2026</td>
                    <td class="text-end pe-3">
                        <button class="btn btn-sm btn-outline-success rounded-2 px-2 py-1" title="Descargar Excel"><i class="fas fa-file-excel"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
