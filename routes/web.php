<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard principal (redirección según rol)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ============================================
    // RUTAS PARA SUPERADMIN Y ADMIN
    // ============================================
    Route::middleware(['role:superadmin,administrador'])->group(function () {
        // Búsqueda de clientes (DEBE IR ANTES del resource)
        Route::get('/clientes/buscar', [\App\Http\Controllers\ClienteController::class, 'buscar'])->name('clientes.buscar');
    });

    // ============================================
    // RUTAS SOLO PARA SUPERADMIN
    // ============================================
    Route::middleware(['superadmin'])->group(function () {
        // Rutas de clientes
        Route::resource('clientes', \App\Http\Controllers\ClienteController::class);

        // Rutas de testimonios
        // Route::resource('testimonios', TestimonioController::class);

        // Rutas de promociones
        // Route::resource('promociones', PromocionController::class);

        // Rutas de usuarios/vendedores
        // Route::resource('usuarios', UsuarioController::class);
    });
});

require __DIR__ . '/auth.php';
