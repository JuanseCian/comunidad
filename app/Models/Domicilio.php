<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Domicilio
 * 
 * @property int $id
 * @property string|null $municipio
 * @property string|null $localidad
 * @property int|null $barrio_id
 * @property string|null $calle
 * @property string|null $numero
 * @property string|null $piso
 * @property string|null $dpto
 * 
 * @property Barrio|null $barrio
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Domicilio extends Model
{
	protected $table = 'domicilio';
	public $timestamps = false;

	protected $casts = [
		'barrio_id' => 'int'
	];

	protected $fillable = [
		'municipio',
		'localidad',
		'barrio_id',
		'calle',
		'numero',
		'piso',
		'dpto'
	];

	public function barrio()
	{
		return $this->belongsTo(Barrio::class);
	}

	public function personas()
	{
		return $this->hasMany(Persona::class);
	}
}
