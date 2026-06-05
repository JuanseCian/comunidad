<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BajoPeso;
use App\Models\BajoPesoEntrega;
use Illuminate\Http\Request;

class BajoPesoEntregaController extends Controller
{
    public function store(Request $request, $id)
    {
        $beneficiario = BajoPeso::findOrFail($id);

        BajoPesoEntrega::create([
            'bajo_peso_id' => $beneficiario->id,
            'fecha' => $request->fecha,
            'cantidad' => $request->cantidad ?? 1,
            'observaciones' => $request->observaciones
        ]);

        return back()->with(
            'success',
            'Entrega registrada correctamente.'
        );
    }

    public function destroy($id)
    {
        BajoPesoEntrega::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Entrega eliminada.'
        );
    }
}