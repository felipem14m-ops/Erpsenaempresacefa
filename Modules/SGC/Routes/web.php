<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Modules\SGC\Http\Controllers\SGCController;
use Modules\SGC\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Web Routes - Módulo Sistema de Gestión de Calidad (SGC)
|--------------------------------------------------------------------------
*/

Route::prefix('sgc')->name('sgc.')->group(function () {

    // 1. Vista de Bienvenida (Welcome) del Módulo SGC
    Route::get('/', function () {
        return view('sgc::welcome');
    })->name('index');

    // 2. Enrutamiento automático por Rol al Dashboard
    Route::get('/dashboard', function () {
        /** @var User $user */
        $user = Auth::user();
        $role = $user->rol_id;

        if ($role == 1) {
            return view('sgc::Admin.Dashboard');
        } elseif ($role == 2) {
            return view('sgc::Resp_Calidad.Dashboard');
        } elseif ($role == 3) {
            return view('sgc::Lider_Area.Dashboard');
        } elseif ($role == 4) {
            return view('sgc::Consultante.Dashboard');
        }
        return view('sgc::Consultante.Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Rutas directas por rol
    Route::get('/admin/dashboard', function () {
        return view('sgc::Admin.Dashboard');
    })->middleware(['auth'])->name('admin.dashboard');

    Route::get('/resp-calidad/dashboard', function () {
        return view('sgc::Resp_Calidad.Dashboard');
    })->middleware(['auth'])->name('resp_calidad.dashboard');

    Route::get('/lider-area/dashboard', function () {
        return view('sgc::Lider_Area.Dashboard');
    })->middleware(['auth'])->name('lider_area.dashboard');

    Route::get('/consultante/dashboard', function () {
        return view('sgc::Consultante.Dashboard');
    })->middleware(['auth'])->name('consultante.dashboard');

    // 3. Gestión de Usuarios dentro del Módulo SGC (Controlador interno del módulo)
    Route::middleware('auth')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{user}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{user}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::post('/usuarios/{user}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('usuarios.toggle-status');

        // Aliases en inglés
        Route::get('/users', [UsuarioController::class, 'index'])->name('users.index');
        Route::post('/users', [UsuarioController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UsuarioController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UsuarioController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('users.toggle-status');
    });

});

// Alias global para /dashboard
Route::get('/dashboard', function () {
    /** @var User $user */
    $user = Auth::user();
    $role = $user->rol_id;
    if ($role == 1) {
        return view('sgc::Admin.Dashboard');
    } elseif ($role == 2) {
        return view('sgc::Resp_Calidad.Dashboard');
    } elseif ($role == 3) {
        return view('sgc::Lider_Area.Dashboard');
    } elseif ($role == 4) {
        return view('sgc::Consultante.Dashboard');
    }
    return view('sgc::Consultante.Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
