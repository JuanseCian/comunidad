<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atenciones extends Model
{
    protected $table = 'atenciones';

    protected $fillable = [
        'persona_id',
        'usuario_id',
        'sede_id',
        'tipo',
        'descripcion',
        'fecha_atencion',
    ];

    protected $casts = [
        'fecha_atencion' => 'date',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
}