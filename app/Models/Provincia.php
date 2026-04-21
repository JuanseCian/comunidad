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
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 * 
 * @property User|null $user
 * @property Collection|Localidad[] $localidads
 * @property Collection|Persona[] $personas
 *
 * @package App\Models
 */
class Provincia extends Model
{
	use SoftDeletes;
	protected $table = 'provincia';

	protected $casts = [
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'nombre',
		'updated_by',
		'deleted_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function localidads()
	{
		return $this->hasMany(Localidad::class, 'provincia_id');
	}

	public function personas()
	{
		return $this->hasMany(Persona::class, 'provincia_id');
	}
}
