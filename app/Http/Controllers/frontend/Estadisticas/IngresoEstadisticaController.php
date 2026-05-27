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
        $anio        = $request->anio ?? now()->year;
        $mes         = $request->mes;
        $derivacion  = $request->derivacion;


        $query = Ingreso::query();

        $query->whereYear('fecha_ingreso', $anio);

        if ($mes) {
            $query->whereMonth('fecha_ingreso', $mes);
        }

        if ($derivacion) {
            $query->where('derivacion_id', $derivacion);
        }

        $totalIngresos = (clone $query)->count();

        $ingresosHoy = (clone $query)
            ->whereDate('fecha_ingreso', now())
            ->count();

        $ingresosMes = (clone $query)
            ->whereMonth('fecha_ingreso', now()->month)
            ->count();

        $mensuales = (clone $query)
            ->selectRaw("
                MONTH(fecha_ingreso) as numero_mes,
                DATE_FORMAT(fecha_ingreso, '%b') as periodo,
                COUNT(*) as total
            ")
            ->groupBy('numero_mes', 'periodo')
            ->orderBy('numero_mes')
            ->get();

        $diarios = (clone $query)
            ->selectRaw("
                DATE(fecha_ingreso) as fecha_ingreso,
                COUNT(*) as total
            ")
            ->groupBy('fecha_ingreso')
            ->orderBy('fecha_ingreso')
            ->get();

        $usuarios = (clone $query)
            ->join('users', 'ingresos.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.username',
                DB::raw('COUNT(ingresos.id) as total_ingresos')
            )
            ->groupBy('users.id', 'users.username')
            ->orderByDesc('total_ingresos')
            ->get();

        $derivaciones = Ingreso::join(
                'derivaciones',
                'ingresos.derivacion_id',
                '=',
                'derivaciones.id'
            )
            ->select(
                'derivaciones.id',
                'derivaciones.nombre',
                DB::raw('COUNT(ingresos.id) as total')
            )
            ->groupBy(
                'derivaciones.id',
                'derivaciones.nombre'
            )
            ->orderByDesc('total')
            ->get();

        $timeline = (clone $query)
            ->with('derivacion')
            ->latest('created_at')
            ->take(15)
            ->get();
        $horas = (clone $query)
            ->selectRaw("
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