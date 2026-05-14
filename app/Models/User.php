<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'nombre',
        'apellido',
        'email',
        'password',
        'rol_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function rol()
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

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    public function esTecnico()
    {
        return $this->rol_id == 1;
    }

    public function esCoordinador()
    {
        return $this->rol_id == 2;
    }

    public function esAdministrador()
    {
        return $this->rol_id == 3;
    }

    public function esInactivo()
    {
        return $this->rol_id == 4;
    }

    public function esProgramador()
    {
        return $this->rol_id == 5;
    }

    /*
    |--------------------------------------------------------------------------
    | Permisos
    |--------------------------------------------------------------------------
    */

    public function puedeEditar()
    {
        return in_array($this->rol_id, [2,3,5]);
    }

    public function puedeVerAtenciones()
    {
        return in_array($this->rol_id, [1,2,3,5]);
    }

    public function puedeAdministrarUsuarios()
    {
        return in_array($this->rol_id, [3,5]);
    }

    public function esRecepcion()
    {
        return $this->rol_id == 6;
    }
}