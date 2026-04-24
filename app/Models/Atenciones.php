<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Atencione
 * 
 * @property int $id
 * @property int $persona_id
 * @property int $usuario_id
 * @property int|null $sede_id
 * @property string $tipo
 * @property string|null $descripcion
 * @property Carbon $fecha_atencion
 * @property Carbon|null $proxima_atencion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Persona $persona
 * @property Sede|null $sede
 * @property User $user
 *
 * @package App\Models
 */
class Atenciones extends Model
{
	protected $table = 'atenciones';

	protected $casts = [
		'persona_id' => 'int',
		'usuario_id' => 'int',
		'sede_id' => 'int',
		'fecha_atencion' => 'datetime',
		'proxima_atencion' => 'datetime'
	];

	protected $fillable = [
		'persona_id',
		'usuario_id',
		'sede_id',
		'tipo',
		'descripcion',
		'fecha_atencion',
		'proxima_atencion'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function sede()
	{
		return $this->belongsTo(Sede::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'usuario_id');
	}
}
