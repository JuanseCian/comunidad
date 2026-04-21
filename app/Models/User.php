<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
	public function role()
	{
		return $this->belongsTo(Role::class, 'rol_id');
	}

	public function adjuntos()
	{
		return $this->hasMany(Adjunto::class, 'subido_por');
	}

	public function adjuntos_descargas()
	{
		return $this->hasMany(AdjuntosDescarga::class, 'usuario_id');
	}
}
	

