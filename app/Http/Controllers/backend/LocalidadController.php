<?php

namespace App\Http\Controllers\backend;

use App\Models\Localidad;
use App\Models\Provincia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    public function index()
    {
        $localidades = Localidad::with('provincia')->get();
        return view('backend.localidades.index', compact('localidades'));
    }

    public function create()
    {
        $provincias = Provincia::all();
        return view('backend.localidades.create', compact('provincias'));
    }

    public function store(Request $request)
    {
        Localidad::create($request->all());
        return redirect()
        ->route('localidades.index')
        ->with('success', 'Localidad creada exitosamente.');
    }

    public function edit($id)
    {
        $localidad = Localidad::findOrFail($id);
        $provincias = Provincia::all();
        return view('backend.localidades.edit', compact('localidad', 'provincias'));
    }

    public function update(Request $request, $id)
    {
        $localidad = Localidad::findOrFail($id);
        $localidad->update($request->all());
        return redirect()
        ->route('localidades.index')
        ->with('success', 'Localidad actualizada exitosamente.');
    }

    public function destroy($id)
    {
        Localidad::destroy($id);
        return redirect()
        ->route('localidades.index')
        ->with('success', 'Localidad eliminada exitosamente.');
    }
}
