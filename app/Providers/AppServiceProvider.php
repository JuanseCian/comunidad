<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        view()->composer('frontend.layout.tu_vista_panel', function ($view) {
            $view->with('solicitudesPendientes', \App\Models\Persona::where('estado', 'pendiente')->count());
        });
    }
}
