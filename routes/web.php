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




use App\Http\Controllers\WebController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MapaClienteController;
use App\Http\Controllers\ZonaClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::controller(WebController::class)->group(function () {
    Route::get('/', 'home')->name('web.home');
    Route::get('/productos', 'productos')->name('web.productos');
    Route::get('/nosotros', 'nosotros')->name('web.nosotros');
    Route::get('/valores', 'valores')->name('web.valores');
    Route::get('/contacto', 'contacto')->name('web.contacto');
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
        // Gestión de clientes (crear, editar, eliminar) - Vendedor excluido
        Route::resource('clientes', \App\Http\Controllers\ClienteController::class)->except(['index', 'show']);

        // Rutas de testimonios
        Route::resource('testimonios', \App\Http\Controllers\TestimonioController::class);
        Route::patch('/testimonios/{testimonio}/toggle', [\App\Http\Controllers\TestimonioController::class, 'toggleVisible'])->name('testimonios.toggle');

        // Rutas de promociones
        Route::resource('promociones', \App\Http\Controllers\PromocionController::class)->parameters([
            'promociones' => 'promocion'
        ]);

        // Rutas de usuarios (Administrador solo puede ver el index, Superadmin todo en la sección dedicada)
        Route::get('/usuarios', [\App\Http\Controllers\UsuarioController::class, 'index'])->name('usuarios.index');

        // Gestión Dinámica de Productos (Superadmin y Administrador)
        Route::resource('categorias', \App\Http\Controllers\Admin\ProductoCategoriaController::class);
        Route::resource('productos-admin', \App\Http\Controllers\Admin\ProductoController::class)->names([
            'index' => 'productos.admin.index',
            'create' => 'productos.admin.create',
            'store' => 'productos.admin.store',
            'edit' => 'productos.admin.edit',
            'update' => 'productos.admin.update',
            'destroy' => 'productos.admin.destroy',
        ])->parameters([
                    'productos-admin' => 'producto'
                ]);

        // Gestión de Zonas de Clientes
        Route::get('/admin/zonas', [ZonaClienteController::class, 'index'])->name('zonas.index');
        Route::post('/admin/zonas', [ZonaClienteController::class, 'store'])->name('zonas.store');
        Route::patch('/admin/zonas/{id}', [ZonaClienteController::class, 'update'])->name('zonas.update');
        Route::delete('/admin/zonas/{id}', [ZonaClienteController::class, 'destroy'])->name('zonas.destroy');
    });

    // ============================================
    // RUTAS PARA TODOS (SUPERADMIN, ADMIN, VENDEDOR)
    // ============================================
    Route::group([], function () {
        // Rutas de clientes: Solo ver y buscar
        Route::get('/clientes/buscar', [\App\Http\Controllers\ClienteController::class, 'buscar'])->name('clientes.buscar');
        Route::get('/clientes', [\App\Http\Controllers\ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/{cliente}', [\App\Http\Controllers\ClienteController::class, 'show'])->name('clientes.show');

        // 🗺️ RUTAS DEL MAPA DE CLIENTES
        Route::get('/mapa/clientes', [MapaClienteController::class, 'index'])->name('mapa.clientes');
        Route::get('/mapa/cliente/{cliente}', [MapaClienteController::class, 'show'])->name('mapa.cliente');
        Route::post('/mapa/geocode', [MapaClienteController::class, 'geocode'])->name('mapa.geocode');
    });

    // ============================================
    // RUTAS SOLO PARA SUPERADMIN
    // ============================================
    Route::middleware(['superadmin'])->group(function () {
        // Rutas para administrar inicio
        Route::get('/admin/home', [\App\Http\Controllers\AdminHomeController::class, 'edit'])->name('admin.home.edit');
        Route::put('/admin/home', [\App\Http\Controllers\AdminHomeController::class, 'update'])->name('admin.home.update');
        Route::post('/admin/home/upload', [\App\Http\Controllers\AdminHomeController::class, 'upload'])->name('admin.home.upload');
        Route::get('/admin/inicio', [\App\Http\Controllers\AdminHomeController::class, 'edit'])->name('admin.home.edit'); // Alias
        Route::put('/admin/inicio', [\App\Http\Controllers\AdminHomeController::class, 'update'])->name('admin.home.update');

        // Gestión de usuarios (CRUD completo para Superadmin)
        Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class)->except(['index']);
    });

    // API de Zonas (para el mapa, visible para todos los autenticados)
    Route::get('/api/zonas', [ZonaClienteController::class, 'apiIndex'])->name('api.zonas.index');
});

require __DIR__ . '/auth.php';
