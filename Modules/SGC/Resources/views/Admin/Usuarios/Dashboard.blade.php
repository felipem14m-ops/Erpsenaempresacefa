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
    <form method="GET" action="{{ route('sgc.usuarios.index') }}" class="row g-3 align-items-center">
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
                    <th class="border-0 pe-4 py-3 text-center" style="width: 120px;">Acciones</th>
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
                            <form id="form-toggle-status-{{ $userItem->id }}" action="{{ route('sgc.usuarios.toggle-status', $userItem->id) }}" method="POST" class="d-inline">
                                @csrf
                                <div class="form-check form-switch d-inline-flex align-items-center gap-2 m-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch-status-{{ $userItem->id }}" 
                                           {{ $userItem->activo ? 'checked' : '' }} 
                                           style="cursor: pointer; font-size: 16px;" 
                                           onchange="confirmToggleStatus(this, {{ $userItem->id }}, '{{ addslashes($userItem->nombre_completo ?? $userItem->full_name) }}', {{ $userItem->activo ? 'true' : 'false' }})">
                                    <span class="small fw-semibold {{ $userItem->activo ? 'text-success' : 'text-muted' }}" style="font-size: 12px;">
                                        {{ $userItem->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </form>
                        </td>
                        <td class="pe-4 py-3 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center gap-2">
                                <!-- Botón Editar (Lápiz SVG Bootstrap) -->
                                <button type="button" class="btn btn-sm btn-outline-success rounded-2 d-inline-flex align-items-center justify-content-center" title="Editar Usuario" onclick="openEditModal({{ json_encode($userItem) }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                    </svg>
                                </button>

                                <!-- Botón Eliminar (Canasta de Basura SVG Bootstrap) -->
                                <form id="form-delete-user-{{ $userItem->id }}" action="{{ route('sgc.usuarios.destroy', $userItem->id) }}" method="POST" class="d-inline m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-2 d-inline-flex align-items-center justify-content-center" title="Eliminar Usuario" onclick="confirmDeleteUser({{ $userItem->id }}, '{{ addslashes($userItem->nombre_completo ?? $userItem->full_name) }}')">
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
            {{ $users->links('sgc::layouts.partials.pagination') }}
        </div>
    </div>
</div>

<!-- ======= MODAL: CREAR NUEVO USUARIO ======= -->
<div class="modal fade" id="modalCreateUser" tabindex="-1" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 bg-white border text-success shadow-sm d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalCreateUserLabel">Registrar Nuevo Usuario</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Sistema de Gestión de Calidad (SGC) • SENA Empresa</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('sgc.usuarios.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-4">
                    <!-- Sección: Datos Personales e Institucionales -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="text-uppercase text-secondary fw-bold" style="font-size: 11.5px; letter-spacing: 0.5px;">1. Información General y Contacto</span>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre_completo" class="form-control" placeholder="Ej: Carlos Alberto Ruiz" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre de Usuario / Alias <span class="text-danger">*</span></label>
                            <input type="text" name="nombre_usuario" class="form-control" placeholder="Ej: cruiz" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Correo Electrónico Institucional <span class="text-danger">*</span></label>
                            <input type="email" name="correo" class="form-control" placeholder="ejemplo@sena.edu.co" required>
                        </div>
                    </div>

                    <!-- Sección: Perfil y Seguridad -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="text-uppercase text-secondary fw-bold" style="font-size: 11.5px; letter-spacing: 0.5px;">2. Rol, Acceso y Estado</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Rol en el Sistema <span class="text-danger">*</span></label>
                            <select name="rol_id" class="form-select" required>
                                @foreach($roles as $roleOpt)
                                    <option value="{{ $roleOpt->id }}">{{ $roleOpt->nombre }} ({{ $roleOpt->descripcion }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Estado de la Cuenta <span class="text-danger">*</span></label>
                            <select name="activo" class="form-select" required>
                                <option value="1" selected>Activo (Habilitado)</option>
                                <option value="0">Inactivo (Deshabilitado)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Contraseña de Acceso <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                            <div class="form-text text-muted" style="font-size: 11.5px;">Asigne una contraseña temporal o definitiva que cumpla con los estándares de seguridad.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted"><span class="text-danger">*</span> Campos obligatorios</small>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success px-4 text-white" style="background-color: #39A900; border-color: #39A900;">Guardar Usuario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======= MODAL: EDITAR USUARIO ======= -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 bg-white border text-primary shadow-sm d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.053c.123-.33.303-.63.53-.895q-.623-.058-1.27-.058c-2.67 0-8 1.34-8 4v2h7.625c.108-.344.27-.66.47-.946q.081-.054.161-.054"/>
                            <path d="M11.96 5.04a1 1 0 1 0-1.92.548 1 1 0 0 0 1.92-.548M14.5 12a1 1 0 0 1-.954.998l-.134.32a1 1 0 0 1-.226.315l.08.337a1 1 0 0 1-.77 1.203l-.337.08a1 1 0 0 1-.315.226l-.32.134a1 1 0 0 1-1.996 0l-.32-.134a1 1 0 0 1-.315-.226l-.337-.08a1 1 0 0 1-.77-1.203l.08-.337a1 1 0 0 1-.226-.315l-.134-.32a1 1 0 0 1 0-1.996l.134-.32a1 1 0 0 1 .226-.315l-.08-.337a1 1 0 0 1 .77-1.203l.337-.08a1 1 0 0 1 .315-.226l.32-.134a1 1 0 0 1 1.996 0l.32.134a1 1 0 0 1 .315.226l.337.08a1 1 0 0 1 .77 1.203l-.08.337a1 1 0 0 1 .226.315l.134.32a1 1 0 0 1 .954.998m-2.5.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="modalEditUserLabel">Modificar Datos de Usuario</h5>
                        <p class="text-muted small mb-0" style="font-size: 12.5px;">Actualización de ficha de usuario y asignación de permisos</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4">
                    <!-- Sección: Datos Personales e Institucionales -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="text-uppercase text-secondary fw-bold" style="font-size: 11.5px; letter-spacing: 0.5px;">1. Información General y Contacto</span>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" id="edit_nombre_completo" name="nombre_completo" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Nombre de Usuario / Alias <span class="text-danger">*</span></label>
                            <input type="text" id="edit_nombre_usuario" name="nombre_usuario" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Correo Electrónico Institucional <span class="text-danger">*</span></label>
                            <input type="email" id="edit_correo" name="correo" class="form-control" required>
                        </div>
                    </div>

                    <!-- Sección: Perfil y Seguridad -->
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <span class="text-uppercase text-secondary fw-bold" style="font-size: 11.5px; letter-spacing: 0.5px;">2. Rol, Acceso y Estado</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Rol en el Sistema <span class="text-danger">*</span></label>
                            <select id="edit_rol_id" name="rol_id" class="form-select" required>
                                @foreach($roles as $roleOpt)
                                    <option value="{{ $roleOpt->id }}">{{ $roleOpt->nombre }} ({{ $roleOpt->descripcion }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-dark mb-1">Estado de la Cuenta <span class="text-danger">*</span></label>
                            <select id="edit_activo" name="activo" class="form-select" required>
                                <option value="1">Activo (Habilitado)</option>
                                <option value="0">Inactivo (Deshabilitado)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-dark mb-1">Nueva Contraseña de Acceso</label>
                            <input type="password" name="password" class="form-control" placeholder="Dejar en blanco si no desea modificar la contraseña actual">
                            <div class="form-text text-muted" style="font-size: 11.5px;">Complete este campo únicamente si necesita restablecer la clave del usuario.</div>
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
@endsection

@push('scripts')
<script>
    function openEditModal(user) {
        document.getElementById('formEditUser').action = '{{ url('/sgc/usuarios') }}/' + user.id;
        document.getElementById('edit_nombre_completo').value = user.nombre_completo || '';
        document.getElementById('edit_nombre_usuario').value = user.nombre_usuario || '';
        document.getElementById('edit_correo').value = user.correo || '';
        document.getElementById('edit_rol_id').value = user.rol_id || 4;
        document.getElementById('edit_activo').value = (user.activo == 1 || user.activo === true) ? '1' : '0';

        var modal = new bootstrap.Modal(document.getElementById('modalEditUser'));
        modal.show();
    }

    /**
     * Confirmación con SweetAlert2 para eliminar un usuario
     */
    function confirmDeleteUser(userId, userName) {
        Swal.fire({
            title: '¿Eliminar usuario?',
            html: `¿Está seguro de que desea eliminar permanentemente al usuario <strong>${userName}</strong>?<br><small class="text-muted">Esta acción es irreversible y revocará todos sus accesos al sistema SGC.</small>`,
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
                document.getElementById('form-delete-user-' + userId).submit();
            }
        });
    }

    /**
     * Confirmación con SweetAlert2 para cambiar el estado activo/inactivo de un usuario
     */
    function confirmToggleStatus(switchEl, userId, userName, isCurrentlyActive) {
        const isDeactivating = isCurrentlyActive;
        const actionTitle = isDeactivating ? '¿Desactivar usuario?' : '¿Activar usuario?';
        const confirmBtnClass = isDeactivating ? 'btn btn-warning px-3 text-dark me-2' : 'btn btn-success px-3 text-white me-2';
        const iconType = isDeactivating ? 'warning' : 'question';
        const message = isDeactivating 
            ? `El usuario <strong>${userName}</strong> quedará inactivo y no podrá iniciar sesión en el SGC.`
            : `El usuario <strong>${userName}</strong> será habilitado para acceder nuevamente al SGC.`;

        Swal.fire({
            title: actionTitle,
            html: `${message}<br><small class="text-muted">¿Desea confirmar este cambio de estado?</small>`,
            icon: iconType,
            showCancelButton: true,
            confirmButtonText: isDeactivating ? 'Sí, desactivar' : 'Sí, activar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            customClass: {
                confirmButton: confirmBtnClass,
                cancelButton: 'btn btn-outline-secondary px-3'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-toggle-status-' + userId).submit();
            } else {
                // Revert switch to previous state if cancelled
                switchEl.checked = isCurrentlyActive;
            }
        });
    }
</script>
@endpush
