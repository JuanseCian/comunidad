<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enfermedad;

class EnfermedadController extends Controller
{
    public function index()
    {
        $enfermedades = Enfermedad::all();
        return view('backend.enfermedades.index', compact('enfermedades'));
    }

    public function create()
    {
        return view('backend.enfermedades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150',
        ]);

        Enfermedad::create($request->all());

        return redirect()->route('enfermedades.index')->with('success', 'Enfermedad creada');
    }

    public function edit($id)
    {
        $enfermedad = Enfermedad::findOrFail($id);
        return view('backend.enfermedades.edit', compact('enfermedad'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:150',
        ]);

        $enfermedad = Enfermedad::findOrFail($id);
        $enfermedad->update($request->all());

        return redirect()->route('enfermedades.index')->with('success', 'Enfermedad actualizada');
    }

    public function destroy($id)
    {
        $enfermedad = Enfermedad::findOrFail($id);
        $enfermedad->delete();

        return redirect()->route('enfermedades.index')->with('success', 'Enfermedad eliminada');
    }
}