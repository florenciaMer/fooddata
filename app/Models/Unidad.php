<?php

namespace App\Models;
use App\Models\Ingrediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UnidadController
 *
 * @property int $unidad_id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Unidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unidad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unidad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidad whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidad whereUnidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidad whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Ingrediente[] $ingredientes
 * @property-read int|null $ingredientes_count
 */
class Unidad extends Model
{
    protected $table = 'unidades';
    protected $primaryKey = 'unidad_id';

    protected $fillable = [
        'unidad_id',
        'nombre',
    ];
    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'nombre' => 'required|min:3',

    ];
    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'nombre.min' => 'La unidad tiene que tener al menos 3 caracteres.',
        'nombre.required'=> 'Tenés que completar el nombre de la unidad de medida'

    ];
    public function ingredientes(){
        return $this->hasMany(Ingrediente::class, 'unidad_id');
    }

}
