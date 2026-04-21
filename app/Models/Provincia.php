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
 * Class Provincium
 * 
 * @property int $id
 * @property string|null $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Localidad[] $localidads
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Provincia extends Model
{
	use SoftDeletes;
	protected $table = 'provincia';

	protected $fillable = [
		'nombre'
	];

	public function localidads()
	{
		return $this->hasMany(Localidad::class, 'provincia_id');
	}

	public function personas()
	{
		return $this->hasMany(Persona::class, 'provincia_id');
	}
}
