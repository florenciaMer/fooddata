<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EtiquetaController
 *
 * @property int $etiqueta_id
 * @property string $nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereEtiquetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereUpdatedAt($value)
 * @mixin \Eloquent

 */

class Etiqueta extends Model
{
    protected $table = 'etiquetas';
    protected $primaryKey = 'etiqueta_id';
    protected $fillable = [
        'etiqueta_id',
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
//    public function ingredientes(){
//        return $this->hasMany(Ingrediente::class, 'etiqueta_id');
//    }
}
