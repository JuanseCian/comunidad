<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Atencion;
use App\Models\User;
use App\Exports\AtencionesExport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use DB;

class AtencionEstadisticaController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->anio ?? now()->year;
        $mes  = $request->mes;
        $tipo = $request->tipo;
        $vista = $request->vista ?? 'mes';

        $query = Atencion::query()
            ->with(['persona', 'users']);

        $query->whereYear('fecha_atencion', $anio);

        if ($mes) {
            $query->whereMonth('fecha_atencion', $mes);
        }

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        $totalAtenciones = (clone $query)->count();

        $atencionesMes = Atencion::whereMonth(
            'fecha_atencion',
            now()->month
        )->count();

        $atencionesHoy = Atencion::whereDate(
            'fecha_atencion',
            today()
        )->count();

        $tiposMasUsados = (clone $query)
            ->select(
                'tipo',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('tipo')
            ->orderByDesc('total')
            ->get();

        $usuarios = (clone $query)
            ->select(
                'usuario_id',
                DB::raw('COUNT(*) as total')
            )
            ->with('users')
            ->groupBy('usuario_id')
            ->orderByDesc('total')
            ->get();

        if ($vista === 'dia') {

            $timeline = (clone $query)
                ->selectRaw("
                    DATE(fecha_atencion) as periodo,
                    COUNT(*) as total
                ")
                ->groupBy('periodo')
                ->orderBy('periodo')
                ->get();

        } elseif ($vista === 'semana') {

            $timeline = (clone $query)
                ->selectRaw("
                    YEARWEEK(fecha_atencion, 1) as periodo,
                    COUNT(*) as total
                ")
                ->groupBy('periodo')
                ->orderBy('periodo')
                ->get();

        } elseif ($vista === 'anio') {

            $timeline = (clone $query)
                ->selectRaw("
                    YEAR(fecha_atencion) as periodo,
                    COUNT(*) as total
                ")
                ->groupBy('periodo')
                ->orderBy('periodo')
                ->get();

        } else {

            $timeline = (clone $query)
                ->selectRaw("
                    DATE_FORMAT(fecha_atencion, '%Y-%m') as periodo,
                    COUNT(*) as total
                ")
                ->groupBy('periodo')
                ->orderBy('periodo')
                ->get();
        }

        $ultimasAtenciones = (clone $query)
            ->latest('fecha_atencion')
            ->take(10)
            ->get();

        return view(
            'frontend.estadisticas.atenciones.index',
            compact(
                'totalAtenciones',
                'atencionesMes',
                'atencionesHoy',
                'tiposMasUsados',
                'usuarios',
                'timeline',
                'ultimasAtenciones',
                'anio',
                'mes',
                'tipo',
                'vista'
            )
        );
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new AtencionesExport(
                $request->get('anio'),
                $request->get('mes'),
                $request->get('tipo')
            ),
            'estadisticas_intervenciones.xlsx'
        );
    }
}
