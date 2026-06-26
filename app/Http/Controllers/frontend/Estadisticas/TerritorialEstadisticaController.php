<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;
use App\Models\ProgramasAsistencia;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TerritorialEstadisticaController extends Controller
{
    public function index(Request $request)
    {
        $base = DB::table('persona_programa')
            ->join(
                'personas',
                'persona_programa.persona_id',
                '=',
                'personas.id'
            )
            ->leftJoin(
                'domicilio',
                'personas.domicilio_id',
                '=',
                'domicilio.id'
            )
            ->leftJoin(
                'barrio',
                'domicilio.barrio_id',
                '=',
                'barrio.id'
            )
            ->leftJoin(
                'zona_barrio',
                'barrio.zona_barrio_id',
                '=',
                'zona_barrio.id'
            );

        /*
        |--------------------------------------------------------------------------
        | FILTROS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('programa_id')) {
            $base->where(
                'persona_programa.programa_id',
                $request->programa_id
            );
        }

        if ($request->filled('sede_id')) {
            $base->where(
                'persona_programa.sede_id',
                $request->sede_id
            );
        }

        if ($request->filled('anio')) {
            $base->whereYear(
                'persona_programa.fecha_inicio',
                $request->anio
            );
        }

        if ($request->filled('mes')) {
            $base->whereMonth(
                'persona_programa.fecha_inicio',
                $request->mes
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ZONAS
        |--------------------------------------------------------------------------
        */

        $zonas = (clone $base)
            ->select(
                DB::raw("
                    COALESCE(
                        zona_barrio.nombre,
                        'Sin zona'
                    ) as zona
                "),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('zona')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | BARRIOS
        |--------------------------------------------------------------------------
        */

        $barrios = (clone $base)
            ->select(
                DB::raw("
                    COALESCE(
                        barrio.nombre,
                        'Sin barrio'
                    ) as barrio
                "),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('barrio')
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | COBERTURA
        |--------------------------------------------------------------------------
        */

        $conBarrio = (clone $base)
            ->whereNotNull('domicilio.barrio_id')
            ->count();

        $sinBarrio = (clone $base)
            ->whereNull('domicilio.barrio_id')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | KPIs
        |--------------------------------------------------------------------------
        */

        $totalPersonas = (clone $base)->count();

        $totalBarrios = (clone $base)
            ->whereNotNull('domicilio.barrio_id')
            ->distinct('domicilio.barrio_id')
            ->count();

        $totalZonas = (clone $base)
            ->whereNotNull('barrio.zona_barrio_id')
            ->distinct('barrio.zona_barrio_id')
            ->count();

        $barrioActivo = $barrios->first()->barrio ?? '-';

        $zonaActiva = $zonas->first()->zona ?? '-';

        return view(
            'frontend.estadisticas.zonas.index',
            [
                'zonas' => $zonas,
                'barrios' => $barrios,
                'conBarrio' => $conBarrio,
                'sinBarrio' => $sinBarrio,
                'totalPersonas' => $totalPersonas,
                'totalBarrios' => $totalBarrios,
                'totalZonas' => $totalZonas,
                'barrioActivo' => $barrioActivo,
                'zonaActiva' => $zonaActiva,
                'programas' => ProgramasAsistencia::orderBy('nombre')->get(),
                'sedes' => Sede::orderBy('nombre')->get(),
            ]
        );
    }
}