<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolPermisoModuloController;
use App\Helpers\PermisosHelper;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\ProductoController;

Route::middleware(['auth'])->group(function () {
    Route::resource('usuarios', UsuarioController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

   Route::resource('usuarios', UsuarioController::class)->middleware(['auth']);

});


Route::get('/2fa/code', [EmailVerificationController::class, 'showForm'])
    ->middleware('auth')->name('2fa.code.form');

Route::post('/2fa/code', [EmailVerificationController::class, 'verifyCode'])
    ->middleware('auth')->name('2fa.code.verify');


Route::get('/2fa/setup', [TwoFactorController::class, 'setup'])->middleware('auth')->name('2fa.setup');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/2fa/resend', [EmailVerificationController::class, 'resendCode'])
    ->middleware('auth')
    ->name('2fa.code.resend');

Route::middleware(['auth'])->group(function () {
    Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/permisos', [PermisoController::class, 'index'])->name('permisos.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RolController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RolController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RolController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RolController::class, 'destroy'])->name('roles.destroy');
});

Route::resource('permisos', PermisoController::class);

Route::get('/roles/{id}/permisos', [RolController::class, 'editPermisos'])->name('roles.permisos.edit');
Route::put('/roles/{id}/permisos', [RolController::class, 'updatePermisos'])->name('roles.permisos.update');

Route::get('/roles/permisos', [RolPermisoModuloController::class, 'index'])->name('roles.permisos');
Route::post('/roles/permisos/guardar', [RolPermisoModuloController::class, 'guardar'])->name('roles.permisos.guardar');

Route::resource('reparaciones', ReparacionController::class);

Route::resource('producto', ProductoController::class);

require __DIR__.'/auth.php';


