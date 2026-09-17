@extends('sgc::layouts.master')

@section('title', 'SGC • Gestión de Roles y Permisos')

@section('content')
<div class="container-fluid px-0">

    <!-- ======= HEADER TITLE & ACTION BUTTONS ======= -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">
                Roles y Permisos del SGC
            </h2>
            <p class="text-muted small mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Control de privilegios y matriz de acceso institucional para el Sistema de Gestión de Calidad.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Botón Ver Usuarios por Rol -->
            <a href="{{ route('sgc.roles-permisos.usuarios') }}" 
               class="btn btn-outline-secondary bg-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-xs" 
               style="border-color: #cbd5e1; color: #334155; font-size: 13px;" 
               title="Ver usuarios agrupados por rol institucional">
                <i class="fas fa-users text-secondary"></i>
                <span class="d-none d-sm-inline">Usuarios por Rol</span>
            </a>

            <!-- Botón Crear Nuevo Permiso SGC -->
            <button type="button" 
                    class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" 
                    style="background-color: #39A900; border: none; font-size: 13px;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalCreatePermiso">
                <i class="fas fa-plus-circle"></i>
                <span>+ Nuevo Permiso</span>
            </button>
        </div>
    </div>

    <!-- ======= 4 METRIC KPI CARDS (Dashboard / Versiones Style) ======= -->
    <div class="row g-3 mb-4">
        <!-- Stat 1: Total Permisos SGC -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f0faf0; color: #39A900; border: 1px solid rgba(57, 169, 0, 0.15);">
                        <i class="fas fa-key fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Permisos SGC</div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $permisos->count() }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Acciones registradas</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 2: Roles del Sistema -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f0f9ff; color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.15);">
                        <i class="fas fa-users-gear fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Roles del Sistema</div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $roles->count() }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Perfiles institucionales</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 3: Asignaciones Activas -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #eaf8ea; color: #2b8000; border: 1px solid rgba(43, 128, 0, 0.15);">
                        <i class="fas fa-toggle-on fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Asignaciones</div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 26px; font-family: 'Outfit', sans-serif;">{{ $asignaciones->count() }}</div>
                        <small class="text-muted" style="font-size: 11.5px;">Privilegios activos</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat 4: Estado de Protección -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border rounded-4 p-3.5 bg-white shadow-xs h-100" style="padding: 18px 20px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 48px; height: 48px; background-color: #f8fafc; color: #475569; border: 1px solid #e2e8f0;">
                        <i class="fas fa-shield-halved fs-5"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 11px; letter-spacing: 0.5px;">Seguridad</div>
                        <div class="fw-bold text-dark lh-1 my-1" style="font-size: 22px; font-family: 'Outfit', sans-serif;">Estricta</div>
                        <small class="text-success fw-semibold" style="font-size: 11.5px;"><i class="fas fa-lock me-1"></i>Bloqueo activo</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= LISTADO / MATRIZ EMPRESARIAL DE PERMISOS ======= -->
    <div class="card border rounded-4 bg-white shadow-xs overflow-hidden mb-4">
        <!-- Card Header -->
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0 fs-6" style="font-family: 'Outfit', sans-serif;">
                        Matriz de Asignación de Permisos
                    </h5>
                    <small class="text-muted">
                        Active o desactive el interruptor para modificar los accesos en tiempo real.
                    </small>
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm" style="width: 260px;">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" id="filterMatrixInput" class="form-control bg-light border-start-0" placeholder="Buscar permiso o acción...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0 text-center" id="matrixTable" style="font-size: 13px;">
                <thead style="background-color: #f8fafc;">
                    <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.4px;">
                        <th class="text-start ps-4 py-3" style="min-width: 220px;">Acción / Permiso</th>
                        <th class="text-start py-3" style="min-width: 300px;">Descripción</th>
                        @foreach($roles as $role)
                            @php
                                $isAdmin = ($role->id == 1 || in_array(strtolower($role->slug), ['admin', 'superadmin']));
                            @endphp
                            <th class="py-3 px-3 {{ $isAdmin ? 'bg-light' : '' }}" style="min-width: 140px;">
                                <span class="d-block fw-bold text-dark">{{ $role->nombre }}</span>
                                @if($isAdmin)
                                    <small class="text-muted fw-normal" style="font-size: 10.5px;">Acceso Total</small>
                                @endif
                            </th>
                        @endforeach
                        <th class="py-3" style="width: 70px;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permisos as $permiso)
                        <tr class="permiso-row">
                            <!-- Permiso Acción / Código -->
                            <td class="text-start ps-4 py-3">
                                <span class="badge bg-light text-dark border fw-semibold px-2 py-1 font-monospace" style="font-size: 12px;">
                                    {{ $permiso->accion }}
                                </span>
                            </td>

                            <!-- Permiso Descripción -->
                            <td class="text-start py-3 text-secondary" style="font-size: 13px;">
                                {{ $permiso->descripcion ?? 'Sin descripción' }}
                            </td>

                            <!-- Columnas de Roles con Switches Interactivos -->
                            @foreach($roles as $role)
                                @php
                                    $isAdmin = ($role->id == 1 || in_array(strtolower($role->slug), ['admin', 'superadmin']));
                                    $tienePermiso = $asignaciones->contains(function ($item) use ($role, $permiso) {
                                        return $item->rol_id == $role->id && $item->permiso_id == $permiso->id;
                                    });
                                @endphp
                                <td class="py-3 px-3 {{ $isAdmin ? 'bg-light' : '' }}">
                                    @if($isAdmin)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 fw-semibold" style="font-size: 11px;">
                                            <i class="fas fa-check me-1"></i> Total
                                        </span>
                                    @else
                                        <div class="form-check form-switch d-inline-block m-0">
                                            <input class="form-check-input permission-switch" 
                                                   type="checkbox" 
                                                   role="switch" 
                                                   id="switch_{{ $role->id }}_{{ $permiso->id }}"
                                                   data-rol-id="{{ $role->id }}" 
                                                   data-rol-nombre="{{ $role->nombre }}"
                                                   data-permiso-id="{{ $permiso->id }}"
                                                   data-permiso-accion="{{ $permiso->accion }}"
                                                   {{ $tienePermiso ? 'checked' : '' }} 
                                                   style="cursor: pointer; font-size: 15px;">
                                        </div>
                                    @endif
                                </td>
                            @endforeach

                            <!-- Botón Eliminar Permiso -->
                            <td class="py-3 text-center">
                                <form action="{{ route('sgc.roles-permisos.permisos.destroy', $permiso->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar el permiso [{{ $permiso->accion }}] del SGC?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1 rounded-2" title="Eliminar permiso">
                                        <i class="fas fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 3 + $roles->count() }}" class="text-center py-5 text-muted">
                                <i class="fas fa-shield-halved fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                <span class="fw-semibold">No hay permisos registrados para el módulo SGC.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Crear Permiso SGC -->
<div class="modal fade" id="modalCreatePermiso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border rounded-4 shadow-sm">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark fs-6 mb-0" style="font-family: 'Outfit', sans-serif;">
                    Crear Nuevo Permiso SGC
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sgc.roles-permisos.permisos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Acción / Código del Permiso <span class="text-danger">*</span></label>
                        <input type="text" name="accion" class="form-control rounded-3 font-monospace" placeholder="Ej: anular_documento, exportar_auditoria" required>
                        <div class="form-text small text-muted">Use minúsculas y guiones bajos sin espacios.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Descripción</label>
                        <textarea name="descripcion" class="form-control rounded-3" rows="3" placeholder="Explique qué permite realizar este permiso en el SGC..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-3 rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4 rounded-3 text-white fw-semibold" style="background-color: #39A900; border: none;">Guardar Permiso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Floating Toast Container for Real-Time AJAX updates -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
    <div id="permissionToast" class="toast align-items-center border-0 shadow-lg text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 fw-semibold" id="toastMessage">
                <!-- Message dynamically injected -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-check-input:checked {
        background-color: #39A900 !important;
        border-color: #39A900 !important;
    }
    .form-check-input:focus {
        border-color: #39A900 !important;
        box-shadow: 0 0 0 0.2rem rgba(57, 169, 0, 0.2) !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const toastEl = document.getElementById('permissionToast');
    const toastMessage = document.getElementById('toastMessage');
    const bsToast = new bootstrap.Toast(toastEl, { delay: 3000 });

    function showNotification(message, isSuccess = true) {
        toastEl.className = 'toast align-items-center border-0 shadow-lg text-white ' + (isSuccess ? 'bg-success' : 'bg-danger');
        toastMessage.innerHTML = `<i class="fas ${isSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle'} fs-5"></i> <span>${message}</span>`;
        bsToast.show();
    }

    // Buscador en tiempo real
    const searchInput = document.getElementById('filterMatrixInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.permiso-row');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    }

    // AJAX Toggle en tiempo real
    const switches = document.querySelectorAll('.permission-switch');
    switches.forEach(sw => {
        sw.addEventListener('change', async function() {
            const isChecked = this.checked;
            const rolId = this.dataset.rolId;
            const rolNombre = this.dataset.rolNombre;
            const permisoId = this.dataset.permisoId;
            const permisoAccion = this.dataset.permisoAccion;

            const url = isChecked 
                ? "{{ route('sgc.roles-permisos.asignar') }}" 
                : "{{ route('sgc.roles-permisos.quitar') }}";

            this.disabled = true;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        rol_id: rolId,
                        permiso_id: permisoId
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showNotification(
                        isChecked 
                            ? `Permiso [${permisoAccion}] concedido a ${rolNombre}`
                            : `Permiso [${permisoAccion}] revocado de ${rolNombre}`,
                        true
                    );
                } else {
                    this.checked = !isChecked;
                    showNotification(data.message || 'Error al actualizar permiso', false);
                }
            } catch (err) {
                console.error(err);
                this.checked = !isChecked;
                showNotification('Error de conexión al actualizar permiso', false);
            } finally {
                this.disabled = false;
            }
        });
    });
});
</script>
@endpush
