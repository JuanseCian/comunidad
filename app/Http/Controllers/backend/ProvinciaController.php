<?php

namespace App\Http\Controllers\backend;

use App\Models\Provincia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    public function index()
    {
        $provincias = Provincia::all();
        return view('backend.provincias.index', compact('provincias'));
    }

    public function create()
    {
        return view('backend.provincias.create');
    }

    public function store(Request $request)
    {
        Provincia::create($request->all());
        return redirect()
        ->route('provincias.index')
        ->with('success', 'Provincia creada exitosamente.');
    }

    public function edit($id)
    {
        $provincia = Provincia::findOrFail($id);
        return view('backend.provincias.edit', compact('provincia'));
    }

    public function update(Request $request, $id)
    {
        $provincia = Provincia::findOrFail($id);
        $provincia->update($request->all());
        return redirect()
        ->route('provincias.index')
        ->with('success', 'Provincia actualizada exitosamente.');
    }

    public function destroy($id)
    {
        Provincia::destroy($id);
        return redirect()
        ->route('provincias.index')
        ->with('success', 'Provincia eliminada exitosamente.');
    }
}
