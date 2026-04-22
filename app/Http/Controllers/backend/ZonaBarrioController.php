<?php

namespace App\Http\Controllers\backend;

use App\Models\ZonaBarrio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZonaBarrioController extends Controller
{
    public function index()
    {
        $zonas = ZonaBarrio::all();
        return view('backend.zonas.index', compact('zonas'));
    }

    public function create()
    {
        return view('backend.zonas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
        ]);

        ZonaBarrio::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('zonas-barrios.index')
                         ->with('success', 'Zona creada correctamente');
    }

    public function edit($id)
    {
        $zona = ZonaBarrio::findOrFail($id);
        return view('backend.zonas.edit', compact('zona'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:100',
        ]);

        $zona = ZonaBarrio::findOrFail($id);
        $zona->update([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('zonas-barrios.index')
                         ->with('success', 'Zona actualizada');
    }

    public function destroy($id)
    {
        $zona = ZonaBarrio::findOrFail($id);
        $zona->delete();

        return redirect()->route('zonas-barrios.index')
                         ->with('success', 'Zona eliminada');
    }
}