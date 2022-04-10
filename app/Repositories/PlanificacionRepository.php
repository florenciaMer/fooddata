<?php


namespace App\Repositories;


use App\Models\Cliente;
use App\Models\Planificacion;
use App\Models\PlanificacionItem;
use App\Models\Receta;

class PlanificacionRepository
{
    public function getByCliente_idReceta_idContexto($cliente_id, $receta_id, $contexto)
    {
        $planificacion =  Cliente::where('cliente_id', '=', $cliente_id)
        and Receta::where('receta_id', '=', $receta_id) and Receta::where('contexto', '=', $contexto);

        return $planificacion;
    }
    public function getByPk($pk)
    {
        return Planificacion::findOrFail($pk);
    }
    public function create($data = [])
    {
        return Planificacion::create($data);
    }
    public function update($pk, $data = [])
    {
        $planificacion = Planificacion::findOrFail($pk);
        $planificacion->update($data);
        return $planificacion;
    }

}
