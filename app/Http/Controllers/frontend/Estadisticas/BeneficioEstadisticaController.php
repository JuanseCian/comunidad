<?php

namespace App\Http\Controllers\frontend\Estadisticas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PersonaBeneficio;
use App\Models\Estadisticas\BeneficioTotal;
use App\Models\Estadisticas\BeneficioPorBarrio;
use App\Exports\BeneficiosExport;
use Maatwebsite\Excel\Facades\Excel;

class BeneficioEstadisticaController extends Controller
{
    public function index(Request $request)
    {
        $beneficioId = $request->get('beneficio_id');
        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');


        $qBeneficios = DB::table('persona_beneficio')
            ->join('beneficios', 'persona_beneficio.beneficio_id', '=', 'beneficios.id')
            ->select('beneficios.nombre as item_name');

        if ($fechaDesde) $qBeneficios->whereDate('persona_beneficio.created_at', '>=', $fechaDesde);
        if ($fechaHasta) $qBeneficios->whereDate('persona_beneficio.created_at', '<=', $fechaHasta);
        if ($beneficioId) $qBeneficios->where('persona_beneficio.beneficio_id', $beneficioId);

        if (!$beneficioId) $qBeneficios->whereNotIn('persona_beneficio.beneficio_id', [1, 2]);

        $qBajoPeso = DB::table('bajo_pesos')
            ->select(DB::raw("'Bajo Peso' as item_name"));

        if ($fechaDesde) $qBajoPeso->whereDate('created_at', '>=', $fechaDesde);
        if ($fechaHasta) $qBajoPeso->whereDate('created_at', '<=', $fechaHasta);
        if ($beneficioId && $beneficioId != 1) $qBajoPeso->whereRaw('1 = 0'); 

        $qMercaderia = DB::table('mercaderias')
            ->select(DB::raw("'Mercadería' as item_name"));

        if ($fechaDesde) $qMercaderia->whereDate('created_at', '>=', $fechaDesde);
        if ($fechaHasta) $qMercaderia->whereDate('created_at', '<=', $fechaHasta);
        if ($beneficioId && $beneficioId != 2) $qMercaderia->whereRaw('1 = 0'); 

        $subQueryBarras = $qBeneficios->unionAll($qBajoPeso)->unionAll($qMercaderia);

        $beneficios = DB::table(DB::raw("({$subQueryBarras->toSql()}) as unificado"))
            ->mergeBindings($subQueryBarras)
            ->select('item_name as nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('item_name')
            ->orderBy('total', 'desc')
            ->get();


        $bBeneficios = DB::table('persona_beneficio')
            ->join('personas', 'persona_beneficio.persona_id', '=', 'personas.id')
            ->join('domicilio', 'personas.domicilio_id', '=', 'domicilio.id')
            ->join('barrio', 'domicilio.barrio_id', '=', 'barrio.id')
            ->select('barrio.nombre as barrio_name');

        if ($fechaDesde) $bBeneficios->whereDate('persona_beneficio.created_at', '>=', $fechaDesde);
        if ($fechaHasta) $bBeneficios->whereDate('persona_beneficio.created_at', '<=', $fechaHasta);
        if ($beneficioId) $bBeneficios->where('persona_beneficio.beneficio_id', $beneficioId);
        if (!$beneficioId) $bBeneficios->whereNotIn('persona_beneficio.beneficio_id', [1, 2]);

        $bBajoPeso = DB::table('bajo_pesos')
            ->join('personas', 'bajo_pesos.persona_id', '=', 'personas.id')
            ->join('domicilio', 'personas.domicilio_id', '=', 'domicilio.id')
            ->join('barrio', 'domicilio.barrio_id', '=', 'barrio.id')
            ->select('barrio.nombre as barrio_name');

        if ($fechaDesde) $bBajoPeso->whereDate('bajo_pesos.created_at', '>=', $fechaDesde);
        if ($fechaHasta) $bBajoPeso->whereDate('bajo_pesos.created_at', '<=', $fechaHasta);
        if ($beneficioId && $beneficioId != 1) $bBajoPeso->whereRaw('1 = 0');

        $bMercaderia = DB::table('mercaderias')
            ->join('personas', 'mercaderias.persona_id', '=', 'personas.id')
            ->join('domicilio', 'personas.domicilio_id', '=', 'domicilio.id')
            ->join('barrio', 'domicilio.barrio_id', '=', 'barrio.id')
            ->select('barrio.nombre as barrio_name');

        if ($fechaDesde) $bMercaderia->whereDate('mercaderias.created_at', '>=', $fechaDesde);
        if ($fechaHasta) $bMercaderia->whereDate('mercaderias.created_at', '<=', $fechaHasta);
        if ($beneficioId && $beneficioId != 2) $bMercaderia->whereRaw('1 = 0');

        $subQueryBarrios = $bBeneficios->unionAll($bBajoPeso)->unionAll($bMercaderia);

        $barrios = DB::table(DB::raw("({$subQueryBarrios->toSql()}) as unificado_barrios"))
            ->mergeBindings($subQueryBarrios)
            ->select('barrio_name as barrio', DB::raw('COUNT(*) as total'))
            ->groupBy('barrio_name')
            ->orderBy('total', 'desc')
            ->get();


        
        $totalBeneficios = $beneficios->sum('total');
        $barrioDestacado = $barrios->first()->barrio ?? 'Sin asignaciones';

        $registroMasCobrado = $beneficios->first(); 
        $beneficioMasCobrado = $registroMasCobrado ? $registroMasCobrado->nombre : 'Sin registros';
        $cantidadMasCobrado = $registroMasCobrado ? $registroMasCobrado->total : 0;

        $listaBeneficios = DB::table('beneficios')->select('id', 'nombre')->get();

        return view('frontend.estadisticas.beneficios.index', compact(
            'beneficios', 
            'barrios', 
            'totalBeneficios', 
            'barrioDestacado', 
            'listaBeneficios',
            'beneficioMasCobrado',
            'cantidadMasCobrado'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new BeneficiosExport(
                $request->get('beneficio_id'),
                $request->get('fecha_desde'),
                $request->get('fecha_hasta')
            ),
            'estadisticas_beneficios.xlsx'
        );
    }
}