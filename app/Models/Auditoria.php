<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Auditorium
 * 
 * @property int $id
 * @property string $tabla
 * @property int $registro_id
 * @property string|null $campo
 * @property string|null $valor_anterior
 * @property string|null $valor_nuevo
 * @property string $accion
 * @property string|null $ip
 * @property int|null $usuario_id
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class Auditorium extends Model
{
	protected $table = 'auditoria';
	public $timestamps = false;

	protected $casts = [
		'registro_id' => 'int',
		'usuario_id' => 'int'
	];

	protected $fillable = [
		'tabla',
		'registro_id',
		'campo',
		'valor_anterior',
		'valor_nuevo',
		'accion',
		'ip',
		'usuario_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'usuario_id');
	}
}
