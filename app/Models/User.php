<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string|null $username
 * @property string $nombre
 * @property string $apellido
 * @property string $email
 * @property string $password
 * @property int|null $rol_id
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Role|null $role
 * @property Collection|Adjunto[] $adjuntos
 * @property Collection|AdjuntosDescarga[] $adjuntos_descargas
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'rol_id' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
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
