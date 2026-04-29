<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoriaOcupacional;
use Illuminate\Http\Request;

class CategoriaOcupacionalController extends Controller
{
    public function index()
    {
        $categorias = CategoriaOcupacional::all();
        return view('backend.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('backend.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        CategoriaOcupacional::create($request->all());

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría creada correctamente');
    }

    public function edit($id)
    {
        $categoria = CategoriaOcupacional::findOrFail($id);
        return view('backend.categorias.create', compact('categoria')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $categoria = CategoriaOcupacional::findOrFail($id);
        $categoria->update($request->all());

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy($id)
    {
        $categoria = CategoriaOcupacional::findOrFail($id);
        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoría eliminada');
    }
}