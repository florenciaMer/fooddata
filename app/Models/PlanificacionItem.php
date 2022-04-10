<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanificacionItem extends Model
{
    protected $table = 'planificacion_item';
    protected $primaryKey = 'planificacionItem_id';
    protected $fillable = [
        'planificacion_id',
        'usuario_id',
        'receta_id',
        'fecha',
        'etiqueta_id',
        'cant_rec',
        'tipo_id',
    ];
    /** @var string[] Las reglas de validación. */
    public static $rules = [
        'cant_rec' => 'required'
    ];
    /** @var string[] Los mensajes personalizados de error para las $rules. */
    public static $errorMessages = [
        'cant_rec.required' => 'Tenés que ingresar una cantidad.',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id', 'tipo_id');
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id', 'receta_id');
    }
    public function etiqueta()
    {
        return $this->belongsTo(Receta::class, 'etiqueta_id', 'etiqueta_id');
    }
    public function planificacion()
    {
        return $this->belongsTo(Planificacion::class, 'planificacion_id', 'planificacion_id');
    }
}
