<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
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
use App\Models\Localidad;
use App\Models\ProgramasAsistencia;
use App\Models\Discapacidad;
use App\Models\Enfermedad;
use App\Models\Cobertura;

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
            'tipos_doc'       => TipoDocumento::orderBy('nombre')->get(),
            'sexos'           => Sexo::orderBy('nombre')->get(),
            'niveles'         => NivelesEstudio::orderBy('nombre')->get(),
            'barrios'         => Barrio::orderBy('nombre')->get(),
            'sedes'           => Sede::orderBy('nombre')->get(),
            'estados_civiles' => EstadoCivil::all(),
            'provincias'      => Provincia::orderBy('nombre')->get(),
            'localidades'     => Localidad::orderBy('nombre')->get(),
            'catalogos'       => [
                'discapacidades' => Discapacidad::orderBy('nombre')->get(),
                'enfermedades'   => Enfermedad::orderBy('nombre')->get(),
                'coberturas'     => Cobertura::orderBy('nombre')->get(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'                   => 'required|string|max:255',
            'apellido'                 => 'required|string|max:255',
            'dni'                      => 'required',
            'cuil'                     => 'nullable|string|max:20',
            'estado_civil_id'          => 'nullable|exists:estado_civil,id',
            'provincia_id'             => 'nullable|exists:provincia,id',
            'localidad_id'             => 'nullable|exists:localidad,id',

            'discapacidad_id'          => 'nullable|exists:discapacidad,id',
            'enfermedad_id'            => 'nullable|exists:enfermedad,id',
            'cobertura_id'             => 'nullable|exists:cobertura,id',
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


        $tieneDiscapacidad = $request->boolean('_tiene_discapacidad') || $request->filled('discapacidad_id');
        $tieneEnfermedad   = $request->filled('enfermedad_id');
        $tieneEmbarazo     = $request->boolean('embarazo');

        $persona = Persona::create([
            'nombre'                   => $request->nombre,
            'apellido'                 => $request->apellido,
            'correo'                   => $request->correo,
            'fecha_nacimiento'         => $request->fecha_nacimiento,
            'documento_id'             => $request->documento_id,
            'dni'                      => $request->dni,
            'cuil'                     => $request->cuil,
            'sexo_id'                  => $request->sexo_id,
            'domicilio_id'             => $domicilio_id,
            'provincia_id'             => $request->provincia_id,
            'localidad_id'             => $request->localidad_id,
            'telefono'                 => $request->telefono,
            'nivel_estudio_id'         => $request->nivel_estudio_id,
            'estado_civil_id'          => $request->estado_civil_id,
            'trabaja'                  => $request->boolean('trabaja') ? 1 : 0,
            'grupo_sanguineo'          => $request->grupo_sanguineo,
            'sede_origen_id'           => $request->sede_origen_id,

            'discapacidad_permanente'  => $tieneDiscapacidad ? 1 : 0,
            'discapacidad_id'          => $tieneDiscapacidad ? $request->discapacidad_id : null,
            'discapacidad_tratamiento' => $tieneDiscapacidad ? ($request->boolean('discapacidad_tratamiento') ? 1 : 0) : null,

            'enfermedad_id'            => $tieneEnfermedad ? $request->enfermedad_id : null,
            'enfermedad_tratamiento'   => $tieneEnfermedad ? ($request->boolean('enfermedad_tratamiento') ? 1 : 0) : null,

            'embarazo'                 => $tieneEmbarazo ? 1 : 0,
            'control_embarazo'         => $tieneEmbarazo ? ($request->boolean('control_embarazo') ? 1 : 0) : null,

            'cobertura_id'             => $request->cobertura_id,
        ]);

        return redirect()
            ->route('personas.show', $persona->id)
            ->with('success', 'Persona registrada correctamente')
            ->with('abrirProgramaModal', true);
    }

    public function asignarPrograma(Request $request, $personaId)
    {
        $persona = Persona::findOrFail($personaId);
        $edad = $persona->edad;

        $programa = ProgramasAsistencia::findOrFail($request->programa_id);
        $rol = $request->rol;

        switch ($programa->nombre) {

            case 'Guarderia':
                if ($edad < 0 || $edad > 5) {
                    return back()->withErrors('Solo 0 a 5 años en guardería');
                }
            break;

            case 'UDI':
                if ($edad < 6 || $edad > 11) {
                    return back()->withErrors('Solo 6 a 11 años en UDI');
                }
            break;

            case 'Envion':
                if ($rol == 'destinatario') {
                    if ($edad < 12 || $edad > 21) {
                        return back()->withErrors('Envión destinatario: 12 a 21 años');
                    }
                }

                if ($rol == 'tutor') {
                    if ($edad < 18 || $edad > 25) {
                        return back()->withErrors('Tutor: 18 a 25 años');
                    }
                }
            break;

            case 'Multiespacio':
                if ($edad < 12) {
                    return back()->withErrors('Multiespacio: desde 12 años');
                }
            break;
        }


        $persona->programas()->attach($programa->id, [
            'rol' => $rol,
            'fecha_inicio' => now()
        ]);

        return back()->with('success', 'Programa asignado correctamente');
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

        $programas   = ProgramasAsistencia::orderBy('nombre')->get();
        $niveles     = NivelesEstudio::orderBy('nombre')->get();
        $provincias  = Provincia::orderBy('nombre')->get();
        $localidades = Localidad::orderBy('nombre')->get();
        $barrios     = Barrio::orderBy('nombre')->get();

        $persona->actualizarProgramasPorEdad();

        
        $persona->load('personaPrograma.programa');

        $persona->actualizarProgramasPorEdad();

        return view('frontend.persona.show', [
            'persona'     => $persona,
            'programas'   => $programas,
            'niveles'     => $niveles,
            'provincias'  => $provincias,
            'localidades' => $localidades,
            'barrios'     => $barrios,
        ]);
    }

    public function cambiarPrograma(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);
        
        $actual = $persona->personaPrograma()
            ->whereNull('fecha_fin')
            ->latest()
            ->first();

        if ($actual) {
            $actual->update([
                'fecha_fin' => now()
            ]);
        }

        $programaActual = $persona->programas()
            ->wherePivotNull('fecha_fin')
            ->first();

        if ($programaActual) {
            $persona->programas()->updateExistingPivot($programaActual->id, [
                'fecha_fin' => now()
            ]);
        }

        $nuevoPrograma = ProgramasAsistencia::where('nombre', $request->programa_nombre)->first();

        if ($nuevoPrograma) {
            $persona->programas()->attach($nuevoPrograma->id, [
                'rol' => 'destinatario',
                'fecha_ingreso' => now()
            ]);
        }

        return back()->with('success', 'Programa actualizado correctamente');
    }
    
    public function evaluarProgramasPorEdad()
    {
        if (!$this->fecha_nacimiento) return;

        $edad = $this->edad;

        foreach ($this->personaPrograma as $pp) {

            if (!$pp->programa) continue;


            if ($pp->fecha_fin) continue;

            $nombre = strtolower($pp->programa->nombre);
            $rol    = $pp->rol;

            if (str_contains($nombre, 'guarderia') && $edad >= 6) {
                $pp->update(['fecha_fin' => now()]);
            }

            if (str_contains($nombre, 'udi') && $edad >= 12) {
                $pp->update(['fecha_fin' => now()]);
            }

            if (str_contains($nombre, 'envion') && $rol == 'destinatario' && $edad >= 21) {
                $pp->update(['fecha_fin' => now()]);
            }

            if (str_contains($nombre, 'envion') && $rol == 'tutor' && $edad >= 25) {
                $pp->update(['fecha_fin' => now()]);
            }
        }
    }

    public function edit($id)
    {
        $persona = Persona::with('domicilio')->findOrFail($id);

        return view('frontend.persona.edit', [
            'persona'         => $persona,
            'tipos_doc'       => TipoDocumento::orderBy('nombre')->get(),
            'sexos'           => Sexo::orderBy('nombre')->get(),
            'niveles'         => NivelesEstudio::orderBy('nombre')->get(),
            'provincias'      => Provincia::orderBy('nombre')->get(),
            'barrios'         => Barrio::orderBy('nombre')->get(),
            'sedes'           => Sede::orderBy('nombre')->get(),
            'estados_civiles' => EstadoCivil::orderBy('nombre')->get(),
            'localidades'     => Localidad::orderBy('nombre')->get(),
            'catalogos'       => [
                'discapacidades' => Discapacidad::orderBy('nombre')->get(),
                'enfermedades'   => Enfermedad::orderBy('nombre')->get(),
                'coberturas'     => Cobertura::orderBy('nombre')->get(),
            ],
        ]);
    }

    public function updateDatos(Request $request, $id)
    {
        if (!in_array(auth()->user()->rol_id, [2,3,5])) {
            abort(403, 'No tenés permisos para editar esta información');
        }

        $persona = Persona::findOrFail($id);

        $request->validate([
            'correo'           => 'nullable|email|max:255',
            'telefono'         => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'cuil'             => 'nullable|string|max:20',
            'grupo_sanguineo'  => 'nullable|string|max:10',
            'nivel_estudio_id' => 'nullable|exists:niveles_estudio,id',

            'discapacidad_id'  => 'nullable|exists:discapacidad,id',
            'enfermedad_id'    => 'nullable|exists:enfermedad,id',
            'cobertura_id'     => 'nullable|exists:cobertura,id',
        ]);

        $tieneDiscapacidad = $request->boolean('_tiene_discapacidad') || $request->filled('discapacidad_id');
        $tieneEnfermedad   = $request->filled('enfermedad_id');
        $tieneEmbarazo     = $request->boolean('embarazo');

        $persona->update([
            'correo'                   => $request->correo,
            'telefono'                 => $request->telefono,
            'fecha_nacimiento'         => $request->fecha_nacimiento,
            'cuil'                     => $request->cuil,
            'grupo_sanguineo'          => $request->grupo_sanguineo,
            'nivel_estudio_id'         => $request->nivel_estudio_id,
   
            'discapacidad_permanente'  => $tieneDiscapacidad ? 1 : 0,
            'discapacidad_id'          => $tieneDiscapacidad ? $request->discapacidad_id : null,
            'discapacidad_tratamiento' => $tieneDiscapacidad ? ($request->boolean('discapacidad_tratamiento') ? 1 : 0) : null,
         
            'enfermedad_id'            => $tieneEnfermedad ? $request->enfermedad_id : null,
            'enfermedad_tratamiento'   => $tieneEnfermedad ? ($request->boolean('enfermedad_tratamiento') ? 1 : 0) : null,
          
            'embarazo'                 => $tieneEmbarazo ? 1 : 0,
            'control_embarazo'         => $tieneEmbarazo ? ($request->boolean('control_embarazo') ? 1 : 0) : null,
           
            'cobertura_id'             => $request->cobertura_id,
        ]);

        return back()->with('success', 'Datos personales actualizados correctamente');
    }

    public function updateDomicilio(Request $request, $id)
    {
        if (!in_array(auth()->user()->rol_id, [2,3,5])) {
            abort(403, 'No tenés permisos para editar esta información');
        }

        $persona = Persona::findOrFail($id);

        $request->validate([
            'provincia_id' => 'nullable|exists:provincia,id',
            'localidad_id' => 'nullable|exists:localidad,id',
            'barrio_id'    => 'nullable|exists:barrio,id',
            'calle'        => 'nullable|string|max:255',
            'numero'       => 'nullable|string|max:20',
            'piso'         => 'nullable|string|max:10',
            'dpto'         => 'nullable|string|max:10',
        ]);

        if ($request->filled(['calle', 'numero']) || $request->filled('barrio_id')) {

            $datosDomicilio = [
                'barrio_id' => $request->barrio_id,
                'calle'     => $request->calle,
                'numero'    => $request->numero,
                'piso'      => $request->piso,
                'dpto'      => $request->dpto,
            ];

            if ($persona->domicilio_id) {
                Domicilio::where('id', $persona->domicilio_id)->update($datosDomicilio);
            } else {
                $domicilio = Domicilio::create($datosDomicilio);
                $persona->domicilio_id = $domicilio->id;
                $persona->save();
            }
        }

        $persona->update([
            'provincia_id' => $request->provincia_id,
            'localidad_id' => $request->localidad_id,
        ]);

        return back()->with('success', 'Domicilio actualizado correctamente');
    }
}