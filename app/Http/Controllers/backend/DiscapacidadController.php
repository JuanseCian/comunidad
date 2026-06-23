<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Discapacidad;
use Illuminate\Http\Request;

class DiscapacidadController extends Controller
{
    public function index()
    {
        $discapacidades = Discapacidad::all();
        return view('backend.discapacidades.index', compact('discapacidades'));
    }

    public function create()
    {
        return view('backend.discapacidades.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        Discapacidad::create($request->all());
        return redirect()
        ->route('discapacidades.index')
        ->with('success', 'Discapacidad creada exitosamente.');
    }

    public function edit(Discapacidad $discapacidad)
    {
        return view('backend.discapacidades.edit', compact('discapacidad'));
    }

    public function update(Request $request, Discapacidad $discapacidad)
    {
        $request->validate(['nombre' => 'required|string|max:100']);
        $discapacidad->update($request->all());
        return redirect()
        ->route('discapacidades.index')
        ->with('success', 'Discapacidad actualizada exitosamente.');
    }

    public function destroy(Discapacidad $discapacidad)
    {
        $discapacidad->delete();
        return redirect()
        ->route('discapacidades.index')
        ->with('success', 'Discapacidad eliminada exitosamente.');
    }
}