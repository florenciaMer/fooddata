<?php

namespace App\Models;
use App\Models\RecetaItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Ingrediente;
use App\Models\Tipo;

/**
 * App\Models\Receta
 *
 * @property int receta_id
 * @property string $tipo
 * @property string $nombre
 * @property int|null $imagen
 * @property int base

 *
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|receta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|receta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|receta query()
 * @method static \Illuminate\Database\Eloquent\Builder|receta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|receta whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|receta whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|receta whererecetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|receta whereBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|receta whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RecetaItem[] $recetaItem
 * @property-read int|null $recetaItemsCount
 * @mixin \Eloquent
 */



class Receta extends Model
{
    protected $table = 'recetas';
    protected $primaryKey = 'receta_id';

    protected $fillable = [
        'tipo_id',
        'nombre',
        'usuario_id',
        'descripcion',
        'base',
        'imagen',
    ];
    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'nombre' => 'required|min:2',
        'base' => 'numeric'
        //'cero' => 'gt:0',
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
        'nombre.required' => 'Tenés que escribir el nombre para este cliente.',
        'nombre.min' => 'El Nombre tiene que tener al menos 2 caracteres.',
        'base.required' =>'Tenés que ingresar un valor para la base de la receta',
        'base.numeric' => 'El valor debe ser numérico',
      //  'cero.min' => 'El valor debe ser mayor de 0',
    ];

    public function recetaItem()
    {
        // belongsToMany() es el método para definir una relación n:n.
        // Este recibe unos cuántos parámetros más (aparte del modelo)
        // si no siguen las convenciones
        // de Laravel.
        // Segundo parámetro: "table" - La tabla pivot.
        // Tercer parámetro: "foreignPivotKey"
        //      El nombre de la FK para la tabla de _este_ modelo en la tabla pivot.
        //      En este caso, sería "pelicula_id" de "peliculas_tienen_generos".
        // Cuarto parámetro: "relatedPivotKey"
        //      El nombre de la FK para la tabla del _otro_ modelo en la tabla pivot.
        //      En este caso, sería "genero_id" de "peliculas_tienen_generos".
        // Quinto parámetro: "parentKey"
        //      El nombre de la PK de _este_ modelo al que la foreignPivotKey apunta.
        // Sexto parámetro: "relatedKey".
        //      La PK del _otro_ modelo al que relatedPivotKey apunta.
        return $this->hasMany(RecetaItem::class, 'receta_id', 'receta_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
    public function ingredientes(){
        return $this->belongsTo(Ingrediente::class, 'ingrediente_id', 'ingrediente_id');
    }
    public function tipos(){
        return $this->belongsTo(Tipo::class, 'tipo_id', 'tipo_id');
    }
}
