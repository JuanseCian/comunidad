<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cud extends Model
{
    protected $table = 'cud';

    protected $fillable = [
        'persona_id',
        'tiene_cud',
        'numero_cud',
        'fecha_emision',
        'fecha_vencimiento',
        'observaciones',
    ];

    protected $casts = [
        'persona_id'        => 'int',
        'tiene_cud'         => 'boolean',
        'fecha_emision'     => 'date',
        'fecha_vencimiento' => 'date',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
