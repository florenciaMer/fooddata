<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

///**
// * App\Models\Ingrediente
// *
// * @property int ingrediente_id
// * @property string $nombre
// * @property string $precio
// * @property int|null $imagen
// * @property \Illuminate\Support\Carbon|null $created_at
// * @property \Illuminate\Support\Carbon|null $updated_at
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente newModelQuery()
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente newQuery()
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente query()
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereCreatedAt($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereNombre($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereU_med($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereIngredienteId($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente wherePrecio($value)
// * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereUpdatedAt($value)
// * @mixin \Eloquent
// */

/**
 * App\Models\Ingrediente
 *
 * @method static create(array $all)
 * @property int $ingrediente_id
 * @property string $categoria
 * @property string $u_med
 * @property string $nombre
 * @property int $precio
 * @property string $imagen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereIngredienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereUMed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $unidad_id
 * @property-read \App\Models\Unidad $unidad
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereUnidadId($value)
 * @property int $categoria_id
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereCategoriaId($value)
 * @property int $usuario_id
 * @method static \Illuminate\Database\Eloquent\Builder|Ingrediente whereUsuarioId($value)
 * @property-read \App\Models\Usuario $usuario
 */
class Ingrediente extends Model
{
    protected $table = 'ingredientes';
    protected $primaryKey = 'ingrediente_id';

    protected $fillable = [
        'categoria_id',
        'ingrediente_id',
        'usuario_id',
        'impuesto',
        'nombre',
        'precio',
        'unidad_id',
    ];
    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'nombre' => 'required|min:2',
        'precio' => 'required|numeric',
        'impuesto' => 'required|numeric',
        // 'imagen'    => 'image'
    ];

    public static $nombreFind = [
        'nombreFind' => 'required',
    ];
    public static $nombreFindVacio = [
        'nombreFindVacio' => 'required'
    ];

    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'nombre.required' => 'Tenés que escribir el nombre del ingrediente.',
        'nombre.min' => 'El ingrediente tiene que tener al menos 2 caracteres.',
        'precio.required' => 'Tenés que escribir el precio del ingrediente.',
        'precio.numeric' => 'El precio del ingrediente tiene que ser un número, sin decimales. Ej: 1234',
        'precio.digits_between' => 'El precio tiene que tener como máximo 8 números.',
        'img.image' => 'El archivo debe ser una imagen',
        'nombreFind.required' => 'Debés ingresar un nombre para realizar la búsqueda.',
        'nombreFindVacio.required' => 'El ingrediente que ingresó no existe en nuestra base de datos.',
         'impuesto.required' => 'Tenés que escribir el impuesto del ingrediente.',
        'impuesto.numeric' => 'El impuesto del ingrediente tiene que ser un número.'
    ];

    public function unidad()
    {                                   //nombre del model
        return $this->belongsTo(Unidad::class, 'unidad_id', 'unidad_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'categoria_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
    public function recetaItem()
    {
        return $this->belongsTo(RecetaItem::class, 'ingrediente_id', 'ingrediente_id');
    }
}

