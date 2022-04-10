<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioPlanificado extends Model
{
    protected $table = 'serviciosPlanificados';
    protected $primaryKey = 'servicioPlanificado_id';

    protected $fillable = [
                            'fecha',
                            'dia',
                            'contexto',
                            'planificacion_id',
                            'planificacionITem_id',
                            'receta',
                            'etiqueta',
                            'cliente_id',
                            'usuario_id',
                            'observaciones',
                            'cant_rec',
                            'tipoNombre'
                        ];
}
