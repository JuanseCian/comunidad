<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use App\Models\Estadisticas\BarrioActivo;
use App\Models\Estadisticas\ZonaActiva;

class TerritorialEstadisticaController extends Controller
{
    public function index()
    {
        $barrios = BarrioActivo::orderByDesc('total_ingresos')
            ->get();

        $zonas = ZonaActiva::orderByDesc('total')
            ->get();

        return view(
            'frontend.estadisticas.zonas.index',
            compact(
                'barrios',
                'zonas'
            )
        );
    }
}