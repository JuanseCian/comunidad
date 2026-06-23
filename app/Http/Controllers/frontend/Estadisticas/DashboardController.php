<?php

namespace App\Http\Controllers\frontend\Estadisticas;
use App\Http\Controllers\Controller;

use App\Models\Persona;
use App\Models\Ingreso;
use App\Models\Familia;
use App\Models\Atencion;
use App\Models\PersonaBeneficio;
use App\Models\Mercaderia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Estadisticas\IngresoMensual;
use App\Models\Estadisticas\BarrioActivo;
use App\Models\Estadisticas\BeneficioTotal;

use App\Models\PersonaPrograma;
use App\Exports\DashboardExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');

        $ingresoQuery = Ingreso::query();
        $atencionQuery = Atencion::query();
        $beneficioQuery = PersonaBeneficio::query();
        $mercaderiaQuery = Mercaderia::query();
        $programaQuery = PersonaPrograma::query();

        if ($fechaDesde) {
            $ingresoQuery->whereDate('fecha_ingreso', '>=', $fechaDesde);
            $atencionQuery->whereDate('fecha_atencion', '>=', $fechaDesde);
            $beneficioQuery->whereDate('created_at', '>=', $fechaDesde);
            $mercaderiaQuery->whereDate('fecha_entrega', '>=', $fechaDesde);
            $programaQuery->whereDate('fecha_inicio', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $ingresoQuery->whereDate('fecha_ingreso', '<=', $fechaHasta);
            $atencionQuery->whereDate('fecha_atencion', '<=', $fechaHasta);
            $beneficioQuery->whereDate('created_at', '<=', $fechaHasta);
            $mercaderiaQuery->whereDate('fecha_entrega', '<=', $fechaHasta);
            $programaQuery->whereDate('fecha_inicio', '<=', $fechaHasta);
        }

        $totalPersonas = Persona::count();
        $totalIngresos = $ingresoQuery->count();
        $totalFamilias = Familia::count();
        $totalAtenciones = $atencionQuery->count();
        $totalBeneficios = $beneficioQuery->count();
        $totalMercaderias = $mercaderiaQuery->count();

        $totalProgramasActivos = (clone $programaQuery)->where('activo', 1)->count();
        $personasConProgramas = (clone $programaQuery)->where('activo', 1)
            ->distinct()
            ->count('persona_id');

        $totalBeneficiosActivos = (clone $beneficioQuery)->where('activo', 1)->count();
        $personasConBeneficios = (clone $beneficioQuery)->where('activo', 1)
            ->distinct()
            ->count('persona_id');

        $programasActivos = (clone $programaQuery)
            ->where('activo', 1)
            ->join('programas_asistencia', 'persona_programa.programa_id', '=', 'programas_asistencia.id')
            ->select('programas_asistencia.nombre', DB::raw('COUNT(DISTINCT persona_programa.persona_id) as total'))
            ->groupBy('programas_asistencia.nombre')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $beneficiosActivos = (clone $beneficioQuery)
            ->where('activo', 1)
            ->join('beneficios', 'persona_beneficio.beneficio_id', '=', 'beneficios.id')
            ->select('beneficios.nombre', DB::raw('COUNT(persona_beneficio.id) as total'))
            ->groupBy('beneficios.nombre')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $ingresosMensuales = Ingreso::selectRaw("DATE_FORMAT(fecha_ingreso, '%Y-%m') as periodo, COUNT(*) as total")
            ->when($fechaDesde, fn($query) => $query->whereDate('fecha_ingreso', '>=', $fechaDesde))
            ->when($fechaHasta, fn($query) => $query->whereDate('fecha_ingreso', '<=', $fechaHasta))
            ->groupBy('periodo')
            ->orderBy('periodo')
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
                'totalProgramasActivos',
                'personasConProgramas',
                'totalBeneficiosActivos',
                'personasConBeneficios',
                'programasActivos',
                'beneficiosActivos',
                'fechaDesde',
                'fechaHasta',

                'ingresosMensuales',
                'barriosActivos',
                'beneficios'
            )
        );
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new DashboardExport(
                $request->get('fecha_desde'),
                $request->get('fecha_hasta')
            ),
            'dashboard_estadisticas.xlsx'
        );
    }
}