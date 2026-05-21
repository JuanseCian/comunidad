<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use App\Models\Mercaderia;

class MercaderiaEstadisticaController extends Controller
{
    public function index()
    {
        $totalMercaderias = Mercaderia::count();
        $mercaderiasActivas = Mercaderia::where(
            'estado',
            'activa'
        )->count();

        $mercaderiasRetiradas = Mercaderia::where(
            'estado',
            'retirada'
        )->count();

        $mercaderiasVencidas = Mercaderia::where(
            'estado',
            'vencida'
        )->count();

        $ultimasMercaderias = Mercaderia::latest()
            ->limit(20)
            ->get();

        return view(
            'frontend.estadisticas.mercaderias.index',
            compact(
                'totalMercaderias',
                'mercaderiasActivas',
                'mercaderiasRetiradas',
                'mercaderiasVencidas',

                'ultimasMercaderias'
            )
        );
    }
}