<?php

namespace App\Models;
use App\Models\Ingrediente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoriaController
 *
 * @property int $categoria_id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Ingrediente[] $ingredientes
 * @property-read int|null $ingredientes_count
 */
class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'categoria_id';
    protected $fillable = [
        'categoria_id',
        'nombre',
    ];
    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'nombre' => 'required|min:3',

    ];
    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'nombre.min' => 'La categoría tiene que tener al menos 3 caracteres.',
        'nombre.required' => 'Tenés que completar el la categoría.',
    ];
    public function ingredientes(){
        return $this->hasMany(Ingrediente::class, 'categoria_id');
    }

}
