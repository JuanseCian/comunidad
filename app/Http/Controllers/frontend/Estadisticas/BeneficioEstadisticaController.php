<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use App\Models\PersonaBeneficio;

use App\Models\Estadisticas\BeneficioTotal;
use App\Models\Estadisticas\BeneficioPorBarrio;

class BeneficioEstadisticaController extends Controller
{
    public function index()
    {
        $totalBeneficios = PersonaBeneficio::count();
        $beneficios = BeneficioTotal::orderByDesc('total')
            ->get();
        $barrios = BeneficioPorBarrio::orderByDesc('total')
            ->get();

        return view(
            'frontend.estadisticas.beneficios.index',
            compact(
                'totalBeneficios',
                'beneficios',
                'barrios'
            )
        );
    }
}