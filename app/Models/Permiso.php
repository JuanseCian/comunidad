<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permiso
 * 
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $modulo
 * 
 * @property Collection|RolPermiso[] $rol_permisos
 *
 * @package App\Models
 */
class Permiso extends Model
{
	protected $table = 'permisos';
	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'descripcion',
		'modulo'
	];

	public function rol_permisos()
	{
		return $this->hasMany(RolPermiso::class);
	}
}
