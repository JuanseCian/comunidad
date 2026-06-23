<?php

namespace App\Http\Controllers\backend;

use App\Models\ProgramasAsistencia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramaAsistenciaController extends Controller
{
    public function index()
    {
        $programas = ProgramasAsistencia::all();
        return view('backend.programas.index', compact('programas'));
    }

    public function create()
    {
        return view('backend.programas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150'
        ]);

        ProgramasAsistencia::create([
            'nombre' => $request->nombre
        ]);

        return redirect()
        ->route('programas-asistencia.index')
        ->with('success', 'Programa de asistencia creado exitosamente.');
    }

    public function edit($id)
    {
        $programa = ProgramasAsistencia::findOrFail($id);
        return view('backend.programas.edit', compact('programa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:150'
        ]);

        $programa = ProgramasAsistencia::findOrFail($id);
        $programa->update([
            'nombre' => $request->nombre
        ]);

        return redirect()
        ->route('programas-asistencia.index')
        ->with('success', 'Programa de asistencia actualizado exitosamente.');
    }

    public function destroy($id)
    {
        ProgramasAsistencia::destroy($id);
        return redirect()
        ->route('programas-asistencia.index')
        ->with('success', 'Programa de asistencia eliminado exitosamente.');
    }
}