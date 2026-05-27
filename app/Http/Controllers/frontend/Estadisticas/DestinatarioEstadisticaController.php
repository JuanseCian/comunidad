<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;

class DestinatarioEstadisticaController extends Controller
{
    public function index()
    {
        $totalDestinatarios = Persona::count();

        $nuevosMes = Persona::whereMonth(
            'created_at',
            now()->month
        )->count();

        $barrios = Persona::select(
            'barrio.nombre as nombre',
            DB::raw('COUNT(personas.id) as total')
        )
        ->join(
            'domicilio',
            'personas.domicilio_id',
            '=',
            'domicilio.id'
        )
        ->join(
            'barrio',
            'domicilio.barrio_id',
            '=',
            'barrio.id'
        )
        ->groupBy(
            'barrio.id',
            'barrio.nombre'
        )
        ->orderByDesc('total')
        ->get();

    $zonas = Persona::select(
            'zona_barrio.nombre as nombre',
            DB::raw('COUNT(personas.id) as total')
        )
        ->join(
            'domicilio',
            'personas.domicilio_id',
            '=',
            'domicilio.id'
        )
        ->join(
            'barrio',
            'domicilio.barrio_id',
            '=',
            'barrio.id'
        )
        ->join(
            'zona_barrio',
            'barrio.zona_barrio_id',
            '=',
            'zona_barrio.id'
        )
        ->groupBy(
            'zona_barrio.id',
            'zona_barrio.nombre'
        )
        ->orderByDesc('total')
        ->get();

        $generos = Persona::select(
                DB::raw("COALESCE(sexo.nombre, 'Sin género') as nombre"),
                DB::raw('COUNT(personas.id) as total')
            )
            ->leftJoin(
                'sexo',
                'personas.sexo_id',
                '=',
                'sexo.id'
            )
            ->groupBy('nombre')
            ->orderByDesc('total')
            ->get();

        $coberturas = Persona::select(
                DB::raw("COALESCE(cobertura.nombre, 'Sin cobertura') as nombre"),
                DB::raw('COUNT(personas.id) as total')
            )
            ->leftJoin(
                'cobertura',
                'personas.cobertura_id',
                '=',
                'cobertura.id'
            )
            ->groupBy('nombre')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topBarrio = $barrios->first();
        $topZona = $zonas->first();
        $topGenero = $generos->first();

        return view(
            'frontend.estadisticas.destinatarios.index',
            compact(
                'totalDestinatarios',
                'nuevosMes',
                'barrios',
                'zonas',
                'generos',
                'coberturas',
                'topBarrio',
                'topZona',
                'topGenero'
            )
        );
    }
}