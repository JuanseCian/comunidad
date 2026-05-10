<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProgramasAsistencia;
use App\Models\Persona;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {

            $view->with([

                'programas' => ProgramasAsistencia::orderBy('nombre')->get(),

                'solicitudesPendientes' =>
                    Persona::where('estado', 'pendiente')->count()

            ]);

        });
    }
}