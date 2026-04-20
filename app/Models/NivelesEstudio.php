<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NivelesEstudio
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class NivelesEstudio extends Model
{
	protected $table = 'niveles_estudio';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function personas()
	{
		return $this->hasMany(Persona::class, 'nivel_estudio_id');
	}
}
