<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'fecha_nacimiento',
        'documento_id',
        'dni',
        'cuil',
        'sexo_id',
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
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'documento_id'     => 'int',
        'sexo_id'          => 'int',
        'domicilio_id'     => 'int',
        'provincia_id'     => 'int',
        'localidad_id'     => 'int',
        'barrio_id'        => 'int',
        'nivel_estudio_id' => 'int',
        'estado_civil_id'  => 'int',
        'sede_origen_id'   => 'int',
        'trabaja'          => 'boolean',
    ];

    // ── Catálogos ─────────────────────────────────────────────────────────────

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'documento_id');
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexo_id');
    }

    public function nivelEstudio()
    {
        return $this->belongsTo(NivelesEstudio::class, 'nivel_estudio_id');
    }

    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'estado_civil_id');
    }

    // ── Geografía ─────────────────────────────────────────────────────────────

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'barrio_id');
    }

    public function domicilio()
    {
        return $this->belongsTo(Domicilio::class, 'domicilio_id');
    }

    // ── Sistema ───────────────────────────────────────────────────────────────

    public function sedeOrigen()
    {
        return $this->belongsTo(Sede::class, 'sede_origen_id');
    }

    // ── Familia y social ──────────────────────────────────────────────────────

    public function grupoFamiliar()
    {
        return $this->hasMany(GrupoFamiliar::class, 'persona_id');
    }

    public function cud()
    {
        return $this->hasOne(Cud::class, 'persona_id');
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
        return $this->hasMany(Atencion::class, 'persona_id');
    }
}