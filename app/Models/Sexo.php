<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sexo
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|GrupoFamiliar[] $grupo_familiars
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Sexo extends Model
{
	protected $table = 'sexo';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function grupo_familiars()
	{
		return $this->hasMany(GrupoFamiliar::class);
	}

	public function personas()
	{
		return $this->hasMany(Persona::class);
	}
}
