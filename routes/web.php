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
    // RUTAS SOLO PARA SUPERADMIN
    // ============================================
    Route::middleware(['superadmin'])->group(function () {
        // Rutas de clientes
        // Route::resource('clientes', ClienteController::class);

        // Rutas de testimonios
        // Route::resource('testimonios', TestimonioController::class);

        // Rutas de promociones
        // Route::resource('promociones', PromocionController::class);

        // Rutas de usuarios/vendedores
        // Route::resource('usuarios', UsuarioController::class);
    });

    // ============================================
    // RUTAS PARA SUPERADMIN Y ADMIN
    // ============================================
    Route::middleware(['role:superadmin,administrador'])->group(function () {
        // Búsqueda de clientes
        // Route::get('/clientes/buscar', [ClienteController::class, 'buscar'])->name('clientes.buscar');
    });
});

require __DIR__ . '/auth.php';
