<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    protected $table = 'condiciones';
    protected $primaryKey = 'condicion_id';
    protected $fillable = [
        'condicion_id',
        'nombre',

    ];
    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'nombre' => 'required|min:3',

    ];
    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'nombre.min' => 'El nombre tiene que tener al menos 3 caracteres.',
        'nombre.required' => 'Tenés que completar el la categoría.',
    ];

    public function condiciones()
    {
        return $this->belongsTo(Condicion::class, 'condicion_id', 'condicion_id');
    }

}
