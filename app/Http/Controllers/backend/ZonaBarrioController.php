<?php

namespace App\Http\Controllers\backend;

use App\Models\ZonaBarrio;
use App\Models\Localidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ZonaBarrioController extends Controller
{
    public function index()
    {
        $zonas = ZonaBarrio::with('localidad')->get();
        return view('backend.zonas.index', compact('zonas'));
    }

    public function create()
    {
        $localidades = Localidad::all();
        return view('backend.zonas.create', compact('localidades'));
    }

    public function store(Request $request)
    {
        ZonaBarrio::create($request->all());
        return redirect()->route('zonas-barrios.index');
    }

    public function edit($id)
    {
        $zona = ZonaBarrio::findOrFail($id);
        $localidades = Localidad::all();
        return view('backend.zonas.edit', compact('zona', 'localidades'));
    }

    public function update(Request $request, $id)
    {
        $zona = ZonaBarrio::findOrFail($id);
        $zona->update($request->all());
        return redirect()->route('zonas-barrios.index');
    }

    public function destroy($id)
    {
        ZonaBarrio::destroy($id);
        return redirect()->route('zonas-barrios.index');
    }
}
