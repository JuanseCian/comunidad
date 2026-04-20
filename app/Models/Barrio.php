<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Barrio
 * 
 * @property int $id
 * @property string $nombre
 * @property int $localidad_id
 * @property int|null $zona_barrio_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Localidad $localidad
 * @property ZonaBarrio|null $zona_barrio
 * @property Collection|Domicilio[] $domicilios
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Barrio extends Model
{
	use SoftDeletes;
	protected $table = 'barrio';

	protected $casts = [
		'localidad_id' => 'int',
		'zona_barrio_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'localidad_id',
		'zona_barrio_id'
	];

	public function localidad()
	{
		return $this->belongsTo(Localidad::class);
	}

	public function zona_barrio()
	{
		return $this->belongsTo(ZonaBarrio::class);
	}

	public function domicilios()
	{
		return $this->hasMany(Domicilio::class);
	}

	public function personas()
	{
		return $this->hasMany(Persona::class);
	}
}
