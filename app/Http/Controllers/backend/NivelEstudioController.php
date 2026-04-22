<?php

namespace App\Http\Controllers\backend;

use App\Models\NivelesEstudio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NivelEstudioController extends Controller
{
    public function index()
    {
        $niveles = NivelesEstudio::all();
        return view('backend.niveles-estudio.index', compact('niveles'));
    }

    public function create()
    {
        return view('backend.niveles-estudio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100'
        ]);

        NivelesEstudio::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('niveles-estudio.index');
    }

    public function edit($id)
    {
        $nivel = NivelesEstudio::findOrFail($id);
        return view('backend.niveles-estudio.edit', compact('nivel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:100'
        ]);

        $nivel = NivelesEstudio::findOrFail($id);
        $nivel->update([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('niveles-estudio.index');
    }

    public function destroy($id)
    {
        NivelesEstudio::destroy($id);
        return redirect()->route('niveles-estudio.index');
    }
}