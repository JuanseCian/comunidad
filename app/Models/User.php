<?php

namespace App\Models;

// 1. Cambiamos la importación base
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class User
 * ... (tus anotaciones de propiedades se mantienen igual)
 */
class User extends Authenticatable // 2. Ahora extiende de Authenticatable
{
    use HasFactory, Notifiable; // Traits necesarios para notificaciones y factories

    protected $table = 'users';

    protected $casts = [
        'rol_id' => 'int',
        'email_verified_at' => 'datetime', // Recomendado si usas verificación
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'username',
        'nombre',
        'apellido',
        'email',
        'password',
        'rol_id',
        'remember_token'
    ];

    // --- Tus Relaciones se mantienen intactas ---

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
}	