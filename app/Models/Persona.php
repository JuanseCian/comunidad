<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Beneficio;

class Persona extends Model
{
    protected $table = 'personas';

    protected $fillable = [
        'familia_id',
        'nombre',
        'apellido',
        'correo',
        'fecha_nacimiento',
        'documento_id',
        'dni',
        'estado',
        'cuil',
        'sexo_id',
        'genero_percibido_id',
        'domicilio_id',
        'provincia_id',
        'localidad_id',
        'barrio_id',
        'telefono',
        'nivel_estudio_id',
        'estado_civil_id',
        'trabaja',
        'grupo_sanguineo',
        'sede_origen_id',
        // Salud — discapacidad
        'discapacidad_id',
        'discapacidad_permanente',
        'discapacidad_tratamiento',
        'caratula',
        // Salud — enfermedad
        'enfermedad_id',
        'enfermedad_tratamiento',
        // Salud — embarazo
        'embarazo',
        'control_embarazo',
        // Cobertura
        'cobertura_id',
    ];

    protected $casts = [
        'fecha_nacimiento'         => 'date',
        'documento_id'             => 'int',
        'sexo_id'                  => 'int',
        'genero_percibido_id'      => 'int',
        'domicilio_id'             => 'int',
        'provincia_id'             => 'int',
        'localidad_id'             => 'int',
        'barrio_id'                => 'int',
        'nivel_estudio_id'         => 'int',
        'estado_civil_id'          => 'int',
        'sede_origen_id'           => 'int',
        'familia_id'               => 'int',
        'trabaja'                  => 'boolean',
        // Salud — discapacidad
        'discapacidad_id'          => 'int',
        'discapacidad_permanente'  => 'boolean',
        'discapacidad_tratamiento' => 'boolean',
        // Salud — enfermedad
        'enfermedad_id'            => 'int',
        'enfermedad_tratamiento'   => 'boolean',
        // Salud — embarazo
        'embarazo'                 => 'boolean',
        'control_embarazo'         => 'boolean',
        // Cobertura
        'cobertura_id'             => 'int',
    ];

    // ── Relaciones ──────────────────────────────────────────

    public function domicilio()
    {
        return $this->belongsTo(Domicilio::class);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }

    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class);
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo::class);
    }

    public function generoPercibido()
    {
        return $this->belongsTo(GeneroPercibido::class);
    }

    public function nivelEstudio()
    {
        return $this->belongsTo(NivelesEstudio::class, 'nivel_estudio_id');
    }

    public function sedeOrigen()
    {
        return $this->belongsTo(Sede::class, 'sede_origen_id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'documento_id');
    }

    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'barrio_id');
    }

    public function grupoFamiliar()
    {
        return $this->hasMany(GrupoFamiliar::class, 'persona_id');
    }

    public function familia()
    {
        return $this->belongsTo(Familia::class, 'familia_id');
    }

    public function discapacidad()
    {
        return $this->belongsTo(Discapacidad::class);
    }

    public function programas()
    {
        return $this->belongsToMany(
            ProgramasAsistencia::class,
            'persona_programa',
            'persona_id',
            'programa_id'
        )->withPivot([
            'rol',
            'fecha_inicio',
            'fecha_fin'
        ])->withTimestamps();
    }

    public function cud()
    {
        return $this->hasOne(Cud::class, 'persona_id');
    }
    public function enfermedad()
    {
        return $this->belongsTo(Enfermedad::class);
    }

    public function cobertura()
    {
        return $this->belongsTo(Cobertura::class);
    }

    public function personaPrograma()
    {
        return $this->hasMany(PersonaPrograma::class, 'persona_id');
    }

    public function personaBeneficio()
    {
        return $this->hasMany(PersonaBeneficio::class, 'persona_id');
    }

    public function atenciones()
{
    return $this->hasMany(Atencion::class)
                ->with('adjuntos')
                ->latest('fecha_atencion');
}

    public function trabajos()
    {
        return $this->hasMany(PersonaTrabajo::class)->latest('fecha_inicio');
    }

    public function trabajoActual()
    {
        return $this->hasOne(PersonaTrabajo::class)->whereNull('fecha_fin')->latest('fecha_inicio');
    }

    // ── Accessors ───────────────────────────────────────────

    public function getEdadAttribute()
    {
        return \Carbon\Carbon::parse($this->fecha_nacimiento)->age;
    }

   

    public function alertaPrograma()
    {
        if (!$this->fecha_nacimiento) return null;

        $edad = \Carbon\Carbon::parse($this->fecha_nacimiento)->age;

        if ($this->personaPrograma()->count() === 0) {
            return null;
        }

        if ($edad >= 6 && $edad < 12) {
            $programaEsperado = 'UDI';
            $mensaje = 'Debe ingresar a UDI.';
            $siguiente = 'Envion';
        } 
        elseif ($edad >= 12 && $edad < 21) {
            $programaEsperado = 'Envion';
            $mensaje = 'Debe ingresar a Envión o Multiespacio.';
            $siguiente = null;
        }
        else {
            return null;
        }

        $tieneCorrecto = $this->personaPrograma()
            ->whereNull('fecha_fin')
            ->whereHas('programa', function ($q) use ($programaEsperado) {
                $q->whereRaw('LOWER(nombre) LIKE ?', ["%$programaEsperado%"]);
            })
            ->exists();

        if ($tieneCorrecto) return null;

        return [
            'mensaje' => $mensaje,
            'programa' => $programaEsperado,
            'siguiente' => $siguiente
        ];
    }

    public function actualizarProgramasPorEdad()
    {
        if (!$this->fecha_nacimiento) return;

        $edad = $this->edad;

        foreach ($this->personaPrograma as $pp) {

            if (!$pp->programa) continue;
            if ($pp->fecha_fin) continue;

            $nombre = strtolower($pp->programa->nombre);
            $rol    = $pp->rol;

            $cumple = match (true) {
                str_contains($nombre, 'guarderia')                            => \Carbon\Carbon::parse($this->fecha_nacimiento)->addYears(6),
                str_contains($nombre, 'udi')                                  => \Carbon\Carbon::parse($this->fecha_nacimiento)->addYears(12),
                str_contains($nombre, 'envion') && $rol == 'destinatario'     => \Carbon\Carbon::parse($this->fecha_nacimiento)->addYears(21),
                str_contains($nombre, 'envion') && $rol == 'tutor'            => \Carbon\Carbon::parse($this->fecha_nacimiento)->addYears(25),
                default => null
            };

            if (!$cumple) continue;

            if ($edad >= $cumple->age) {
                $pp->update(['fecha_fin' => $cumple]);
            }
        }
    }
}
