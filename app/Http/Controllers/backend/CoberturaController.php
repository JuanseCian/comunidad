<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cobertura;
use Illuminate\Http\Request;

class CoberturaController extends Controller
{
    public function index()
    {
        $coberturas = Cobertura::all();
        return view('backend.coberturas.index', compact('coberturas'));
    }

    public function create()
    {
        return view('backend.coberturas.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        Cobertura::create($request->all());
        return redirect()->route('coberturas.index')->with('success', 'Registro creado.');
    }

    public function edit(Cobertura $cobertura)
    {
        return view('backend.coberturas.edit', compact('cobertura'));
    }

    public function update(Request $request, Cobertura $cobertura)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        $cobertura->update($request->all());
        return redirect()->route('coberturas.index')->with('success', 'Registro actualizado.');
    }

    public function destroy(Cobertura $cobertura)
    {
        $cobertura->delete();
        return redirect()->route('coberturas.index')->with('success', 'Registro eliminado.');
    }
}