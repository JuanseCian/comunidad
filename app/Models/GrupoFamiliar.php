<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GrupoFamiliar
 * 
 * @property int $id
 * @property int $persona_id
 * @property string $nombre
 * @property int|null $documento_id
 * @property string|null $numero_documento
 * @property int|null $sexo_id
 * @property Carbon|null $fecha_nacimiento
 * @property string|null $relacion_titular
 * @property int|null $estado_civil_id
 * @property bool|null $discapacidad_permanente
 * @property int|null $discapacidad_id
 * @property bool|null $discapacidad_tratamiento
 * @property string|null $caratula
 * @property int|null $enfermedad_id
 * @property bool|null $enfermedad_tratamiento
 * @property bool|null $embarazo
 * @property bool|null $control_embarazo
 * @property bool|null $esquema_vacunacion
 * @property int|null $cobertura_id
 * @property int|null $situacion_ocupacional_id
 * @property int|null $condicion_inactividad_id
 * @property int|null $categoria_ocupacional_id
 * @property float|null $ingresos
 * 
 * @property CategoriaOcupacional|null $categoria_ocupacional
 * @property Cobertura|null $cobertura
 * @property Discapacidad|null $discapacidad
 * @property TipoDocumento|null $tipo_documento
 * @property Enfermedade|null $enfermedade
 * @property EstadoCivil|null $estado_civil
 * @property CondicionInactividad|null $condicion_inactividad
 * @property Persona $persona
 * @property Sexo|null $sexo
 * @property SituacionOcupacional|null $situacion_ocupacional
 *
 * @package App\Models
 */
class GrupoFamiliar extends Model
{
	protected $table = 'grupo_familiar';
	public $timestamps = false;

	protected $casts = [
		'persona_id' => 'int',
		'documento_id' => 'int',
		'sexo_id' => 'int',
		'fecha_nacimiento' => 'datetime',
		'estado_civil_id' => 'int',
		'discapacidad_permanente' => 'bool',
		'discapacidad_id' => 'int',
		'discapacidad_tratamiento' => 'bool',
		'enfermedad_id' => 'int',
		'enfermedad_tratamiento' => 'bool',
		'embarazo' => 'bool',
		'control_embarazo' => 'bool',
		'esquema_vacunacion' => 'bool',
		'cobertura_id' => 'int',
		'situacion_ocupacional_id' => 'int',
		'condicion_inactividad_id' => 'int',
		'categoria_ocupacional_id' => 'int',
		'ingresos' => 'float'
	];

	protected $fillable = [
		'persona_id',
		'nombre',
		'documento_id',
		'numero_documento',
		'sexo_id',
		'fecha_nacimiento',
		'relacion_titular',
		'estado_civil_id',
		'discapacidad_permanente',
		'discapacidad_id',
		'discapacidad_tratamiento',
		'caratula',
		'enfermedad_id',
		'enfermedad_tratamiento',
		'embarazo',
		'control_embarazo',
		'esquema_vacunacion',
		'cobertura_id',
		'situacion_ocupacional_id',
		'condicion_inactividad_id',
		'categoria_ocupacional_id',
		'ingresos'
	];

	public function categoria_ocupacional()
	{
		return $this->belongsTo(CategoriaOcupacional::class);
	}

	public function cobertura()
	{
		return $this->belongsTo(Cobertura::class);
	}

	public function discapacidad()
	{
		return $this->belongsTo(Discapacidad::class);
	}

	public function tipo_documento()
	{
		return $this->belongsTo(TipoDocumento::class, 'documento_id');
	}

	public function enfermedade()
	{
		return $this->belongsTo(Enfermedade::class, 'enfermedad_id');
	}

	public function estado_civil()
	{
		return $this->belongsTo(EstadoCivil::class);
	}

	public function condicion_inactividad()
	{
		return $this->belongsTo(CondicionInactividad::class);
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}

	public function sexo()
	{
		return $this->belongsTo(Sexo::class);
	}

	public function situacion_ocupacional()
	{
		return $this->belongsTo(SituacionOcupacional::class);
	}
}
