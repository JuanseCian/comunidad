<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Usado para inserts directos: PersonaNucleo::firstOrCreate([...])
 */
class PersonaNucleo extends Model
{
    protected $table = 'persona_nucleo';

    const UPDATED_AT = null;

    protected $fillable = [
        'nucleo_id',
        'persona_id',
        'grupo_familiar_id',
    ];

    public function nucleo()
    {
        return $this->belongsTo(NucleoConviviente::class, 'nucleo_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function grupoFamiliar()
    {
        return $this->belongsTo(GrupoFamiliar::class, 'grupo_familiar_id');
    }
}
