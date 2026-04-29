<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CondicionInactividad;
use Illuminate\Http\Request;

class CondicionInactividadController extends Controller
{
    public function index()
    {
        $condiciones = CondicionInactividad::all();
        return view('backend.condiciones_inactividad.index', compact('condiciones'));
    }

    public function create()
    {
        return view('backend.condiciones_inactividad.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        CondicionInactividad::create($request->all());
        return redirect()->route('condiciones-inactividad.index');
    }

    public function edit(CondicionInactividad $condicion_inactividad)
    {
        return view('backend.condiciones_inactividad.edit', compact('condicion_inactividad'));
    }

    public function update(Request $request, CondicionInactividad $condicion_inactividad)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        $condicion_inactividad->update($request->all());
        return redirect()->route('condiciones-inactividad.index');
    }

    public function destroy(CondicionInactividad $condicion_inactividad)
    {
        $condicion_inactividad->delete();
        return redirect()->route('condiciones-inactividad.index');
    }
}