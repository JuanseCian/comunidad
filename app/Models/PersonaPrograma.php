<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PersonaPrograma
 * 
 * @property int $id
 * @property int $persona_id
 * @property int $programa_id
 * @property Carbon|null $fecha_inicio
 * @property Carbon|null $fecha_fin
 * @property bool $activo
 * @property string|null $observaciones
 * @property int|null $registrado_por
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Persona $persona
 * @property ProgramasAsistencium $programas_asistencium
 * @property User|null $user
 *
 * @package App\Models
 */
class PersonaPrograma extends Model
{
	protected $table = 'persona_programa';

	protected $casts = [
		'persona_id' => 'int',
		'programa_id' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime',
		'activo' => 'bool',
		'registrado_por' => 'int',
		'en_adaptacion' => 'boolean',
    	'fecha_limite_adaptacion' => 'date'
	];

	protected $fillable = [
		'persona_id',
		'programa_id',
		'rol',
		'fecha_inicio',
		'fecha_fin',
		'activo',
		'observaciones',
		'registrado_por',
		'en_adaptacion',
		'sede_id',
    	'fecha_limite_adaptacion',
	];

	public function getEstaActivoAttribute()
	{
		if (!$this->en_adaptacion) {
			return true;
		}

		return now()->greaterThan($this->fecha_limite_adaptacion);
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function programa()
	{
		return $this->belongsTo(ProgramasAsistencia::class, 'programa_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'registrado_por');
	}

	public function sede()
	{
		return $this->belongsTo(Sede::class);
	}

	/**
	 * Valida si puede asignarse un programa a una persona
	 * Reglas:
	 * - No puede tener 2 activos del mismo programa
	 * - EXCEPCIÓN: Puede tener Envión + Multiespacio juntos
	 * - Si el anterior está finalizado, SÍ puede asignarse otro del mismo
	 *
	 * @param int $personaId
	 * @param int $programaId
	 * @return array ['valid' => bool, 'mensaje' => string]
	 */
	public static function validarAsignacion($personaId, $programaId)
	{
		$programa = ProgramasAsistencia::findOrFail($programaId);
		$nombrePrograma = $programa->nombre;

		// Obtener todos los programas ACTIVOS de la persona (sin fecha_fin)
		$programasActivos = PersonaPrograma::where('persona_id', $personaId)
			->whereNull('fecha_fin')
			->with('programa')
			->get();

		// Si no hay programas activos, está permitido
		if ($programasActivos->isEmpty()) {
			return ['valid' => true];
		}

		foreach ($programasActivos as $programaActivo) {
			$nombreActual = $programaActivo->programa->nombre;

			// Si es el mismo programa, no permitido
			if ($nombreActual === $nombrePrograma) {
				return [
					'valid' => false,
					'mensaje' => "La persona ya tiene asignado el programa $nombrePrograma activo."
				];
			}

			// EXCEPCIÓN: Envión + Multiespacio
			$esEnvionYMultiespacio = 
				($nombrePrograma === 'Envion' && $nombreActual === 'Multiespacio') ||
				($nombrePrograma === 'Multiespacio' && $nombreActual === 'Envion');

			if ($esEnvionYMultiespacio) {
				// Permitido
				continue;
			}

			// Si tiene otro programa activo (no es Envión/Multiespacio), no permitido
			// porque no pueden tener 2 diferentes activos
			return [
				'valid' => false,
				'mensaje' => "La persona ya tiene asignado el programa $nombreActual activo. Debe finalizarlo antes de asignar otro."
			];
		}

		return ['valid' => true];
	}
}
