<?php
/**/
/* use App\Http\Controllers\ProfileController; */
/* use App\Http\Controllers\DashboardController; */
/* use Illuminate\Support\Facades\Route; */
/**/
/* Route::get('/', function () { */
/*     return redirect()->route('login'); */
/* }); */
/**/
/* Route::middleware('auth')->group(function () { */
/*     // Dashboard principal (redirección según rol) */
/*     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); */
/**/
/*     // Perfil de usuario */
/*     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); */
/*     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); */
/*     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); */
/**/
/*     // ============================================ */
/*     // RUTAS PARA SUPERADMIN Y ADMIN */
/*     // ============================================ */
/*     Route::middleware(['role:superadmin,administrador'])->group(function () { */
/*         // Búsqueda de clientes (DEBE IR ANTES del resource) */
/*         Route::get('/clientes/buscar', [\App\Http\Controllers\ClienteController::class, 'buscar'])->name('clientes.buscar'); */
/*     }); */
/**/
/*     // ============================================ */
/*     // RUTAS SOLO PARA SUPERADMIN */
/*     // ============================================ */
/*     Route::middleware(['superadmin'])->group(function () { */
/*         // Rutas de clientes */
/*         Route::resource('clientes', \App\Http\Controllers\ClienteController::class); */
/**/
/*         // Rutas de testimonios */
/*         // Route::resource('testimonios', TestimonioController::class); */
/**/
/*         // Rutas de promociones */
/*         // Route::resource('promociones', PromocionController::class); */
/**/
/*         // Rutas de usuarios/vendedores */
/*         // Route::resource('usuarios', UsuarioController::class); */
/*     }); */
/* }); */
/**/
/* require __DIR__ . '/auth.php'; */





use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapaClienteController;
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

        // 🗺️ RUTAS DEL MAPA DE CLIENTES
        Route::get('/mapa/clientes', [MapaClienteController::class, 'index'])->name('mapa.clientes');
        Route::get('/mapa/cliente/{cliente}', [MapaClienteController::class, 'show'])->name('mapa.cliente');
        Route::post('/mapa/geocode', [MapaClienteController::class, 'geocode'])->name('mapa.geocode');
    });

    // ============================================
    // RUTAS SOLO PARA SUPERADMIN
    // ============================================
    Route::middleware(['superadmin'])->group(function () {
        // Rutas de clientes
        Route::resource('clientes', \App\Http\Controllers\ClienteController::class);

        // Rutas de testimonios
        // Route::resource('testimonios', TestimonioController::class);

        Route::resource('testimonios', \App\Http\Controllers\TestimonioController::class);
        Route::patch('/testimonios/{testimonio}/toggle', [\App\Http\Controllers\TestimonioController::class, 'toggleVisible'])->name('testimonios.toggle');


        // Rutas de promociones
        // Route::resource('promociones', PromocionController::class);

        /* Route::resource('promociones', \App\Http\Controllers\PromocionController::class); */
        Route::resource('promociones', \App\Http\Controllers\PromocionController::class)->parameters([
            'promociones' => 'promocion'
        ]);
        // Rutas de usuarios/vendedores
        // Route::resource('usuarios', UsuarioController::class);
        //
        //
        // 👥 RUTAS DE USUARIOS/VENDEDORES
        Route::get('/usuarios/buscar', [\App\Http\Controllers\UsuarioController::class, 'buscar'])->name('usuarios.buscar');
        Route::patch('/usuarios/{usuario}/toggle-estado', [\App\Http\Controllers\UsuarioController::class, 'toggleEstado'])->name('usuarios.toggle-estado');
        Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class);
    });
});

require __DIR__ . '/auth.php';
