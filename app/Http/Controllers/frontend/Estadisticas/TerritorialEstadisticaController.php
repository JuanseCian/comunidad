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
        // 1. Base Query con los Joins correctos
        $base = DB::table('persona_programa')
            ->join('personas', 'persona_programa.persona_id', '=', 'personas.id')
            ->leftJoin('domicilio', 'personas.domicilio_id', '=', 'domicilio.id')
            ->leftJoin('barrio', 'domicilio.barrio_id', '=', 'barrio.id')
            ->leftJoin('zona_barrio', 'barrio.zona_barrio_id', '=', 'zona_barrio.id');

        /*
        |--------------------------------------------------------------------------
        | FILTROS DINÁMICOS
        |--------------------------------------------------------------------------
        */
        if ($request->filled('programa_id')) {
            $base->where('persona_programa.programa_id', $request->programa_id);
        }

        if ($request->filled('sede_id')) {
            $base->where('persona_programa.sede_id', $request->sede_id);
        }

        if ($request->filled('anio')) {
            $base->whereYear('persona_programa.fecha_inicio', $request->anio);
        }

        if ($request->filled('mes')) {
            $base->whereMonth('persona_programa.fecha_inicio', $request->mes);
        }

        if ($request->filled('barrio_id')) {
            $base->where('domicilio.barrio_id', $request->barrio_id);
        }

        if ($request->filled('zona_id')) {
            $base->where('barrio.zona_barrio_id', $request->zona_id);
        }

        /*
        |--------------------------------------------------------------------------
        | AGRUPAMIENTOS (ZONAS Y BARRIOS)
        |--------------------------------------------------------------------------
        */
        $zonas = (clone $base)
            ->select(
                DB::raw("COALESCE(zona_barrio.nombre, 'Sin zona') as zona"),
                DB::raw('COUNT(*) as total')
            )
            ->groupByRaw("COALESCE(zona_barrio.nombre, 'Sin zona')") // Agrupación estricta
            ->orderByDesc('total')
            ->get();

        $barrios = (clone $base)
            ->select(
                DB::raw("COALESCE(barrio.nombre, 'Sin barrio') as barrio"),
                DB::raw('COUNT(*) as total')
            )
            ->groupByRaw("COALESCE(barrio.nombre, 'Sin barrio')") // Agrupación estricta
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MÉTRICAS Y KPIs
        |--------------------------------------------------------------------------
        */
        $conBarrio = (clone $base)->whereNotNull('domicilio.barrio_id')->count();
        $sinBarrio = (clone $base)->whereNull('domicilio.barrio_id')->count();

        $totalPersonas = (clone $base)->count();

        $totalBarrios = (clone $base)
            ->whereNotNull('domicilio.barrio_id')
            ->distinct('domicilio.barrio_id')
            ->count('domicilio.barrio_id');

        $totalZonas = (clone $base)
            ->whereNotNull('barrio.zona_barrio_id')
            ->distinct('barrio.zona_barrio_id')
            ->count('barrio.zona_barrio_id');

        $barrioActivo = $barrios->where('barrio', '!=', 'Sin barrio')->first()->barrio ?? '-';
        $zonaActiva = $zonas->where('zona', '!=', 'Sin zona')->first()->zona ?? '-';

        $catalogos = [
            'programas' => ProgramasAsistencia::orderBy('nombre')->get(),
            'sedes' => Sede::orderBy('nombre')->get(),
            'listaBarrios' => DB::table('barrio')->orderBy('nombre')->get(),
            'listaZonas' => DB::table('zona_barrio')->orderBy('nombre')->get(),
        ];

        return view('frontend.estadisticas.zonas.index', array_merge([
            'zonas' => $zonas,
            'barrios' => $barrios,
            'conBarrio' => $conBarrio,
            'sinBarrio' => $sinBarrio,
            'totalPersonas' => $totalPersonas,
            'totalBarrios' => $totalBarrios,
            'totalZonas' => $totalZonas,
            'barrioActivo' => $barrioActivo,
            'zonaActiva' => $zonaActiva,
        ], $catalogos));
    }
}