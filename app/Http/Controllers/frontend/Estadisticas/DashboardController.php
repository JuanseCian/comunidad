<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use App\Models\Persona;
use App\Models\Ingreso;
use App\Models\Familia;
use App\Models\Atencion;
use App\Models\PersonaBeneficio;
use App\Models\Mercaderia;

use App\Models\Estadisticas\IngresoMensual;
use App\Models\Estadisticas\BarrioActivo;
use App\Models\Estadisticas\BeneficioTotal;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPersonas = Persona::count();
        $totalIngresos = Ingreso::count();
        $totalFamilias = Familia::count();
        $totalAtenciones = Atencion::count();
        $totalBeneficios = PersonaBeneficio::count();
        $totalMercaderias = Mercaderia::count();
        $ingresosMensuales = IngresoMensual::orderBy('periodo')
            ->get();

        $barriosActivos = BarrioActivo::orderByDesc('total_ingresos')
            ->limit(10)
            ->get();

        $beneficios = BeneficioTotal::orderByDesc('total')
            ->limit(10)
            ->get();

        return view(
            'frontend.estadisticas.dashboard.index',
            compact(
                'totalPersonas',
                'totalIngresos',
                'totalFamilias',
                'totalAtenciones',
                'totalBeneficios',
                'totalMercaderias',

                'ingresosMensuales',
                'barriosActivos',
                'beneficios'
            )
        );
    }
}