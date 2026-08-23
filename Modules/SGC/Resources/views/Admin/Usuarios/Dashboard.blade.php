@extends('sgc::layouts.master')

@section('title', 'SGC • Gestión de Usuarios')

@section('content')
<!-- Header Title & Action Button -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Gestión de Usuarios</h2>
        <p class="text-muted small mb-0">Administración de funcionarios, líderes de área, responsables de calidad y sus permisos.</p>
    </div>

    <div>
        <button type="button" class="btn text-white rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" style="background-color: #39A900; border: none;" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
            <i class="fas fa-plus-circle"></i>
            <span>+ Nuevo Usuario</span>
        </button>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="card border rounded-4 bg-white shadow-sm p-3 mb-4">
    <form method="GET" action="{{ route('sgc.users.index') }}" class="row g-3 align-items-center">
        <div class="col-12 col-md-8 col-lg-9">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted ps-3"><i class="fas fa-search"></i></span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0 ps-0" placeholder="Buscar por nombre, usuario o correo electrónico..." onchange="this.form.submit()">
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <select name="rol_id" class="form-select bg-light" onchange="this.form.submit()">
                <option value="all" {{ request('rol_id') == 'all' ? 'selected' : '' }}>Filtrar por Rol: Todos</option>
                @foreach($roles as $roleItem)
                    <option value="{{ $roleItem->id }}" {{ request('rol_id') == $roleItem->id ? 'selected' : '' }}>
                        {{ $roleItem->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<!-- Main Users Table Card -->
<div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
            <thead class="table-light">
                <tr class="text-muted text-uppercase" style="font-size: 12px; letter-spacing: 0.4px;">
                    <th class="border-0 ps-4 py-3">Nombre Completo</th>
                    <th class="border-0 py-3">Usuario</th>
                    <th class="border-0 py-3">Correo</th>
                    <th class="border-0 py-3">Rol</th>
                    <th class="border-0 py-3 text-center">Estado</th>
                    <th class="border-0 pe-4 py-3 text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $userItem)
                    <tr>
                        <td class="ps-4 py-3">
                            <span class="fw-bold text-dark d-block">{{ $userItem->nombre_completo ?? $userItem->full_name }}</span>
                        </td>
                        <td class="py-3 text-muted">
                            {{ $userItem->nombre_usuario }}
                        </td>
                        <td class="py-3 text-muted">
                            {{ $userItem->correo }}
                        </td>
                        <td class="py-3">
                            @php
                                $rolSlug = $userItem->rol->slug ?? '';
                                $badgeBg = '#f1f5f9';
                                $badgeColor = '#475569';

                                if ($rolSlug === 'admin' || $userItem->rol_id == 1) {
                                    $badgeBg = '#eaf8ea';
                                    $badgeColor = '#2b8000';
                                } elseif ($rolSlug === 'resp_calidad' || $userItem->rol_id == 2) {
                                    $badgeBg = '#ebf5ff';
                                    $badgeColor = '#1d4ed8';
                                } elseif ($rolSlug === 'lider_area' || $userItem->rol_id == 3) {
                                    $badgeBg = '#fef3c7';
                                    $badgeColor = '#b45309';
                                }
                            @endphp
                            <span class="badge rounded-2 px-2 py-1 fw-semibold" style="background-color: {{ $badgeBg }}; color: {{ $badgeColor }}; font-size: 11.5px;">
                                {{ $userItem->rol->nombre ?? 'Consultante' }}
                            </span>
                        </td>
                        <td class="py-3 text-center">
                            <form action="{{ route('sgc.users.toggle-status', $userItem->id) }}" method="POST" class="d-inline">
                                @csrf
                                <div class="form-check form-switch d-inline-flex align-items-center gap-2 m-0">
                                    <input class="form-check-input" type="checkbox" role="switch" onchange="this.form.submit()" {{ $userItem->activo ? 'checked' : '' }} style="cursor: pointer; font-size: 16px;">
                                    <span class="small fw-semibold {{ $userItem->activo ? 'text-success' : 'text-muted' }}" style="font-size: 12px;">
                                        {{ $userItem->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </form>
                        </td>
                        <td class="pe-4 py-3 text-end">
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-link text-secondary p-0 me-2 text-decoration-none" title="Editar Usuario" onclick="openEditModal({{ json_encode($userItem) }})">
                                <i class="fas fa-pen-to-square"></i>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('sgc.users.destroy', $userItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar al usuario {{ $userItem->full_name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none" title="Eliminar Usuario">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-user-slash fs-3 d-block mb-2 text-secondary opacity-50"></i>
                            No se encontraron usuarios registrados con los criterios seleccionados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Card Footer with Pagination -->
    <div class="card-footer bg-white border-top py-3 px-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="text-muted small">
            Mostrando {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} de {{ $users->total() }} usuarios registrados
        </div>
        <div>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- ======= MODAL: CREAR NUEVO USUARIO ======= -->
<div class="modal fade" id="modalCreateUser" tabindex="-1" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark" id="modalCreateUserLabel">Registrar Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sgc.users.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nombre Completo</label>
                        <input type="text" name="nombre_completo" class="form-control rounded-3" placeholder="Ej: Carlos Alberto Ruiz" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nombre de Usuario (Nickname)</label>
                        <input type="text" name="nombre_usuario" class="form-control rounded-3" placeholder="Ej: cruiz" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Correo Institucional</label>
                        <input type="email" name="correo" class="form-control rounded-3" placeholder="cruiz@sena.edu.co" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Rol Asignado</label>
                        <select name="rol_id" class="form-select rounded-3" required>
                            @foreach($roles as $roleOpt)
                                <option value="{{ $roleOpt->id }}">{{ $roleOpt->nombre }} ({{ $roleOpt->descripcion }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Contraseña Temporal</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Mínimo 8 caracteres" required>
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="activo" value="1" id="switchCreateActivo" checked>
                        <label class="form-check-label small fw-semibold text-secondary" for="switchCreateActivo">Usuario activo inmediatamente</label>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white rounded-3 px-4 fw-semibold" style="background-color: #39A900;">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======= MODAL: EDITAR USUARIO ======= -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark" id="modalEditUserLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nombre Completo</label>
                        <input type="text" id="edit_nombre_completo" name="nombre_completo" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nombre de Usuario (Nickname)</label>
                        <input type="text" id="edit_nombre_usuario" name="nombre_usuario" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Correo Institucional</label>
                        <input type="email" id="edit_correo" name="correo" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Rol Asignado</label>
                        <select id="edit_rol_id" name="rol_id" class="form-select rounded-3" required>
                            @foreach($roles as $roleOpt)
                                <option value="{{ $roleOpt->id }}">{{ $roleOpt->nombre }} ({{ $roleOpt->descripcion }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Dejar en blanco para no modificar">
                    </div>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="activo" value="1" id="edit_activo">
                        <label class="form-check-label small fw-semibold text-secondary" for="edit_activo">Usuario Activo</label>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn text-white rounded-3 px-4 fw-semibold" style="background-color: #39A900;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditModal(user) {
        document.getElementById('formEditUser').action = '/sgc/users/' + user.id;
        document.getElementById('edit_nombre_completo').value = user.nombre_completo || '';
        document.getElementById('edit_nombre_usuario').value = user.nombre_usuario || '';
        document.getElementById('edit_correo').value = user.correo || '';
        document.getElementById('edit_rol_id').value = user.rol_id || 4;
        document.getElementById('edit_activo').checked = user.activo == 1;

        var modal = new bootstrap.Modal(document.getElementById('modalEditUser'));
        modal.show();
    }
</script>
@endpush
