<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use App\Models\Persona;

use App\Models\Estadisticas\DestinatarioPorBarrio;
use App\Models\Estadisticas\DestinatarioPorZona;
use App\Models\Estadisticas\DestinatarioGenero;
use App\Models\Estadisticas\DestinatarioCobertura;

class DestinatarioEstadisticaController extends Controller
{
    public function index()
    {
        $totalDestinatarios = Persona::count();
        $nuevosMes = Persona::whereMonth(
            'created_at',
            now()->month
        )->count();

        $barrios = DestinatarioPorBarrio::orderByDesc('total')
            ->get();
        $zonas = DestinatarioPorZona::orderByDesc('total')
            ->get();
        $generos = DestinatarioGenero::orderByDesc('total')
            ->get();
        $coberturas = DestinatarioCobertura::orderByDesc('total')
            ->get();

        return view(
            'frontend.estadisticas.destinatarios.index',
            compact(
                'totalDestinatarios',
                'nuevosMes',
                'barrios',
                'zonas',
                'generos',
                'coberturas'
            )
        );
    }
}