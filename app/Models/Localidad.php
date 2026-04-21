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
 * Class Localidad
 * 
 * @property int $id
 * @property string|null $nombre
 * @property int $codigo_postal
 * @property int|null $provincia_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * 
 * @property User|null $user
 * @property Provincium|null $provincium
 * @property Collection|Barrio[] $barrios
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Localidad extends Model
{
	use SoftDeletes;
	protected $table = 'localidad';

	protected $casts = [
		'codigo_postal' => 'int',
		'provincia_id' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'nombre',
		'codigo_postal',
		'provincia_id',
		'updated_by',
		'deleted_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function provincium()
	{
		return $this->belongsTo(Provincium::class, 'provincia_id');
	}

	public function barrios()
	{
		return $this->hasMany(Barrio::class);
	}

	public function personas()
	{
		return $this->hasMany(Persona::class);
	}
}
