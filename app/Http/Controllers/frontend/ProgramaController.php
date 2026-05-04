<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\ProgramasAsistencia;

class ProgramaController extends Controller
{
    public function show($id)
    {
        $programa = ProgramasAsistencia::with('personas')->findOrFail($id);

        return view('frontend.programas.show', compact('programa'));
    }
}
