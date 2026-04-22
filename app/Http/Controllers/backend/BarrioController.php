<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barrio;
use App\Models\Localidad;
use App\Models\ZonaBarrio; 

class BarrioController extends Controller
{
    public function index()
    {
        $barrios = Barrio::all();
        $localidades = Localidad::all();
        $zonas = ZonaBarrio::all(); 

        return view('backend.barrios.index', compact('barrios', 'localidades', 'zonas'));
    }

    public function create()
    {
        $localidades = Localidad::all();
        $zonas = ZonaBarrio::all(); 

        return view('backend.barrios.create', compact('localidades', 'zonas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:30',
            'localidad_id' => 'required',
            'zona_barrio_id' => 'required',
        ]);

        Barrio::create($request->all());

        return redirect()->route('barrios.index')->with('success', 'Barrio creado');
    }

    public function edit($id)
    {
        $barrio = Barrio::findOrFail($id);
        $localidades = Localidad::all();
        $zonas = ZonaBarrio::all(); 

        return view('backend.barrios.edit', compact('barrio', 'localidades', 'zonas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:30',
            'localidad_id' => 'required',
            'zona_barrio_id' => 'required',
        ]);

        $barrio = Barrio::findOrFail($id);
        $barrio->update($request->all());

        return redirect()->route('barrios.index')->with('success', 'Barrio actualizado');
    }

    public function destroy($id)
    {
        $barrio = Barrio::findOrFail($id);
        $barrio->delete();

        return redirect()->route('barrios.index')->with('success', 'Barrio eliminado');
    }
}