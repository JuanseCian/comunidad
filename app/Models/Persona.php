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
        'sede_origen_id'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'documento_id' => 'int',
        'sexo_id' => 'int',
        'domicilio_id' => 'int',
        'provincia_id' => 'int',
        'localidad_id' => 'int',
        'barrio_id' => 'int',
        'nivel_estudio_id' => 'int',
        'estado_civil_id' => 'int',
        'sede_origen_id' => 'int',
        'trabaja' => 'boolean'
    ];

   
    public function domicilio() {
    return $this->belongsTo(Domicilio::class);
}

public function provincia() {
    return $this->belongsTo(Provincia::class);
}

public function localidad() {
    return $this->belongsTo(Localidad::class);
}

public function estadoCivil() {
    return $this->belongsTo(EstadoCivil::class);
}

public function sexo() {
    return $this->belongsTo(Sexo::class);
}

public function nivelEstudio() {
    return $this->belongsTo(NivelesEstudio::class, 'nivel_estudio_id');
}

public function sedeOrigen() {
    return $this->belongsTo(Sede::class, 'sede_origen_id');
}
}