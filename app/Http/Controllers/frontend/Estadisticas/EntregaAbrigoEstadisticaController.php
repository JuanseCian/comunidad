<?php

namespace App\Http\Controllers\frontend\Estadisticas;

use App\Exports\EntregasAbrigoExport;
use App\Http\Controllers\Controller;
use App\Models\EntregaAbrigo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EntregaAbrigoEstadisticaController extends Controller
{
    public function index(Request $request)
    {
        $query = EntregaAbrigo::query();
        $this->applyDateFilters($query, $request);

        $totalEntregas = (clone $query)->count();
        $totalColchones = (clone $query)->sum('colchones');
        $totalFrazadas = (clone $query)->sum('frazadas');
        $entregasHoy = (clone $query)->whereDate('fecha_entrega', today())->count();
        $familiasAsistidas = (clone $query)->whereNotNull('familia_id')->distinct()->count('familia_id');

        $mensuales = (clone $query)
            ->selectRaw("DATE_FORMAT(fecha_entrega, '%Y-%m') as periodo, SUM(colchones) as colchones, SUM(frazadas) as frazadas")
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get()
            ->map(fn ($item) => [
                'periodo' => $item->periodo,
                'colchones' => (int) $item->colchones,
                'frazadas' => (int) $item->frazadas,
            ]);

        $ultimasEntregas = (clone $query)
            ->with('usuario')
            ->latest('fecha_entrega')
            ->latest('id')
            ->limit(15)
            ->get();

        return view('frontend.estadisticas.abrigo.index', compact(
            'totalEntregas',
            'totalColchones',
            'totalFrazadas',
            'entregasHoy',
            'familiasAsistidas',
            'mensuales',
            'ultimasEntregas'
        ));
    }

    public function exportExcel()
    {
        return Excel::download(new EntregasAbrigoExport(), 'estadisticas_abrigo.xlsx');
    }

    private function applyDateFilters($query, Request $request): void
    {
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_entrega', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_entrega', '<=', $request->fecha_hasta);
        }
    }
}
