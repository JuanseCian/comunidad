<?php

namespace App\Http\Controllers\Frontend\Estadisticas;

use App\Http\Controllers\Controller;

use App\Models\Atencion;

use App\Models\Estadisticas\AtencionMensual;
use App\Models\Estadisticas\AtencionPorUsuario;
use App\Models\Estadisticas\TipoAtencion;

class AtencionEstadisticaController extends Controller
{
    public function index()
    {
        $totalAtenciones = Atencion::count();

        $atencionesMes = Atencion::whereMonth(
            'fecha_atencion',
            now()->month
        )->count();

        $mensuales = AtencionMensual::orderBy('periodo')
            ->get();

        $usuarios = AtencionPorUsuario::orderByDesc('total')
            ->get();

        $tipos = TipoAtencion::orderByDesc('total')
            ->get();

        return view(
            'frontend.estadisticas.atenciones.index',
            compact(
                'totalAtenciones',
                'atencionesMes',

                'mensuales',
                'usuarios',
                'tipos'
            )
        );
    }
}