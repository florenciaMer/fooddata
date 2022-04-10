<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Planificacion
 *
 * @property int planificacion_id
 * @property int $usuario_id
 * @property int $cliente_id
 * @property int $receta_id
 * @property string $contexto
 * @property int $cant_receta
 * @property int $tipo_id
 * @property string $observaciones

 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion wherePlanificacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereusuarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereRecetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereContexto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereCantReceta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereTipoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planificacion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
/**
 * App\Models\Planificacion
 *
 * @method static create(array $all)

 * @property int $planificacion_id

 *
*/
class Planificacion extends Model
{
    protected $table = 'planificacion';
    protected $primaryKey = 'planificacion_id';
    protected $fillable = [
        'usuario_id',
        'cliente_id',
        'cant',
        'fecha',
        'contexto',
        'observaciones'
    ];


    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'cant' => 'required',
        'fecha' => 'required',
    ];
    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'cant.required' => 'Tenés que ingresar una cantidad.',
        'fecha.required' => 'Tenés que seleccionar una fecha.',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
    public function planificacionItem()
    {
        return $this->hasMany(PlanificacionItem::class, 'planificacion_id', 'planificacion_id');
    }
}
