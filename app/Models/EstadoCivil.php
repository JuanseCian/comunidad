<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoCivil
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|GrupoFamiliar[] $grupo_familiars
 *
 * @package App\Models
 */
class EstadoCivil extends Model
{
	protected $table = 'estado_civil';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function grupo_familiars()
	{
		return $this->hasMany(GrupoFamiliar::class);
	}
}
