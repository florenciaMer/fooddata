<?php


namespace App\Repositories;
use App\Models\PlanificacionItem;


class PlanificacionItemRepository
{
    public function getByPk($pk)
    {
        return PlanificacionItem::findOrFail($pk);
    }
    public function create($data = [])
    {
        return PlanificacionItem::create($data);
    }

    public function getByRec($request)
    {
        $existe =  PlanificacionItem::where('planificacion_id', '=', $request->input('planificacion_id'))
                  and PlanificacionItem::where('receta_id','=', $request->input('receta_id'));
        return $existe;
    }

    public function getByPlanificacion($request)
    {
        $planificacion = PlanificacionItem::select('planificacion_id','etiqueta_id','tipo_id',
                         'usuario_id','receta_id','cant_rec','planificacionItem_id')
                        ->where('planificacion_id', '=', $request->input('planificacion_id'))
                        ->get();
        return $planificacion;
    }
}
