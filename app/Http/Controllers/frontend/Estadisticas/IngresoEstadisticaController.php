<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use App\Models\Ingreso;

use App\Models\Estadisticas\IngresoMensual;
use App\Models\Estadisticas\IngresoDiario;
use App\Models\Estadisticas\IngresoPorUsuario;
use App\Models\Estadisticas\IngresoPorDerivacion;

class IngresoEstadisticaController extends Controller
{
    public function index()
    {
        $totalIngresos = Ingreso::count();
        $ingresosHoy = Ingreso::whereDate(
            'fecha_ingreso',
            now()
        )->count();

        $ingresosMes = Ingreso::whereMonth(
            'fecha_ingreso',
            now()->month
        )->count();

        $mensuales = IngresoMensual::orderBy('periodo')
            ->get();
        $diarios = IngresoDiario::orderBy('fecha_ingreso')
            ->get();
        $usuarios = IngresoPorUsuario::orderByDesc('total_ingresos')
            ->get();
        $derivaciones = IngresoPorDerivacion::orderByDesc('total')
            ->get();

        return view(
            'frontend.estadisticas.ingresos.index',
            compact(
                'totalIngresos',
                'ingresosHoy',
                'ingresosMes',

                'mensuales',
                'diarios',
                'usuarios',
                'derivaciones'
            )
        );
    }
}