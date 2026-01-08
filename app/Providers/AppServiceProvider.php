<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Auth\CustomUserProvider;
use Illuminate\Support\Facades\View;
use App\Models\ProductoCategoria;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar el custom user provider
        Auth::provider('custom_eloquent', function ($app, array $config) {
            return new CustomUserProvider($app['hash'], $config['model']);
        });

        // Compartir categorías activas con todas las vistas web
        View::composer('web.*', function ($view) {
            $view->with('categoriasGlobal', ProductoCategoria::active()->get());
        });
    }
}
