<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;

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



require __DIR__.'/auth.php';


