<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use App\Models\Familia;

use App\Models\Estadisticas\FamiliaPorBarrio;
use App\Models\Estadisticas\PromedioGrupoFamiliar;

class FamiliaEstadisticaController extends Controller
{
    public function index()
    {
        $totalFamilias = Familia::count();
        $familias = FamiliaPorBarrio::orderByDesc('total')
            ->get();
        $promedios = PromedioGrupoFamiliar::orderByDesc('integrantes')
            ->get();

        return view(
            'frontend.estadisticas.familias.index',
            compact(
                'totalFamilias',
                'familias',
                'promedios'
            )
        );
    }
}