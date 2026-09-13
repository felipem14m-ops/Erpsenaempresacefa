@extends('sgc::layouts.master')

@section('title', 'SGC • Usuarios con Acceso por Rol')

@section('content')
<!-- Header Title & Actions -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1" style="font-size: 26px;">Usuarios con Acceso a SGC</h2>
        <p class="text-muted small mb-0">Listado de funcionarios que cuentan con permisos autorizados en el Sistema de Gestión de Calidad.</p>
    </div>

    <div>
        <a href="{{ route('sgc.roles-permisos.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Volver a Matriz de Permisos</span>
        </a>
    </div>
</div>

<!-- Table Card -->
<div class="card border rounded-4 bg-white shadow-sm overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
            <thead class="table-light">
                <tr class="text-muted text-uppercase" style="font-size: 11.5px; letter-spacing: 0.4px;">
                    <th class="border-0 ps-4 py-3">Nombre Completo</th>
                    <th class="border-0 py-3">Usuario</th>
                    <th class="border-0 py-3">Correo Institucional</th>
                    <th class="border-0 py-3">Rol Asignado</th>
                    <th class="border-0 py-3 text-center">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $user)
                    <tr>
                        <td class="ps-4 py-3 fw-bold text-dark">
                            {{ $user->nombre_completo ?? $user->full_name }}
                        </td>
                        <td class="py-3 text-muted">
                            {{ $user->nombre_usuario }}
                        </td>
                        <td class="py-3 text-muted">
                            {{ $user->correo }}
                        </td>
                        <td class="py-3">
                            <span class="badge rounded-2 px-2 py-1 fw-semibold bg-success-subtle text-success border border-success-subtle">
                                {{ $user->rol->nombre ?? 'Sin Rol' }}
                            </span>
                        </td>
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-2 py-1 {{ $user->activo ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                                {{ $user->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-users-slash fs-3 d-block mb-2 opacity-50"></i>
                            No hay usuarios con roles vinculados a permisos de SGC actualmente.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
