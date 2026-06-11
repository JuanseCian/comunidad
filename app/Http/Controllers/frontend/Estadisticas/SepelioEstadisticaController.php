<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SepelioEstadisticaController extends Controller
{
    public function index(Request $request)
    {
        $categoria = $request->get('categoria');
        $tipo = $request->get('tipo');
        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');

        /*
        |--------------------------------------------------------------------------
        | SEPÉLIOS POR CATEGORÍA
        |--------------------------------------------------------------------------
        */

        $categorias = DB::table('sepelios')
            ->select(
                'categoria_servicio as nombre',
                DB::raw('COUNT(*) as total')
            );

        if ($categoria) {
            $categorias->where('categoria_servicio', $categoria);
        }

        if ($tipo) {
            $categorias->where('tipo_sepelio', $tipo);
        }

        if ($fechaDesde) {
            $categorias->whereDate('created_at', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $categorias->whereDate('created_at', '<=', $fechaHasta);
        }

        $categorias = $categorias
            ->groupBy('categoria_servicio')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SEPÉLIOS POR BARRIO
        |--------------------------------------------------------------------------
        */

        $barrios = DB::table('sepelios')
            ->select(
                DB::raw("COALESCE(barrio,'Sin barrio') as barrio"),
                DB::raw('COUNT(*) as total')
            );

        if ($categoria) {
            $barrios->where('categoria_servicio', $categoria);
        }

        if ($tipo) {
            $barrios->where('tipo_sepelio', $tipo);
        }

        if ($fechaDesde) {
            $barrios->whereDate('created_at', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $barrios->whereDate('created_at', '<=', $fechaHasta);
        }

        $barrios = $barrios
            ->groupBy('barrio')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MÉTRICAS
        |--------------------------------------------------------------------------
        */

        $metricas = DB::table('sepelios');

        if ($categoria) {
            $metricas->where('categoria_servicio', $categoria);
        }

        if ($tipo) {
            $metricas->where('tipo_sepelio', $tipo);
        }

        if ($fechaDesde) {
            $metricas->whereDate('created_at', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $metricas->whereDate('created_at', '<=', $fechaHasta);
        }

        $totalSepelios = $metricas->count();

        $costoTotal = (clone $metricas)->sum('costo');

        $categoriaMasUsada = $categorias->first()->nombre ?? 'Sin registros';

        $barrioDestacado = $barrios->first()->barrio ?? 'Sin registros';

        return view('frontend.estadisticas.sepelios.index', compact(
            'categorias',
            'barrios',
            'totalSepelios',
            'costoTotal',
            'categoriaMasUsada',
            'barrioDestacado'
        ));
    }
}