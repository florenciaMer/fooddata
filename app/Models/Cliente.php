<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CondicionController;
use App\Http\Controllers\ClienteController;

/**
 * App\Models\ClienteController
 *
 * @property int $cliente_id
 * @property string $nombre
 * @property string $nombreFantasia
 * @property string $direccion
 * @property string $condicion
 * @property int $usuario_id


 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereClienteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereNombreFansasia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereCondicionId($value)

 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Cliente whereUsuarioId($value)
 * @property-read \App\Models\Usuario $usuario
 *
 */


class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'cliente_id';
    protected $fillable = [
        'cliente_id',
        'nombre',
        'nombreFantasia',
        'direccion',
        'condicion_id',
        'usuario_id',
        'etiqueta_id',
        'precio'
    ];
    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'nombre' => 'required|min:3',
        'nombreFantasia' => 'required|min:3',
        'direccion' => 'required|min:3',

    ];
    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'nombre.min' => 'La categoría tiene que tener al menos 3 caracteres.',
        'nombre.required' => 'Tenés que completar el nombre.',
        'nombreFantasia.required' => 'Tenés que completar el nombre fantasía.',
        'direccion.required' => 'Tenés que completar la dirección.',
    ];
    public function condicion()
    {
        return $this->belongsTo(Condicion::class, 'condicion_id', 'condicion_id');
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
    public function etiqueta()
    {
        return $this->belongsTo(Etiqueta::class, 'etiqueta_id', 'etiqueta_id');
    }
}
