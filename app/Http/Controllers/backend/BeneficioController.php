<?php

namespace App\Http\Controllers\backend;

use App\Models\Beneficio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeneficioController extends Controller
{
    public function index()
    {
        $beneficios = Beneficio::all();
        return view('backend.beneficios.index', compact('beneficios'));
    }

    public function create()
    {
        return view('backend.beneficios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:150'
        ]);

        Beneficio::create([
            'nombre' => $request->nombre
        ]);

        return redirect()
        ->route('beneficios.index')
        ->with('success', 'Beneficio creado exitosamente.');
    }

    public function edit($id)
    {
        $beneficio = Beneficio::findOrFail($id);
        return view('backend.beneficios.edit', compact('beneficio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:150'
        ]);

        $beneficio = Beneficio::findOrFail($id);
        $beneficio->update([
            'nombre' => $request->nombre
        ]);

        return redirect()
        ->route('beneficios.index')
        ->with('success', 'Beneficio actualizado exitosamente.');
    }

    public function destroy($id)
    {
        Beneficio::destroy($id);
        return redirect()
        ->route('beneficios.index')
        ->with('success', 'Beneficio eliminado exitosamente.');
    }
}