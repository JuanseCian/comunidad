<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Familia;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familias = Familia::with([
                'personas',
                'personas.personaPrograma.programa',
                'personas.personaBeneficio.beneficio',
            ])
            ->withCount('personas')
            ->orderBy('codigo')
            ->paginate(20);

        return view(
            'frontend.familias.index',
            compact('familias')
        );
    }
        

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $familia = Familia::with([
            'personas.grupoFamiliar',
            'personas.nucleosConvivientes.miembrosGrupoFamiliar',
            'personas.personaPrograma.programa',
            'personas.personaBeneficio.beneficio',

            'mercaderias.usuario',

            'sepelios.usuario',
            'sepelios.persona',
        ])->findOrFail($id);

        return view(
            'frontend.familias.show',
            compact('familia')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
