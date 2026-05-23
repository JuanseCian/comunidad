<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Ingreso;

use App\Models\Estadisticas\IngresoMensual;
use App\Models\Estadisticas\IngresoDiario;
use App\Models\Estadisticas\IngresoPorUsuario;

class IngresoEstadisticaController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->anio ?? now()->year;

        $totalIngresos = Ingreso::count();

        $ingresosHoy = Ingreso::whereDate(
            'fecha_ingreso',
            now()
        )->count();

        $ingresosMes = Ingreso::whereYear(
                'fecha_ingreso',
                $anio
            )
            ->whereMonth(
                'fecha_ingreso',
                now()->month
            )
            ->count();

        $mensuales = IngresoMensual::orderBy('periodo')
            ->get();

        $diarios = IngresoDiario::orderBy('fecha_ingreso')
            ->get();

        $usuarios = IngresoPorUsuario::orderByDesc('total_ingresos')
            ->get();

        $derivaciones = Ingreso::select(
                'derivaciones.nombre',
                DB::raw('COUNT(ingresos.id) as total')
            )
            ->join(
                'derivaciones',
                'ingresos.derivacion_id',
                '=',
                'derivaciones.id'
            )
            ->groupBy(
                'derivaciones.id',
                'derivaciones.nombre'
            )
            ->orderByDesc('total')
            ->get();

        $timeline = Ingreso::with('derivacion')
            ->latest('created_at')
            ->take(15)
            ->get();

        $horas = Ingreso::selectRaw("
                HOUR(hora_ingreso) as hora,
                COUNT(*) as total
            ")
            ->groupBy('hora')
            ->orderBy('hora')
            ->get();

        $topDerivacion = $derivaciones->first();

        return view(
            'frontend.estadisticas.ingresos.index',
            compact(
                'totalIngresos',
                'ingresosHoy',
                'ingresosMes',
                'mensuales',
                'diarios',
                'usuarios',
                'derivaciones',
                'timeline',
                'horas',
                'topDerivacion',
                'anio'
            )
        );
    }
}