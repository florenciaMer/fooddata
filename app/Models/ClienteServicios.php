<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Etiqueta;
use App\Models\Usuario;

/**
 *
 * @property int $ClienteServicios_id
 * @property int $cliente_id
 * @property int $etiqueta_id
 * @property integer $precio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios whereEtiquetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClienteServicios whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class ClienteServicios extends Model
{
    protected $table = 'clienteservicios';
    protected $primaryKey = 'clienteServicio_id';

    protected $fillable = [
        'clienteServicio_id',
        'etiqueta_id',
        'precio',
        'usuario_id',
        'cliente_id'
    ];

    public static $cant_add = [
        'precioAdd' => 'required'
    ];
    public static $rules = [
        'precio' => 'required',
        // 'imagen'    => 'image'
    ];

    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'precio.required' => 'Tenés que ingresear un precio.',
    ];

    public function etiqueta(){
        return $this->belongsTo(Etiqueta::class, 'etiqueta_id', 'etiqueta_id');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }

}
