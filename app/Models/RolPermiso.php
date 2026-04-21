<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RolPermiso
 * 
 * @property int $rol_id
 * @property int $permiso_id
 * 
 * @property Permiso $permiso
 * @property Role $role
 *
 * @package App\Models
 */
class RolPermiso extends Model
{
	protected $table = 'rol_permiso';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rol_id' => 'int',
		'permiso_id' => 'int'
	];

	public function permiso()
	{
		return $this->belongsTo(Permiso::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'rol_id');
	}
}
