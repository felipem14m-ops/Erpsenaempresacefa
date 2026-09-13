@extends('sgc::layouts.master')

@section('title', 'SGC • Matriz de Roles y Permisos')

@section('content')
<!-- Header Title & Actions -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Roles y Permisos del SGC</h2>
        <p class="text-muted small mb-0">Control granular de accesos, permisos y matriz de asignación exclusiva del Sistema de Gestión de Calidad.</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('sgc.roles-permisos.usuarios') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
            <i class="fas fa-users"></i>
            <span>Ver Usuarios por Rol</span>
        </a>
        <button type="button" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;" data-bs-toggle="modal" data-bs-target="#modalCreatePermiso">
            <i class="fas fa-plus-circle"></i>
            <span>+ Nuevo Permiso SGC</span>
        </button>
    </div>
</div>

<!-- Matriz de Roles y Permisos -->
<div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold text-dark mb-0 fs-6">Matriz de Asignación de Permisos SGC</h5>
            <small class="text-muted">Marque o desmarque para conceder o revocar permisos a cada rol institucional.</small>
        </div>
        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">Módulo SGC</span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0 text-center" style="font-size: 13.5px;">
            <thead class="table-light">
                <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.4px;">
                    <th class="text-start ps-4 py-3" style="min-width: 260px;">Acción / Permiso SGC</th>
                    <th class="text-start py-3" style="min-width: 260px;">Descripción</th>
                    @foreach($roles as $role)
                        <th class="py-3" style="min-width: 140px;">
                            <span class="d-block fw-bold text-dark">{{ $role->nombre }}</span>
                        </th>
                    @endforeach
                    <th class="py-3" style="width: 100px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permisos as $permiso)
                    <tr>
                        <!-- Permiso Acción -->
                        <td class="text-start ps-4 py-3">
                            <span class="badge bg-light text-dark border fw-bold px-2 py-1" style="font-size: 12px; font-family: monospace;">
                                {{ $permiso->accion }}
                            </span>
                        </td>

                        <!-- Permiso Descripción -->
                        <td class="text-start py-3 text-muted">
                            {{ $permiso->descripcion ?? 'Sin descripción' }}
                        </td>

                        <!-- Columnas de Roles (Checks interactivos) -->
                        @foreach($roles as $role)
                            @php
                                $tienePermiso = $asignaciones->contains(function ($item) use ($role, $permiso) {
                                    return $item->rol_id == $role->id && $item->permiso_id == $permiso->id;
                                });
                            @endphp
                            <td class="py-3">
                                <form action="{{ $tienePermiso ? route('sgc.roles-permisos.quitar') : route('sgc.roles-permisos.asignar') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="rol_id" value="{{ $role->id }}">
                                    <input type="hidden" name="permiso_id" value="{{ $permiso->id }}">
                                    <div class="form-check d-inline-block m-0">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               {{ $tienePermiso ? 'checked' : '' }} 
                                               onchange="this.form.submit()" 
                                               style="cursor: pointer; font-size: 16px;">
                                    </div>
                                </form>
                            </td>
                        @endforeach

                        <!-- Botón Eliminar Permiso -->
                        <td class="py-3">
                            <form action="{{ route('sgc.roles-permisos.permisos.destroy', $permiso->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este permiso de SGC?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" title="Eliminar Permiso">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 3 + $roles->count() }}" class="text-center py-4 text-muted">
                            <i class="fas fa-shield-halved fs-3 d-block mb-2 text-secondary opacity-50"></i>
                            No hay permisos definidos aún para el módulo SGC. Cree el primero arriba.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Crear Permiso SGC -->
<div class="modal fade" id="modalCreatePermiso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark fs-6">Crear Nuevo Permiso para SGC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sgc.roles-permisos.permisos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Nombre de la Acción (Slug / Código) <span class="text-danger">*</span></label>
                        <input type="text" name="accion" class="form-control" placeholder="Ej: aprobar_documento, ver_reportes" required>
                        <div class="form-text small text-muted">Use minúsculas y guiones bajos sin espacios.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Descripción de la Funcionalidad</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Explique qué permite realizar este permiso en el SGC..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4 text-white" style="background-color: #39A900; border: none;">Guardar Permiso</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
