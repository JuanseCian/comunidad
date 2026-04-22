<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\TipoDocumento;
use App\Models\Sexo;
use App\Models\NivelesEstudio;
use App\Models\Provincia;
use App\Models\Barrio;
use App\Models\Sede;
use App\Models\Domicilio;
use App\Models\EstadoCivil;
use App\Models\localidad;

class PersonaController extends Controller
{
   public function index(Request $request)
    {
        $query = Persona::with([
            'tipoDocumento',
            'sexo',
            'localidad',
            'domicilio.barrio',
            'sedeOrigen',
            'grupoFamiliar',
        ]);
 
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sql) use ($q) {
                $sql->where('nombre',   'like', "%{$q}%")
                    ->orWhere('apellido', 'like', "%{$q}%")
                    ->orWhere('dni',      'like', "%{$q}%");
            });
        }
 
        if ($request->filled('sede_id')) {
            $query->where('sede_origen_id', $request->sede_id);
        }
 
        if ($request->filled('barrio_id')) {
            $query->whereHas('domicilio', function ($sql) use ($request) {
                $sql->where('barrio_id', $request->barrio_id);
            });
        }
 
        $personas = $query->orderBy('apellido')->orderBy('nombre')->paginate(20)->withQueryString();
        $sedes    = Sede::orderBy('nombre')->get();
        $barrios  = Barrio::orderBy('nombre')->get();
 
        return view('frontend.persona.index', compact('personas', 'sedes', 'barrios'));
    }
    public function create()
    {
        return view('frontend.persona.create', [
            'tipos_doc'  => TipoDocumento::orderBy('nombre')->get(),
            'sexos'      => Sexo::orderBy('nombre')->get(),
            'niveles'    => NivelesEstudio::orderBy('nombre')->get(),
            'provincias' => Provincia::orderBy('nombre')->get(),
            'barrios'    => Barrio::orderBy('nombre')->get(),
            'sedes'      => Sede::orderBy('nombre')->get(),
            'estados_civiles' => EstadoCivil::all(),
            'provincias' => Provincia::all(),
            'localidades' => Localidad::all(),

        ]);
    }

  public function store(Request $request)
{
    $request->validate([
        'nombre'            => 'required|string|max:255',
        'apellido'          => 'required|string|max:255',
        'dni'               => 'required',
        'cuil'              => 'nullable|string|max:20',
        'estado_civil_id'   => 'nullable|exists:estado_civil,id',
        'provincia_id'      => 'nullable|exists:provincia,id',
        'localidad_id'      => 'nullable|exists:localidad,id',
    ]);

    $domicilio_id = null;

    if ($request->filled('barrio_id') || $request->filled('calle')) {
        $domicilio = Domicilio::create([
            'barrio_id' => $request->barrio_id,
            'calle'     => $request->calle,
            'numero'    => $request->numero,
            'piso'      => $request->piso,
            'dpto'      => $request->dpto,
        ]);

        $domicilio_id = $domicilio->id;
    }

    Persona::create([
        'nombre'              => $request->nombre,
        'apellido'            => $request->apellido,
        'correo'              => $request->correo,
        'fecha_nacimiento'    => $request->fecha_nacimiento,
        'documento_id'        => $request->documento_id,
        'dni'                 => $request->dni,
        'cuil'                => $request->cuil,
        'sexo_id'             => $request->sexo_id,
        'domicilio_id'        => $domicilio_id,

        'provincia_id'        => $request->provincia_id,
        'localidad_id'        => $request->localidad_id,

        'telefono'            => $request->telefono,
        'nivel_estudio_id'    => $request->nivel_estudio_id,
        'estado_civil_id'     => $request->estado_civil_id,
        'trabaja'             => $request->trabaja ? 1 : 0,
        'grupo_sanguineo'     => $request->grupo_sanguineo,
        'sede_origen_id'      => $request->sede_origen_id,
    ]);

    return redirect()
        ->route('personas.create')
        ->with('success', 'Persona registrada correctamente');
}
public function show($id)
{
    $persona = Persona::with([
        'domicilio.barrio',
        'provincia',
        'localidad',
        'estadoCivil',
        'sexo',
        'nivelEstudio',
        'sedeOrigen'
    ])->findOrFail($id);

    return view('frontend.persona.show', compact('persona'));
}
}