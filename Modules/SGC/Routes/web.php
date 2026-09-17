<?php

use Illuminate\Support\Facades\Route;
use Modules\SGC\Http\Controllers\SGCController;
use Modules\SGC\Http\Controllers\UsuarioController;
use Modules\SGC\Http\Controllers\DocumentoController;
use Modules\SGC\Http\Controllers\RolesPermisosController;
use Modules\SGC\Http\Controllers\CatalogosController;
use Modules\SGC\Http\Controllers\ProcesoController;
use Modules\SGC\Http\Controllers\AreaController;
use Modules\SGC\Http\Controllers\TipoDocumentoController;
use Modules\SGC\Http\Controllers\SolicitudController;
use Modules\SGC\Http\Controllers\VersionesController;
use Modules\SGC\Http\Controllers\TrazabilidadController;
use Modules\SGC\Http\Controllers\ReportesController;
use Modules\SGC\Http\Controllers\NotificacionController;

/*
|--------------------------------------------------------------------------
| Web Routes - Módulo Sistema de Gestión de Calidad (SGC)
|--------------------------------------------------------------------------
| Protegidas granularmente por el middleware 'acceso.modulo:SGC,accion'.
| Si un rol no cuenta con el permiso requerido para una ruta, es bloqueado
| automáticamente y redirigido con alerta en la bitácora institucional.
*/

Route::prefix('sgc')->name('sgc.')->group(function () {

    // 1. Vista de Bienvenida Pública del SGC y Consulta de Documentos Vigentes
    Route::get('/', [SGCController::class, 'index'])->name('index');
    Route::get('/public/documentos/{id}/detalle', [SGCController::class, 'documentoDetallePublico'])->name('public.documento.detalle');
    Route::get('/public/documentos/{id}/preview', [SGCController::class, 'documentoPreviewPublico'])->name('public.documento.preview');
    Route::get('/public/documentos/{id}/pdf', [SGCController::class, 'documentoPdfPublico'])->name('public.documento.pdf');
    Route::get('/public/versiones/{versionId}/download', [SGCController::class, 'versionDownloadPublico'])->name('public.version.download');

    // 2. Dashboards de Acceso General y Específico por Rol
    Route::middleware(['auth', 'acceso.modulo:SGC'])->group(function () {
        Route::get('/dashboard', [SGCController::class, 'dashboard'])->name('dashboard');
        Route::get('/resp-calidad/dashboard', [SGCController::class, 'respCalidadDashboard'])->name('resp_calidad.dashboard');
        Route::get('/lider-area/dashboard', [SGCController::class, 'liderAreaDashboard'])->name('lider_area.dashboard');
    });

    Route::middleware(['auth', 'acceso.modulo:SGC,gestionar_roles_permisos'])->group(function () {
        Route::get('/admin/dashboard', [SGCController::class, 'adminDashboard'])->name('admin.dashboard');
    });

    // 3. Gestión y Consulta de Documentos
    Route::middleware(['auth'])->group(function () {
        // Consulta y descarga de documentos
        Route::middleware(['acceso.modulo:SGC,consultar_documento'])->group(function () {
            Route::get('/documentos', [DocumentoController::class, 'index'])->name('documentos.index');
            Route::get('/documentos/{id}', [DocumentoController::class, 'show'])->name('documentos.show')->where('id', '[0-9]+');
            Route::get('/documentos/{id}/download', [DocumentoController::class, 'download'])->name('documentos.download');
        });

        // Creación y registro de documentos
        Route::middleware(['acceso.modulo:SGC,crear_documento'])->group(function () {
            Route::get('/documentos/create', [DocumentoController::class, 'create'])->name('documentos.create');
            Route::post('/documentos', [DocumentoController::class, 'store'])->name('documentos.store');
        });

        // Edición de metadatos del documento
        Route::middleware(['acceso.modulo:SGC,editar_documento'])->group(function () {
            Route::put('/documentos/{id}', [DocumentoController::class, 'update'])->name('documentos.update');
        });

        // Eliminación / Archivado de documentos
        Route::middleware(['acceso.modulo:SGC,eliminar_documento'])->group(function () {
            Route::delete('/documentos/{id}', [DocumentoController::class, 'destroy'])->name('documentos.destroy');
        });
    });

    // 4. Gestión de Usuarios del SGC
    Route::middleware(['auth', 'acceso.modulo:SGC,gestionar_usuarios'])->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{user}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{user}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::post('/usuarios/{user}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('usuarios.toggle-status');

        // Aliases compatibles en inglés
        Route::get('/users', [UsuarioController::class, 'index'])->name('users.index');
        Route::post('/users', [UsuarioController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UsuarioController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsuarioController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('users.toggle-status');
    });

    // 5. Gestión de Roles y Permisos (Matriz y Catálogo)
    Route::prefix('roles-permisos')->name('roles-permisos.')->middleware(['auth', 'acceso.modulo:SGC,gestionar_roles_permisos'])->group(function () {
        Route::get('/', [RolesPermisosController::class, 'index'])->name('index');
        Route::post('/permisos', [RolesPermisosController::class, 'storePermiso'])->name('permisos.store');
        Route::put('/permisos/{permiso}', [RolesPermisosController::class, 'updatePermiso'])->name('permisos.update');
        Route::delete('/permisos/{permiso}', [RolesPermisosController::class, 'destroyPermiso'])->name('permisos.destroy');
        Route::post('/asignar', [RolesPermisosController::class, 'asignar'])->name('asignar');
        Route::post('/quitar', [RolesPermisosController::class, 'quitar'])->name('quitar');
        Route::get('/usuarios', [RolesPermisosController::class, 'usuariosPorRol'])->name('usuarios');
    });

    // 6. Catálogos Maestros (Procesos, Áreas, Tipos de Documento)
    Route::middleware(['auth', 'acceso.modulo:SGC,gestionar_catalogos'])->group(function () {
        Route::get('/catalogos', [CatalogosController::class, 'index'])->name('catalogos.index');

        // Procesos
        Route::post('/procesos', [ProcesoController::class, 'store'])->name('procesos.store');
        Route::put('/procesos/{proceso}', [ProcesoController::class, 'update'])->name('procesos.update');
        Route::delete('/procesos/{proceso}', [ProcesoController::class, 'destroy'])->name('procesos.destroy');
        Route::post('/procesos/{proceso}/toggle-status', [ProcesoController::class, 'toggleStatus'])->name('procesos.toggle-status');

        // Áreas
        Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
        Route::put('/areas/{area}', [AreaController::class, 'update'])->name('areas.update');
        Route::delete('/areas/{area}', [AreaController::class, 'destroy'])->name('areas.destroy');
        Route::post('/areas/{area}/toggle-status', [AreaController::class, 'toggleStatus'])->name('areas.toggle-status');

        // Tipos de Documento
        Route::post('/tipos-documento', [TipoDocumentoController::class, 'store'])->name('tipos-documento.store');
        Route::put('/tipos-documento/{tipo_documento}', [TipoDocumentoController::class, 'update'])->name('tipos-documento.update');
        Route::delete('/tipos-documento/{tipo_documento}', [TipoDocumentoController::class, 'destroy'])->name('tipos-documento.destroy');
        Route::post('/tipos-documento/{tipo_documento}/toggle-status', [TipoDocumentoController::class, 'toggleStatus'])->name('tipos-documento.toggle-status');
    });

    // 7. Solicitudes Documentales
    Route::middleware(['auth'])->group(function () {
        // Consulta de solicitudes (accesible para cualquier rol que pueda consultar, crear, aprobar o rechazar)
        Route::middleware(['acceso.modulo:SGC,consultar_solicitud|crear_solicitud|aprobar_solicitud|rechazar_solicitud'])->group(function () {
            Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
            Route::get('/solicitudes/{id}', [SolicitudController::class, 'show'])->name('solicitudes.show')->where('id', '[0-9]+');
            Route::get('/solicitudes/{id}/download-adjunto', [SolicitudController::class, 'downloadAdjunto'])->name('solicitudes.download-adjunto');

            // Aliases de consulta para Líder de Área y Administrador
            Route::get('/lider-area/solicitudes', [SolicitudController::class, 'index'])->name('lider_area.solicitudes.index');
            Route::get('/lider-area/solicitudes/{id}', [SolicitudController::class, 'show'])->name('lider_area.solicitudes.show')->where('id', '[0-9]+');
            Route::get('/lider-area/solicitudes/{id}/download-adjunto', [SolicitudController::class, 'downloadAdjunto'])->name('lider_area.solicitudes.download-adjunto');

            Route::get('/admin/solicitudes', [SolicitudController::class, 'indexAdmin'])->name('admin.solicitudes.index');
            Route::get('/admin/solicitudes/{id}', [SolicitudController::class, 'showAdmin'])->name('admin.solicitudes.show')->where('id', '[0-9]+');
            Route::get('/admin/solicitudes/{id}/download-adjunto', [SolicitudController::class, 'downloadAdjunto'])->name('admin.solicitudes.download-adjunto');
        });

        // Radicación / Creación de solicitudes
        Route::middleware(['acceso.modulo:SGC,crear_solicitud'])->group(function () {
            Route::post('/solicitudes', [SolicitudController::class, 'store'])->name('solicitudes.store');
            Route::post('/lider-area/solicitudes', [SolicitudController::class, 'store'])->name('lider_area.solicitudes.store');
            Route::post('/admin/solicitudes', [SolicitudController::class, 'store'])->name('admin.solicitudes.store');
        });

        // Evaluación y Aprobación
        Route::middleware(['acceso.modulo:SGC,aprobar_solicitud'])->group(function () {
            Route::get('/solicitudes/{id}/evaluar', [SolicitudController::class, 'evaluar'])->name('solicitudes.evaluar');
            Route::post('/solicitudes/{id}/aprobar', [SolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
        });

        // Rechazo de solicitudes
        Route::middleware(['acceso.modulo:SGC,rechazar_solicitud'])->group(function () {
            Route::post('/solicitudes/{id}/rechazar', [SolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
        });
    });

    // 8. Control y Gestión de Versiones Documentales
    Route::prefix('versiones')->name('versiones.')->middleware(['auth', 'acceso.modulo:SGC,gestionar_versiones'])->group(function () {
        Route::get('/', [VersionesController::class, 'index'])->name('index');
        Route::get('/historial/{documento_id?}', [VersionesController::class, 'historialView'])->name('historial-view');
        Route::post('/', [VersionesController::class, 'store'])->name('store');
        Route::get('/export/excel', [VersionesController::class, 'exportExcel'])->name('export.excel');
        Route::get('/documento/{documentoId}/historial', [VersionesController::class, 'historialDocumento'])->name('historial');
        Route::get('/{id}', [VersionesController::class, 'show'])->name('show')->where('id', '[0-9]+');
        Route::post('/{id}/cambiar-estado', [VersionesController::class, 'cambiarEstado'])->name('cambiar-estado');
        Route::get('/{id}/download', [VersionesController::class, 'download'])->name('download');
    });
    Route::middleware(['auth', 'acceso.modulo:SGC,gestionar_versiones'])->group(function () {
        Route::get('/admin/versiones', [VersionesController::class, 'index'])->name('admin.versiones.index');
        Route::get('/documentos/{id}/historial-versiones', [VersionesController::class, 'historialView'])->name('documentos.historial-versiones');
    });

    // 9. Trazabilidad y Auditoría Documental
    Route::middleware(['auth', 'acceso.modulo:SGC,ver_trazabilidad'])->group(function () {
        Route::get('/trazabilidad', [TrazabilidadController::class, 'index'])->name('trazabilidad.index');
        Route::get('/trazabilidad/export', [TrazabilidadController::class, 'export'])->name('trazabilidad.export');
        Route::get('/trazabilidad/{id}', [TrazabilidadController::class, 'show'])->name('trazabilidad.show');
        Route::get('/admin/trazabilidad', [TrazabilidadController::class, 'index'])->name('admin.trazabilidad.index');
    });

    // 10. Reportes e Indicadores de Calidad
    Route::middleware(['auth', 'acceso.modulo:SGC,ver_reportes'])->group(function () {
        Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/export/excel', [ReportesController::class, 'exportExcel'])->name('reportes.export.excel');
        Route::match(['get', 'post'], '/reportes/generar', [ReportesController::class, 'generar'])->name('reportes.generar');
        Route::get('/admin/reportes', [ReportesController::class, 'index'])->name('admin.reportes.index');
    });

    // 11. Notificaciones del SGC
    Route::middleware(['auth', 'acceso.modulo:SGC'])->group(function () {
        Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
        Route::post('/notificaciones/{id}/leer', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.leer');
        Route::post('/notificaciones/leer-todas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.leer-todas');
    });

});