<?php

namespace App\Http\Controllers\backend;

use App\Models\EstadoCivil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstadoCivilController extends Controller
{
    public function index()
    {
        $estados = EstadoCivil::all();
        return view('backend.estados-civiles.index', compact('estados'));
    }

    public function create()
    {
        return view('backend.estados-civiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100'
        ]);

        EstadoCivil::create([
            'nombre' => $request->nombre
        ]);

        return redirect()
        ->route('estados-civiles.index')
        ->with('success', 'Estado civil creado exitosamente.');
    }

    public function edit($id)
    {
        $estado = EstadoCivil::findOrFail($id);
        return view('backend.estados-civiles.edit', compact('estado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:100'
        ]);

        $estado = EstadoCivil::findOrFail($id);
        $estado->update([
            'nombre' => $request->nombre
        ]);

        return redirect()
        ->route('estados-civiles.index')
        ->with('success', 'Estado civil actualizado exitosamente.');
    }

    public function destroy($id)
    {
        EstadoCivil::destroy($id);
        return redirect()
        ->route('estados-civiles.index')
        ->with('success', 'Estado civil eliminado exitosamente.');
    }
}