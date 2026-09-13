@extends('sgc::layouts.master')

@section('title', 'SGC • Dashboard Administrador')

@section('content')
<!-- Header Title & Action Button -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Bienvenido, {{ Auth::user()->full_name ?? 'Administrador' }}</h2>
        <p class="text-muted small mb-0">Panel principal de control del Sistema de Gestión de Calidad de la Angostura.</p>
    </div>

    <div>
        <a href="javascript:void(0)" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;">
            <i class="fas fa-plus-circle"></i>
            <span>Nueva Solicitud</span>
        </a>
    </div>
</div>

<!-- 4 Metrics Stat Cards Grid -->
<div class="row g-3 mb-4">
    <!-- Stat 1: Documentos Vigentes -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #39A900;">
                    <i class="fas fa-list-check fs-5"></i>
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Documentos Vigentes</div>
                    <div class="fs-3 fw-bold text-dark lh-1 my-1">47</div>
                    <small class="text-muted" style="font-size: 11.5px;">Listado maestro activo</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2: Solicitudes Pendientes -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #fef9e7; color: #eab308;">
                    <i class="fas fa-file-lines fs-5"></i>
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Solicitudes Pendientes</div>
                    <div class="fs-3 fw-bold text-dark lh-1 my-1">12</div>
                    <small class="text-muted" style="font-size: 11.5px;">Requieren revisión</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3: Usuarios Activos (Link to Users index) -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="{{ route('sgc.usuarios.index') }}" class="text-decoration-none d-block h-100">
            <div class="card border rounded-4 p-3 bg-white shadow-sm h-100" style="transition: transform 0.2s ease;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #ebf5ff; color: #3b82f6;">
                        <i class="fas fa-users fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Usuarios Activos</div>
                        <div class="fs-3 fw-bold text-dark lh-1 my-1">{{ \App\Models\User::count() > 0 ? \App\Models\User::count() : '35' }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Funcionarios registrados</small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Stat 4: Docs Próximos a Vencer -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border rounded-4 p-3 bg-white shadow-sm h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #ffebee; color: #ef4444;">
                    <i class="fas fa-triangle-exclamation fs-5"></i>
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Docs Próximos a Vencer</div>
                    <div class="fs-3 fw-bold text-dark lh-1 my-1">5</div>
                    <small class="text-muted" style="font-size: 11.5px;">Revisión en 30 días</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom 2-Column Section -->
<div class="row g-4">
    <!-- Left Column: Solicitudes Recientes (Table) -->
    <div class="col-12 col-lg-8">
        <div class="card border rounded-4 bg-white shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0 fs-6">Solicitudes Recientes</h5>
                <a href="javascript:void(0)" class="text-decoration-none fw-semibold small" style="color: #39A900;">
                    Ver todas <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-responsive p-2">
                <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                    <thead class="table-light">
                        <tr class="text-muted text-uppercase" style="font-size: 12px;">
                            <th class="border-0 ps-3 py-3">Número</th>
                            <th class="border-0 py-3">Tipo</th>
                            <th class="border-0 py-3">Solicitante</th>
                            <th class="border-0 pe-3 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-3 fw-bold text-dark">SOL-042</td>
                            <td class="text-secondary small">Creación</td>
                            <td class="text-dark">Ing. Amanda Ortiz</td>
                            <td class="pe-3">
                                <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #f1f5f9; color: #475569;">Radicada</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-3 fw-bold text-dark">SOL-041</td>
                            <td class="text-secondary small">Modificación</td>
                            <td class="text-dark">Dr. Hector Gomez</td>
                            <td class="pe-3">
                                <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #fef3c7; color: #b45309;">En revisión</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-3 fw-bold text-dark">SOL-040</td>
                            <td class="text-secondary small">Eliminación</td>
                            <td class="text-dark">Laura Beltran</td>
                            <td class="pe-3">
                                <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #def7ec; color: #03543f;">Aprobada</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-3 fw-bold text-dark">SOL-039</td>
                            <td class="text-secondary small">Creación</td>
                            <td class="text-dark">Ing. Amanda Ortiz</td>
                            <td class="pe-3">
                                <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #fef3c7; color: #b45309;">En revisión</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-3 fw-bold text-dark">SOL-038</td>
                            <td class="text-secondary small">Modificación</td>
                            <td class="text-dark">Roberto Diaz</td>
                            <td class="pe-3">
                                <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: #def7ec; color: #03543f;">Aprobada</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Actividad Reciente (Bitácora) -->
    <div class="col-12 col-lg-4">
        <div class="card border rounded-4 bg-white shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0 fs-6">Actividad Reciente (Bitácora)</h5>
                <i class="fas fa-chart-simple text-muted"></i>
            </div>

            <div class="card-body p-4 pt-2 d-flex flex-column gap-3">
                <!-- Activity 1 -->
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                    <div>
                        <p class="mb-0 text-dark small" style="line-height: 1.4;">
                            <strong>Carlos Ruiz (Admin)</strong> Aprobó solicitud <strong>SOL-040</strong>
                        </p>
                        <small class="text-muted" style="font-size: 11.5px;">Hace 5 min</small>
                    </div>
                </div>

                <!-- Activity 2 -->
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                    <div>
                        <p class="mb-0 text-dark small" style="line-height: 1.4;">
                            <strong>Sandra Perdomo</strong> Subió nueva versión de <strong>PR-CA-001 (V2)</strong>
                        </p>
                        <small class="text-muted" style="font-size: 11.5px;">Hace 23 min</small>
                    </div>
                </div>

                <!-- Activity 3 -->
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                    <div>
                        <p class="mb-0 text-dark small" style="line-height: 1.4;">
                            <strong>Hector Gomez</strong> Creó solicitud de modificación <strong>SOL-041</strong>
                        </p>
                        <small class="text-muted" style="font-size: 11.5px;">Hace 1 hora</small>
                    </div>
                </div>

                <!-- Activity 4 -->
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                    <div>
                        <p class="mb-0 text-dark small" style="line-height: 1.4;">
                            <strong>Laura Beltran</strong> Asignó responsable a <strong>FT-AG-012</strong>
                        </p>
                        <small class="text-muted" style="font-size: 11.5px;">Hace 3 horas</small>
                    </div>
                </div>

                <!-- Activity 5 -->
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle mt-1 flex-shrink-0" style="width: 10px; height: 10px; background-color: #39A900; box-shadow: 0 0 0 3px rgba(57, 169, 0, 0.2);"></div>
                    <div>
                        <p class="mb-0 text-dark small" style="line-height: 1.4;">
                            <strong>Sistema SGC</strong> Envió alerta de vencimiento para <strong>MA-GH-002</strong>
                        </p>
                        <small class="text-muted" style="font-size: 11.5px;">Hoy, 08:00 AM</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
