@extends('sgc::layouts.master')

@section('title', 'SGC • Catálogos Maestros')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & ACTION BUTTONS ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Catálogos Maestros del SGC</h2>
            <p class="text-muted small mb-0">Parametrización y control de Procesos, Áreas del Centro Agroindustrial y Tipos Documentales (Formatos/Tipologías) independientes.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <!-- Botones de Acción Rápida -->
            <button type="button" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;" data-bs-toggle="modal" data-bs-target="#modalCreateProceso">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                <span>+ Nuevo Proceso</span>
            </button>

            <button type="button" class="btn btn-outline-primary rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreateArea">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                <span>+ Nueva Área</span>
            </button>

            <button type="button" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreateTipoDoc">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                <span>+ Nuevo Tipo</span>
            </button>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white d-flex align-items-center gap-3" role="alert">
            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background-color: #ffebee; color: #ef4444;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
            </div>
            <div class="flex-grow-1">
                <strong class="d-block text-dark" style="font-size: 13.5px;">Atención</strong>
                <span class="text-secondary small">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show rounded-4 border shadow-sm p-3 mb-4 bg-white" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#f59e0b" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                </svg>
                <strong class="text-dark" style="font-size: 13.5px;">Se encontraron observaciones en el formulario:</strong>
            </div>
            <ul class="mb-0 text-secondary small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ======= TOP SUMMARY STATS ======= -->
    <div class="mb-4">
        <div class="text-uppercase text-secondary fw-bold mb-3" style="font-size: 11.5px; letter-spacing: 0.6px;">
            Estructura y Catálogos del Sistema de Calidad
        </div>
        <div class="row g-3">
            <!-- Stat 1: Procesos -->
            <div class="col-12 col-md-4">
                <div class="card border rounded-4 bg-white shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: #eaf8ea; color: #39A900;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-diagram-3" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-success" style="font-size: 11.5px; color: #39A900 !important;">PROCESOS SGC</span>
                                <span class="fs-4 fw-bold text-dark lh-1 my-0">{{ $procesos->count() }}</span>
                                <small class="text-muted d-block" style="font-size: 11px;">{{ $procesos->where('activo', 1)->count() }} vigentes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 2: Áreas -->
            <div class="col-12 col-md-4">
                <div class="card border rounded-4 bg-white shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: #ebf5ff; color: #1d4ed8;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                    <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                    <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-primary" style="font-size: 11.5px;">ÁREAS Y DEPENDENCIAS</span>
                                <span class="fs-4 fw-bold text-dark lh-1 my-0">{{ $areas->count() }}</span>
                                <small class="text-muted d-block" style="font-size: 11px;">{{ $areas->where('activo', 1)->count() }} operativas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stat 3: Tipos Documentales -->
            <div class="col-12 col-md-4">
                <div class="card border rounded-4 bg-white shadow-sm p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: #fef3c7; color: #b45309;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                    <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                                    <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="fw-bold d-block" style="font-size: 11.5px; color: #b45309;">TIPOS DOCUMENTALES (FORMATOS)</span>
                                <span class="fs-4 fw-bold text-dark lh-1 my-0">{{ $tiposDocumento->count() }}</span>
                                <small class="text-muted d-block" style="font-size: 11px;">{{ $tiposDocumento->where('activo', 1)->count() }} activos (Transversales)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= TABS NAVIGATION BAR ======= -->
    <div class="card border rounded-4 bg-white shadow-sm p-2 mb-4">
        <ul class="nav nav-pills gap-2" id="catalogosTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-3 px-3 py-2 fw-semibold d-flex align-items-center gap-2" id="tab-procesos-tab" data-bs-toggle="pill" data-bs-target="#tab-procesos" type="button" role="tab" style="font-size: 13.5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-diagram-3" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                    </svg>
                    <span>1. Procesos</span>
                    <span class="badge rounded-2 bg-light text-dark border ms-1">{{ $procesos->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-3 px-3 py-2 fw-semibold d-flex align-items-center gap-2" id="tab-areas-tab" data-bs-toggle="pill" data-bs-target="#tab-areas" type="button" role="tab" style="font-size: 13.5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                        <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                        <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                    </svg>
                    <span>2. Áreas y Dependencias</span>
                    <span class="badge rounded-2 bg-light text-dark border ms-1">{{ $areas->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-3 px-3 py-2 fw-semibold d-flex align-items-center gap-2" id="tab-tipos-tab" data-bs-toggle="pill" data-bs-target="#tab-tipos" type="button" role="tab" style="font-size: 13.5px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                        <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
                        <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                    </svg>
                    <span>3. Tipos Documentales (Formatos)</span>
                    <span class="badge rounded-2 bg-light text-dark border ms-1">{{ $tiposDocumento->count() }}</span>
                </button>
            </li>
        </ul>
    </div>

    <!-- ======= TABS CONTENT ======= -->
    <div class="tab-content" id="catalogosTabsContent">

        <!-- ========================================================= -->
        <!-- PESTAÑA 1: PROCESOS                                       -->
        <!-- ========================================================= -->
        <div class="tab-pane fade show active" id="tab-procesos" role="tabpanel">
            
            <!-- Barra de Búsqueda Procesos -->
            <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </span>
                            <input type="text" id="searchProcesos" class="form-control bg-light border-start-0 ps-0" placeholder="Buscar proceso por código, nombre o alcance...">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3 text-end">
                        <button type="button" class="btn text-white w-100 rounded-3 fw-semibold shadow-sm" style="background-color: #39A900; border: none;" data-bs-toggle="modal" data-bs-target="#modalCreateProceso">
                            + Agregar Proceso
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla de Procesos -->
            <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tableProcesos" style="font-size: 13.5px;">
                        <thead class="table-light">
                            <tr class="text-muted text-uppercase" style="font-size: 12px; letter-spacing: 0.4px;">
                                <th class="border-0 ps-4 py-3" style="width: 140px;">Código</th>
                                <th class="border-0 py-3">Nombre del Proceso</th>
                                <th class="border-0 py-3">Descripción u Objetivo</th>
                                <th class="border-0 py-3 text-center" style="width: 110px;">Áreas</th>
                                <th class="border-0 py-3 text-center" style="width: 120px;">Documentos</th>
                                <th class="border-0 py-3 text-center" style="width: 120px;">Estado</th>
                                <th class="border-0 pe-4 py-3 text-center" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($procesos as $proc)
                                <tr class="proceso-row">
                                    <td class="ps-4 py-3">
                                        <span class="badge rounded-2 px-2 py-1 fw-bold font-monospace" style="background-color: #eaf8ea; color: #2b8000; font-size: 12px;">
                                            {{ $proc->codigo }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-dark d-block">{{ $proc->nombre }}</span>
                                    </td>
                                    <td class="py-3 text-muted small" style="max-width: 320px;">
                                        {{ $proc->descripcion ?? 'Sin descripción' }}
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #ebf5ff; color: #1d4ed8; font-size: 11.5px;">
                                            {{ $proc->areas_count ?? $proc->areas->count() }} áreas
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #f1f5f9; color: #475569; font-size: 11.5px;">
                                            {{ $proc->documentos_count ?? $proc->documentos->count() }} docs
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <form id="form-toggle-proceso-{{ $proc->id }}" action="{{ route('sgc.procesos.toggle-status', $proc->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="form-check form-switch d-inline-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switch-proc-{{ $proc->id }}" 
                                                       {{ $proc->activo ? 'checked' : '' }} 
                                                       style="cursor: pointer; font-size: 16px;" 
                                                       onchange="document.getElementById('form-toggle-proceso-{{ $proc->id }}').submit()">
                                                <span class="small fw-semibold {{ $proc->activo ? 'text-success' : 'text-muted' }}" style="font-size: 12px;">
                                                    {{ $proc->activo ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="pe-4 py-3 text-center">
                                        <div class="d-inline-flex align-items-center justify-content-center gap-2">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-2 d-inline-flex align-items-center justify-content-center" title="Editar Proceso" onclick="openEditProcesoModal({{ json_encode($proc) }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                                </svg>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <form id="form-delete-proc-{{ $proc->id }}" action="{{ route('sgc.procesos.destroy', $proc->id) }}" method="POST" class="d-inline m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-2 d-inline-flex align-items-center justify-content-center" title="Eliminar Proceso" onclick="confirmDeleteStandard('form-delete-proc-{{ $proc->id }}', 'el proceso', '{{ addslashes($proc->nombre) }}')">
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
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        No se encontraron procesos registrados en el SGC.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top px-4 py-3 text-muted small">
                    Mostrando {{ $procesos->count() }} procesos institucionales registrados
                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- PESTAÑA 2: ÁREAS Y DEPENDENCIAS                           -->
        <!-- ========================================================= -->
        <div class="tab-pane fade" id="tab-areas" role="tabpanel">
            
            <!-- Barra de Búsqueda y Filtro de Áreas -->
            <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-5 col-lg-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </span>
                            <input type="text" id="searchAreas" class="form-control bg-light border-start-0 ps-0" placeholder="Buscar área por código o nombre...">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <select id="filterAreaProceso" class="form-select bg-light">
                            <option value="all">Filtrar por Proceso: Todos</option>
                            @foreach($procesos as $pOpt)
                                <option value="{{ $pOpt->id }}">{{ $pOpt->nombre }} ({{ $pOpt->codigo }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 text-end">
                        <button type="button" class="btn btn-primary w-100 rounded-3 fw-semibold shadow-sm" style="background-color: #0284c7; border: none;" data-bs-toggle="modal" data-bs-target="#modalCreateArea">
                            + Agregar Área
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla de Áreas -->
            <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tableAreas" style="font-size: 13.5px;">
                        <thead class="table-light">
                            <tr class="text-muted text-uppercase" style="font-size: 12px; letter-spacing: 0.4px;">
                                <th class="border-0 ps-4 py-3" style="width: 140px;">Código</th>
                                <th class="border-0 py-3">Nombre del Área / Dependencia</th>
                                <th class="border-0 py-3">Proceso Asociado</th>
                                <th class="border-0 py-3 text-center" style="width: 120px;">Documentos</th>
                                <th class="border-0 py-3 text-center" style="width: 120px;">Estado</th>
                                <th class="border-0 pe-4 py-3 text-center" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($areas as $area)
                                <tr class="area-row" data-proceso-id="{{ $area->proceso_id }}">
                                    <td class="ps-4 py-3">
                                        <span class="badge rounded-2 px-2 py-1 fw-bold font-monospace" style="background-color: #ebf5ff; color: #1d4ed8; font-size: 12px;">
                                            {{ $area->codigo }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-dark d-block">{{ $area->nombre }}</span>
                                    </td>
                                    <td class="py-3">
                                        @if($area->proceso)
                                            <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #eaf8ea; color: #2b8000; font-size: 11.5px;">
                                                {{ $area->proceso->nombre }} ({{ $area->proceso->codigo }})
                                            </span>
                                        @else
                                            <span class="text-muted small fst-italic">Sin proceso asignado</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #f1f5f9; color: #475569; font-size: 11.5px;">
                                            {{ $area->documentos_count ?? $area->documentos->count() }} docs
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <form id="form-toggle-area-{{ $area->id }}" action="{{ route('sgc.areas.toggle-status', $area->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="form-check form-switch d-inline-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switch-area-{{ $area->id }}" 
                                                       {{ $area->activo ? 'checked' : '' }} 
                                                       style="cursor: pointer; font-size: 16px;" 
                                                       onchange="document.getElementById('form-toggle-area-{{ $area->id }}').submit()">
                                                <span class="small fw-semibold {{ $area->activo ? 'text-success' : 'text-muted' }}" style="font-size: 12px;">
                                                    {{ $area->activo ? 'Activa' : 'Inactiva' }}
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="pe-4 py-3 text-center">
                                        <div class="d-inline-flex align-items-center justify-content-center gap-2">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-2 d-inline-flex align-items-center justify-content-center" title="Editar Área" onclick="openEditAreaModal({{ json_encode($area) }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                                </svg>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <form id="form-delete-area-{{ $area->id }}" action="{{ route('sgc.areas.destroy', $area->id) }}" method="POST" class="d-inline m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-2 d-inline-flex align-items-center justify-content-center" title="Eliminar Área" onclick="confirmDeleteStandard('form-delete-area-{{ $area->id }}', 'el área', '{{ addslashes($area->nombre) }}')">
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
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No se encontraron áreas registradas en el SGC.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top px-4 py-3 text-muted small">
                    Mostrando {{ $areas->count() }} áreas y dependencias registradas
                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- PESTAÑA 3: TIPOS DOCUMENTALES (FORMATOS / TIPOLOGÍAS)     -->
        <!-- ========================================================= -->
        <div class="tab-pane fade" id="tab-tipos" role="tabpanel">
            
            <!-- Banner Explicativo Informativo de Tipos Documentales -->
            <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background-color: #fef3c7; color: #b45309;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="text-dark d-block" style="font-size: 13.5px;">Catálogo Global e Independiente de Tipologías Documentales</strong>
                            <span class="text-secondary small">
                                Los tipos documentales definen el formato o naturaleza del archivo (Formato, Instructivo, Manual, Procedimiento, Guía). Son transversales y no dependen de un área o proceso específico.
                            </span>
                        </div>
                    </div>

                    <!-- Píldoras de Ejemplos Comunes -->
                    <div class="d-flex flex-wrap gap-1">
                        <span class="badge rounded-2 px-2 py-1" style="background-color: #eaf8ea; color: #2b8000; font-size: 11px;">FO • Formato / Plantilla</span>
                        <span class="badge rounded-2 px-2 py-1" style="background-color: #ebf5ff; color: #1d4ed8; font-size: 11px;">IT • Instructivo</span>
                        <span class="badge rounded-2 px-2 py-1" style="background-color: #fef3c7; color: #b45309; font-size: 11px;">PR • Procedimiento</span>
                        <span class="badge rounded-2 px-2 py-1" style="background-color: #f1f5f9; color: #475569; font-size: 11px;">MN • Manual</span>
                        <span class="badge rounded-2 px-2 py-1" style="background-color: #f3e8ff; color: #7e22ce; font-size: 11px;">GU • Guía</span>
                    </div>
                </div>
            </div>

            <!-- Barra de Búsqueda Tipos Documentales -->
            <div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted ps-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </span>
                            <input type="text" id="searchTipos" class="form-control bg-light border-start-0 ps-0" placeholder="Buscar tipo documental por sigla, nombre o descripción...">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3 text-end">
                        <button type="button" class="btn btn-secondary w-100 rounded-3 fw-semibold shadow-sm" style="background-color: #475569; border: none;" data-bs-toggle="modal" data-bs-target="#modalCreateTipoDoc">
                            + Agregar Tipo Documental
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabla de Tipos Documentales -->
            <div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tableTipos" style="font-size: 13.5px;">
                        <thead class="table-light">
                            <tr class="text-muted text-uppercase" style="font-size: 12px; letter-spacing: 0.4px;">
                                <th class="border-0 ps-4 py-3" style="width: 140px;">Sigla / Código</th>
                                <th class="border-0 py-3">Nombre del Tipo Documental</th>
                                <th class="border-0 py-3">Descripción / Criterio de Aplicación</th>
                                <th class="border-0 py-3 text-center" style="width: 120px;">Documentos</th>
                                <th class="border-0 py-3 text-center" style="width: 120px;">Estado</th>
                                <th class="border-0 pe-4 py-3 text-center" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tiposDocumento as $tipo)
                                <tr class="tipo-row">
                                    <td class="ps-4 py-3">
                                        <span class="badge rounded-2 px-2 py-1 fw-bold font-monospace" style="background-color: #fef3c7; color: #b45309; font-size: 12px;">
                                            {{ $tipo->codigo }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-dark d-block">{{ $tipo->nombre }}</span>
                                    </td>
                                    <td class="py-3 text-muted small" style="max-width: 320px;">
                                        {{ $tipo->descripcion ?? 'Sin descripción' }}
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #f1f5f9; color: #475569; font-size: 11.5px;">
                                            {{ $tipo->documentos_count ?? $tipo->documentos->count() }} docs
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <form id="form-toggle-tipo-{{ $tipo->id }}" action="{{ route('sgc.tipos-documento.toggle-status', $tipo->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <div class="form-check form-switch d-inline-flex align-items-center gap-2 m-0">
                                                <input class="form-check-input" type="checkbox" role="switch" id="switch-tipo-{{ $tipo->id }}" 
                                                       {{ $tipo->activo ? 'checked' : '' }} 
                                                       style="cursor: pointer; font-size: 16px;" 
                                                       onchange="document.getElementById('form-toggle-tipo-{{ $tipo->id }}').submit()">
                                                <span class="small fw-semibold {{ $tipo->activo ? 'text-success' : 'text-muted' }}" style="font-size: 12px;">
                                                    {{ $tipo->activo ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="pe-4 py-3 text-center">
                                        <div class="d-inline-flex align-items-center justify-content-center gap-2">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-2 d-inline-flex align-items-center justify-content-center" title="Editar Tipo Documental" onclick="openEditTipoDocModal({{ json_encode($tipo) }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                                </svg>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <form id="form-delete-tipo-{{ $tipo->id }}" action="{{ route('sgc.tipos-documento.destroy', $tipo->id) }}" method="POST" class="d-inline m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-2 d-inline-flex align-items-center justify-content-center" title="Eliminar Tipo Documental" onclick="confirmDeleteStandard('form-delete-tipo-{{ $tipo->id }}', 'el tipo documental', '{{ addslashes($tipo->nombre) }}')">
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
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No se encontraron tipos documentales registrados en el SGC.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top px-4 py-3 text-muted small">
                    Mostrando {{ $tiposDocumento->count() }} tipos documentales (formatos) registrados
                </div>
            </div>
        </div>

    </div>

</div>

<!-- ========================================================================= -->
<!-- MODALES ESTANDARIZADOS: PROCESOS                                          -->
<!-- ========================================================================= -->

<!-- Modal Crear Proceso -->
<div class="modal fade" id="modalCreateProceso" tabindex="-1" aria-labelledby="modalCreateProcesoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 bg-white border text-success shadow-sm d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-diagram-3" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalCreateProcesoLabel">Registrar Nuevo Proceso</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Sistema de Gestión de Calidad (SGC) • SENA Empresa</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sgc.procesos.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="text-uppercase text-secondary fw-bold" style="font-size: 11.5px; letter-spacing: 0.5px;">1. Identificación del Proceso</span>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Código del Proceso <span class="text-danger">*</span></label>
                            <input type="text" name="codigo" class="form-control text-uppercase font-monospace" placeholder="Ej: PR-PEC, PR-AGR, PR-CAL" maxlength="20" required>
                            <div class="form-text text-muted" style="font-size: 11px;">Identificador único del proceso.</div>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre del Proceso <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Producción Pecuaria, Gestión de Calidad" maxlength="100" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Descripción u Objetivo del Proceso</label>
                            <textarea name="descripcion" class="form-control" rows="3" placeholder="Propósito, alcance e impacto del proceso en el Centro de Formación..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted"><span class="text-danger">*</span> Campos obligatorios</small>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success px-4 text-white" style="background-color: #39A900; border-color: #39A900;">Guardar Proceso</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Proceso -->
<div class="modal fade" id="modalEditProceso" tabindex="-1" aria-labelledby="modalEditProcesoLabel" aria-hidden="true">
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
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalEditProcesoLabel">Modificar Datos del Proceso</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Actualización de información en el SGC</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditProceso" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Código <span class="text-danger">*</span></label>
                            <input type="text" id="edit_proceso_codigo" name="codigo" class="form-control text-uppercase font-monospace" maxlength="20" required>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre del Proceso <span class="text-danger">*</span></label>
                            <input type="text" id="edit_proceso_nombre" name="nombre" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Descripción</label>
                            <textarea id="edit_proceso_descripcion" name="descripcion" class="form-control" rows="3"></textarea>
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

<!-- ========================================================================= -->
<!-- MODALES ESTANDARIZADOS: ÁREAS                                             -->
<!-- ========================================================================= -->

<!-- Modal Crear Área -->
<div class="modal fade" id="modalCreateArea" tabindex="-1" aria-labelledby="modalCreateAreaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 bg-white border text-primary shadow-sm d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                            <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalCreateAreaLabel">Registrar Nueva Área o Dependencia</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Sistema de Gestión de Calidad (SGC) • SENA Empresa</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sgc.areas.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="text-uppercase text-secondary fw-bold" style="font-size: 11.5px; letter-spacing: 0.5px;">1. Datos de la Dependencia</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Código del Área <span class="text-danger">*</span></label>
                            <input type="text" name="codigo" class="form-control text-uppercase font-monospace" placeholder="Ej: ORD, LAC, POR, SIS" maxlength="20" required>
                            <div class="form-text text-muted" style="font-size: 11px;">Sigla identificadora del área.</div>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre del Área <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Unidad de Ordeño Mecánico, Planta de Lácteos" maxlength="100" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Proceso al que Pertenece <span class="text-danger">*</span></label>
                            <select name="proceso_id" class="form-select" required>
                                <option value="">Seleccione el macroproceso correspondiente...</option>
                                @foreach($procesos as $pOpt)
                                    <option value="{{ $pOpt->id }}">{{ $pOpt->nombre }} ({{ $pOpt->codigo }})</option>
                                @endforeach
                            </select>
                            <div class="form-text text-muted" style="font-size: 11px;">El área quedará adscrita bajo la estructura de este proceso.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted"><span class="text-danger">*</span> Campos obligatorios</small>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4 text-white" style="background-color: #0284c7; border-color: #0284c7;">Guardar Área</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Área -->
<div class="modal fade" id="modalEditArea" tabindex="-1" aria-labelledby="modalEditAreaLabel" aria-hidden="true">
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
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalEditAreaLabel">Modificar Datos del Área</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Actualización de dependencia en el SGC</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditArea" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Código <span class="text-danger">*</span></label>
                            <input type="text" id="edit_area_codigo" name="codigo" class="form-control text-uppercase font-monospace" maxlength="20" required>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre del Área <span class="text-danger">*</span></label>
                            <input type="text" id="edit_area_nombre" name="nombre" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Proceso al que Pertenece <span class="text-danger">*</span></label>
                            <select id="edit_area_proceso_id" name="proceso_id" class="form-select" required>
                                @foreach($procesos as $pOpt)
                                    <option value="{{ $pOpt->id }}">{{ $pOpt->nombre }} ({{ $pOpt->codigo }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted"><span class="text-danger">*</span> Campos obligatorios</small>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4 text-white" style="background-color: #0284c7; border-color: #0284c7;">Actualizar Cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODALES ESTANDARIZADOS: TIPOS DOCUMENTALES (FORMATOS / TIPOLOGÍAS)        -->
<!-- ========================================================================= -->

<!-- Modal Crear Tipo Documental -->
<div class="modal fade" id="modalCreateTipoDoc" tabindex="-1" aria-labelledby="modalCreateTipoDocLabel" aria-hidden="true">
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
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalCreateTipoDocLabel">Registrar Nuevo Tipo Documental (Formato)</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Sistema de Gestión de Calidad (SGC) • SENA Empresa</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sgc.tipos-documento.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    
                    <!-- Callout Explicativo en Modal -->
                    <div class="alert alert-light border rounded-3 p-3 mb-3 d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#475569" class="bi bi-info-circle flex-shrink-0" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                        <div class="small text-secondary">
                            <strong>Nota:</strong> Los tipos documentales clasifican el tipo de formato/archivo oficial (ej: Formato, Instructivo, Manual, Procedimiento). Son independientes de procesos y áreas.
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Sigla / Código <span class="text-danger">*</span></label>
                            <input type="text" name="codigo" class="form-control text-uppercase font-monospace" placeholder="Ej: FO, IT, PR, MN, GU" maxlength="20" required>
                            <div class="form-text text-muted" style="font-size: 11.5px;">Abreviatura empleada en la codificación institucional.</div>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre del Tipo Documental <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Formato / Plantilla de Registro, Instructivo Técnico" maxlength="80" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Descripción / Criterio de Uso</label>
                            <textarea name="descripcion" class="form-control" rows="3" placeholder="Pautas, definición y criterios para cuando se deba crear un documento de este tipo..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted"><span class="text-danger">*</span> Campos obligatorios</small>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-secondary px-4 text-white" style="background-color: #475569; border-color: #475569;">Guardar Tipo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Tipo Documental -->
<div class="modal fade" id="modalEditTipoDoc" tabindex="-1" aria-labelledby="modalEditTipoDocLabel" aria-hidden="true">
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
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalEditTipoDocLabel">Modificar Tipo Documental (Formato)</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Actualización de tipología en el SGC</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditTipoDoc" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-semibold text-dark mb-1">Sigla / Código <span class="text-danger">*</span></label>
                            <input type="text" id="edit_tipo_codigo" name="codigo" class="form-control text-uppercase font-monospace" maxlength="20" required>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre del Tipo Documental <span class="text-danger">*</span></label>
                            <input type="text" id="edit_tipo_nombre" name="nombre" class="form-control" maxlength="80" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Descripción / Criterio de Uso</label>
                            <textarea id="edit_tipo_descripcion" name="descripcion" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted"><span class="text-danger">*</span> Campos obligatorios</small>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-secondary px-4 text-white" style="background-color: #475569; border-color: #475569;">Actualizar Cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Restaurar y persistir pestaña activa mediante hash en la URL
        const hash = window.location.hash;
        if (hash) {
            const targetTab = document.querySelector(`button[data-bs-target="${hash}"]`);
            if (targetTab) {
                new bootstrap.Tab(targetTab).show();
            }
        }

        document.querySelectorAll('#catalogosTabs button').forEach(button => {
            button.addEventListener('shown.bs.tab', function (e) {
                const targetId = e.target.getAttribute('data-bs-target');
                window.location.hash = targetId;
            });
        });

        // 2. Búsqueda en vivo de Procesos
        const searchProcesos = document.getElementById('searchProcesos');
        if (searchProcesos) {
            searchProcesos.addEventListener('keyup', function () {
                const query = this.value.toLowerCase().trim();
                document.querySelectorAll('.proceso-row').forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }

        // 3. Búsqueda en vivo y filtro de Áreas
        const searchAreas = document.getElementById('searchAreas');
        const filterAreaProceso = document.getElementById('filterAreaProceso');

        function filterAreas() {
            const query = searchAreas.value.toLowerCase().trim();
            const selectedProc = filterAreaProceso.value;

            document.querySelectorAll('.area-row').forEach(row => {
                const text = row.innerText.toLowerCase();
                const procId = row.getAttribute('data-proceso-id');

                const matchesText = text.includes(query);
                const matchesProc = (selectedProc === 'all' || procId === selectedProc);

                row.style.display = (matchesText && matchesProc) ? '' : 'none';
            });
        }

        if (searchAreas) searchAreas.addEventListener('keyup', filterAreas);
        if (filterAreaProceso) filterAreaProceso.addEventListener('change', filterAreas);

        // 4. Búsqueda en vivo de Tipos Documentales
        const searchTipos = document.getElementById('searchTipos');
        if (searchTipos) {
            searchTipos.addEventListener('keyup', function () {
                const query = this.value.toLowerCase().trim();
                document.querySelectorAll('.tipo-row').forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }
    });

    // Abrir Modal Editar Proceso
    function openEditProcesoModal(proceso) {
        document.getElementById('formEditProceso').action = '/sgc/procesos/' + proceso.id;
        document.getElementById('edit_proceso_codigo').value = proceso.codigo || '';
        document.getElementById('edit_proceso_nombre').value = proceso.nombre || '';
        document.getElementById('edit_proceso_descripcion').value = proceso.descripcion || '';
        new bootstrap.Modal(document.getElementById('modalEditProceso')).show();
    }

    // Abrir Modal Editar Área
    function openEditAreaModal(area) {
        document.getElementById('formEditArea').action = '/sgc/areas/' + area.id;
        document.getElementById('edit_area_codigo').value = area.codigo || '';
        document.getElementById('edit_area_nombre').value = area.nombre || '';
        document.getElementById('edit_area_proceso_id').value = area.proceso_id || '';
        new bootstrap.Modal(document.getElementById('modalEditArea')).show();
    }

    // Abrir Modal Editar Tipo Documental
    function openEditTipoDocModal(tipo) {
        document.getElementById('formEditTipoDoc').action = '/sgc/tipos-documento/' + tipo.id;
        document.getElementById('edit_tipo_codigo').value = tipo.codigo || '';
        document.getElementById('edit_tipo_nombre').value = tipo.nombre || '';
        document.getElementById('edit_tipo_descripcion').value = tipo.descripcion || '';
        new bootstrap.Modal(document.getElementById('modalEditTipoDoc')).show();
    }

    // Confirmación estándar SweetAlert2 idéntica al resto del SGC
    function confirmDeleteStandard(formId, entityText, name) {
        Swal.fire({
            title: '¿Eliminar ' + entityText + '?',
            html: `¿Está seguro de eliminar ${entityText} <strong>"${name}"</strong>?<br><br><small class="text-danger">Esta acción eliminará el registro de forma permanente si no cuenta con dependencias vinculadas.</small>`,
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
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush
