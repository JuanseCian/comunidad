<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;
use App\Models\Mercaderia;

class MercaderiaEstadisticaController extends Controller
{
    public function index()
    {
        $totalMercaderias = Mercaderia::count();

        $mercaderiasMes = Mercaderia::whereMonth(
            'fecha_entrega',
            now()->month
        )->whereYear(
            'fecha_entrega',
            now()->year
        )->count();

        $mercaderiasHoy = Mercaderia::whereDate(
            'fecha_entrega',
            now()
        )->count();

        $nucleosAsistidos = Mercaderia::whereNotNull(
            'nucleo_conviviente_id'
        )->distinct(
            'nucleo_conviviente_id'
        )->count(
            'nucleo_conviviente_id'
        );

        $ultimasMercaderias = Mercaderia::latest(
            'fecha_entrega'
        )->limit(20)->get();

        return view(
            'frontend.estadisticas.mercaderias.index',
            compact(
                'totalMercaderias',
                'mercaderiasMes',
                'mercaderiasHoy',
                'nucleosAsistidos',
                'ultimasMercaderias'
            )
        );
    }
}