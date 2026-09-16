<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Modules\SGC\Http\Controllers\SGCController;
use Modules\SGC\Http\Controllers\UsuarioController;
use Modules\SGC\Http\Controllers\DocumentoController;
use Modules\SGC\Http\Controllers\RolesPermisosController;

/*
|--------------------------------------------------------------------------
| Web Routes - Módulo Sistema de Gestión de Calidad (SGC)
|--------------------------------------------------------------------------
*/

Route::prefix('sgc')->name('sgc.')->group(function () {

    // 1. Vista de Bienvenida (Pública) del Módulo SGC
    Route::get('/', [SGCController::class, 'index'])->name('index');

    // 2. Enrutamiento automático al Dashboard SGC (Protegido por Autenticación y Acceso al Módulo SGC)
    Route::get('/dashboard', [SGCController::class, 'dashboard'])->middleware(['auth', 'acceso.modulo:SGC'])->name('dashboard');

    // Rutas directas por rol
    Route::get('/admin/dashboard', [SGCController::class, 'adminDashboard'])->middleware(['auth', 'acceso.modulo:SGC'])->name('admin.dashboard');
    Route::get('/resp-calidad/dashboard', [SGCController::class, 'respCalidadDashboard'])->middleware(['auth', 'acceso.modulo:SGC'])->name('resp_calidad.dashboard');
    Route::get('/lider-area/dashboard', [SGCController::class, 'liderAreaDashboard'])->middleware(['auth', 'acceso.modulo:SGC'])->name('lider_area.dashboard');
    Route::get('/consultante/dashboard', [SGCController::class, 'consultanteDashboard'])->middleware(['auth', 'acceso.modulo:SGC'])->name('consultante.dashboard');


    // 3. Gestión y Consulta de Documentos, Usuarios, Roles y Permisos (Protegidas)
    Route::middleware(['auth', 'acceso.modulo:SGC'])->group(function () {
        
        // Gestión de Documentos
        Route::get('/documentos', [DocumentoController::class, 'index'])->name('documentos.index');
        Route::get('/documentos/create', [DocumentoController::class, 'create'])->name('documentos.create');
        Route::post('/documentos', [DocumentoController::class, 'store'])->name('documentos.store');
        Route::get('/documentos/{id}', [DocumentoController::class, 'show'])->name('documentos.show');
        Route::put('/documentos/{id}', [DocumentoController::class, 'update'])->name('documentos.update');
        Route::delete('/documentos/{id}', [DocumentoController::class, 'destroy'])->name('documentos.destroy');
        Route::get('/documentos/{id}/download', [DocumentoController::class, 'download'])->name('documentos.download');

        // Gestión de Usuarios (Rutas Oficiales en Español)
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{user}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{user}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::post('/usuarios/{user}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('usuarios.toggle-status');

        // Aliases en inglés (sgc.users.*)
        Route::get('/users', [UsuarioController::class, 'index'])->name('users.index');
        Route::post('/users', [UsuarioController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UsuarioController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsuarioController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('users.toggle-status');

        // Gestión de Roles y Permisos (sgc.roles-permisos.*)
        Route::prefix('roles-permisos')->name('roles-permisos.')->group(function () {
            Route::get('/', [RolesPermisosController::class, 'index'])->name('index');
            Route::post('/permisos', [RolesPermisosController::class, 'storePermiso'])->name('permisos.store');
            Route::put('/permisos/{permiso}', [RolesPermisosController::class, 'updatePermiso'])->name('permisos.update');
            Route::delete('/permisos/{permiso}', [RolesPermisosController::class, 'destroyPermiso'])->name('permisos.destroy');
            Route::post('/asignar', [RolesPermisosController::class, 'asignar'])->name('asignar');
            Route::post('/quitar', [RolesPermisosController::class, 'quitar'])->name('quitar');
            Route::get('/usuarios', [RolesPermisosController::class, 'usuariosPorRol'])->name('usuarios');
        });

        // Catálogos Maestros (Vista unificada con pestañas)
        Route::get('/catalogos', [\Modules\SGC\Http\Controllers\CatalogosController::class, 'index'])->name('catalogos.index');

        // Procesos (CRUD y cambio de estado)
        Route::post('/procesos', [\Modules\SGC\Http\Controllers\ProcesoController::class, 'store'])->name('procesos.store');
        Route::put('/procesos/{proceso}', [\Modules\SGC\Http\Controllers\ProcesoController::class, 'update'])->name('procesos.update');
        Route::delete('/procesos/{proceso}', [\Modules\SGC\Http\Controllers\ProcesoController::class, 'destroy'])->name('procesos.destroy');
        Route::post('/procesos/{proceso}/toggle-status', [\Modules\SGC\Http\Controllers\ProcesoController::class, 'toggleStatus'])->name('procesos.toggle-status');

        // Áreas (CRUD y cambio de estado)
        Route::post('/areas', [\Modules\SGC\Http\Controllers\AreaController::class, 'store'])->name('areas.store');
        Route::put('/areas/{area}', [\Modules\SGC\Http\Controllers\AreaController::class, 'update'])->name('areas.update');
        Route::delete('/areas/{area}', [\Modules\SGC\Http\Controllers\AreaController::class, 'destroy'])->name('areas.destroy');
        Route::post('/areas/{area}/toggle-status', [\Modules\SGC\Http\Controllers\AreaController::class, 'toggleStatus'])->name('areas.toggle-status');

        // Tipos de Documento (CRUD y cambio de estado)
        Route::post('/tipos-documento', [\Modules\SGC\Http\Controllers\TipoDocumentoController::class, 'store'])->name('tipos-documento.store');
        Route::put('/tipos-documento/{tipo_documento}', [\Modules\SGC\Http\Controllers\TipoDocumentoController::class, 'update'])->name('tipos-documento.update');
        Route::delete('/tipos-documento/{tipo_documento}', [\Modules\SGC\Http\Controllers\TipoDocumentoController::class, 'destroy'])->name('tipos-documento.destroy');
        Route::post('/tipos-documento/{tipo_documento}/toggle-status', [\Modules\SGC\Http\Controllers\TipoDocumentoController::class, 'toggleStatus'])->name('tipos-documento.toggle-status');

        // Solicitudes Documentales (Gestión, Evaluación y Aprobación de Calidad)
        Route::get('/solicitudes', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'index'])->name('solicitudes.index');
        Route::post('/solicitudes', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'store'])->name('solicitudes.store');
        Route::get('/solicitudes/{id}/evaluar', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'evaluar'])->name('solicitudes.evaluar');
        Route::post('/solicitudes/{id}/aprobar', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
        Route::post('/solicitudes/{id}/rechazar', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
        Route::get('/solicitudes/{id}', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'show'])->name('solicitudes.show');
        Route::get('/solicitudes/{id}/download-adjunto', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'downloadAdjunto'])->name('solicitudes.download-adjunto');

        // Aliases para Líder de Área
        Route::get('/lider-area/solicitudes', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'index'])->name('lider_area.solicitudes.index');
        Route::post('/lider-area/solicitudes', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'store'])->name('lider_area.solicitudes.store');
        Route::get('/lider-area/solicitudes/{id}', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'show'])->name('lider_area.solicitudes.show');
        Route::get('/lider-area/solicitudes/{id}/download-adjunto', [\Modules\SGC\Http\Controllers\SolicitudController::class, 'downloadAdjunto'])->name('lider_area.solicitudes.download-adjunto');

        // Reportes del SGC (Administrador e Indicadores de Calidad)
        Route::get('/reportes', [\Modules\SGC\Http\Controllers\ReportesController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/export/excel', [\Modules\SGC\Http\Controllers\ReportesController::class, 'exportExcel'])->name('reportes.export.excel');
        Route::get('/admin/reportes', [\Modules\SGC\Http\Controllers\ReportesController::class, 'index'])->name('admin.reportes.index');

        // Trazabilidad y Auditoría Documental SGC
        Route::get('/trazabilidad', [\Modules\SGC\Http\Controllers\TrazabilidadController::class, 'index'])->name('trazabilidad.index');
        Route::get('/trazabilidad/export', [\Modules\SGC\Http\Controllers\TrazabilidadController::class, 'export'])->name('trazabilidad.export');
        Route::get('/trazabilidad/{id}', [\Modules\SGC\Http\Controllers\TrazabilidadController::class, 'show'])->name('trazabilidad.show');
        Route::get('/admin/trazabilidad', [\Modules\SGC\Http\Controllers\TrazabilidadController::class, 'index'])->name('admin.trazabilidad.index');

        // Notificaciones SGC en tiempo real
        Route::get('/notificaciones', [\Modules\SGC\Http\Controllers\NotificacionController::class, 'index'])->name('notificaciones.index');
        Route::post('/notificaciones/{id}/leer', [\Modules\SGC\Http\Controllers\NotificacionController::class, 'marcarLeida'])->name('notificaciones.leer');
        Route::post('/notificaciones/leer-todas', [\Modules\SGC\Http\Controllers\NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.leer-todas');

    });

});