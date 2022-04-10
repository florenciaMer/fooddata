<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TipoController
 *
 * @property int $tipo_id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereTipoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Tipo[] $tipos
 * @property-read int|null $tipos_count
 */

class Tipo extends Model
{
    protected $table = 'tipos';
    protected $primaryKey = 'tipo_id';

    protected $fillable = [
        'tipo_id',
        'nombre',
    ];
    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'nombre' => 'required|min:3',

    ];
    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'nombre.min' => 'El nombre tiene que tener al menos 3 caracteres.',
        'nombre.required'=> 'Tenés que completar el nombre'

    ];
    public function recetas(){
        return $this->hasMany(Receta::class, 'receta_id');
    }
    public function recetasTipo_id(){
        return $this->hasMany(Receta::class, 'tipo_id');
    }

}
