<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;
use App\Models\Mercaderia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\MercaderiasExport;
use Maatwebsite\Excel\Facades\Excel;

class MercaderiaEstadisticaController extends Controller
{
    public function index(Request $request)
    {
        
        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;

        /*
        |--------------------------------------------------------------------------
        | QUERY BASE
        |--------------------------------------------------------------------------
        */
        $query = Mercaderia::query();

        if ($fechaDesde) {
            $query->whereDate('fecha_entrega', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('fecha_entrega', '<=', $fechaHasta);
        }

        /*
        |--------------------------------------------------------------------------
        | TARJETAS PRINCIPALES
        |--------------------------------------------------------------------------
        */
        $totalMercaderias = (clone $query)->count();

        $mercaderiasMes = (clone $query)
            ->whereMonth('fecha_entrega', now()->month)
            ->whereYear('fecha_entrega', now()->year)
            ->count();

        $mercaderiasHoy = (clone $query)
            ->whereDate('fecha_entrega', now())
            ->count();

        $nucleosAsistidos = (clone $query)
            ->whereNotNull('nucleo_conviviente_id')
            ->distinct('nucleo_conviviente_id')
            ->count('nucleo_conviviente_id');

        $ultimasMercaderias = (clone $query)
            ->latest('fecha_entrega')
            ->limit(20)
            ->get();

        $mercaderiasPorMes = Mercaderia::selectRaw('
                MONTH(fecha_entrega) as mes,
                COUNT(*) as total
            ')
            ->whereYear('fecha_entrega', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $labelsMeses = [];
        $datosMeses = [];

        for ($i = 1; $i <= 12; $i++) {

            $labelsMeses[] = Carbon::create()
                ->month($i)
                ->translatedFormat('F');

            $datosMeses[] = $mercaderiasPorMes
                ->firstWhere('mes', $i)
                ?->total ?? 0;
        }


    $mensuales = Mercaderia::selectRaw("
                DATE_FORMAT(fecha_entrega, '%Y-%m') as periodo,
                COUNT(*) as total
            ")
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get();

    /*
    |--------------------------------------------------------------------------
    | USUARIOS CON MÁS ENTREGAS
    |--------------------------------------------------------------------------
    */
    $usuarios = Mercaderia::selectRaw("
            user_id,
            COUNT(*) as total
        ")
        ->with('usuario')
        ->groupBy('user_id')
        ->orderByDesc('total')
        ->limit(6)
        ->get()
        ->map(function ($item) {

            return (object)[
                'username' => $item->usuario->username ?? 'Sistema',
                'total' => $item->total
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | RETORNO VISTA
        |--------------------------------------------------------------------------
        */
        return view(
            'frontend.estadisticas.mercaderias.index',
            compact(
                'totalMercaderias',
                'mercaderiasMes',
                'mercaderiasHoy',
                'nucleosAsistidos',
                'ultimasMercaderias',
                'labelsMeses',
                'datosMeses',
                'fechaDesde',
                'fechaHasta',
                'mensuales',
                'usuarios'
            )
        );
    }

    public function exportExcel()
    {
        return Excel::download(
            new MercaderiasExport(),
            'estadisticas_mercaderias.xlsx'
        );
    }
}