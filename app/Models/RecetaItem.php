<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $recetaItem_id
 * @property int $receta_id
 * @property int $ingrediente_id
 * @property integer $cant
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem whereU_med($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem whereIngredienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecetaItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class RecetaItem extends Model
{
    protected $table = 'recetasItems';
    protected $primaryKey = 'recetaItem_id';

    protected $fillable = [
        'receta_id',
        'ingrediente_id',
        'cant'
    ];

    public static $cant_add = [
        'cant_add' => 'required|numeric'
    ];
    public static $rules = [
        'cant' => 'required',
        // 'imagen'    => 'image'
    ];

    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'cant.required' => 'Tenés que ingresear una cantidad.',
        'cant_add.required' => 'Tenés que ingresear una cantidad.',
        'cant_add.numeric' => 'El valor debe ser numérico.',
    ];

    public function ingrediente(){
        return $this->belongsTo(Ingrediente::class, 'ingrediente_id', 'ingrediente_id');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
}
