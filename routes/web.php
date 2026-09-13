<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Modules\SICA\Entities\Bloque;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController as AdminUsuarioController;

/*
|--------------------------------------------------------------------------
| Portal Principal del ERP
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $bloques = collect();
    if (Schema::hasTable('bloques')) {
        $bloques = Bloque::with(['apps' => function ($query) {
            $query->orderBy('name');
        }])->orderBy('order_index')->get();
    }
    return view('welcome', compact('bloques'));
})->name('home');

/*
|--------------------------------------------------------------------------
| Autenticación Institucional (Login / Logout con Auditoría y Bloqueo)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::match(['get', 'post'], '/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Deshabilitación del registro público (Regla de negocio: creación exclusiva por Administrador)
Route::get('/register', function () {
    return redirect()->route('login')->with('info', 'El registro público está deshabilitado. Solicite su cuenta al Administrador del Sistema.');
})->name('register');
Route::post('/register', function () {
    return redirect()->route('login')->with('info', 'El registro público está deshabilitado. Solicite su cuenta al Administrador del Sistema.');
})->name('register.post');

/*
|--------------------------------------------------------------------------
| Panel Administrativo de Usuarios del Núcleo ERP (/admin/usuarios)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'acceso.modulo:core'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('usuarios', AdminUsuarioController::class)->parameters(['usuarios' => 'usuario']);
    Route::post('usuarios/{usuario}/toggle-status', [AdminUsuarioController::class, 'toggleStatus'])->name('usuarios.toggle-status');

    // Aliases en inglés
    Route::resource('users', AdminUsuarioController::class)->parameters(['users' => 'usuario']);
    Route::post('users/{usuario}/toggle-status', [AdminUsuarioController::class, 'toggleStatus'])->name('users.toggle-status');
});

// Alias directo para gestión de usuarios
Route::middleware(['auth', 'acceso.modulo:core'])->group(function () {
    Route::resource('users', AdminUsuarioController::class)->parameters(['users' => 'usuario']);
});
