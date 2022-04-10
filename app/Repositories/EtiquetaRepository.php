<?php


namespace App\Repositories;


use App\Models\ClienteServicios;
use App\Models\Etiqueta;
use App\Models\Planificacion;
use App\Models\PlanificacionItem;

class EtiquetaRepository
{
    public function all()
    {
        $etiqueta = Etiqueta::all()->sortBy('nombre');
        return $etiqueta;
    }

    public function getByName($request)
    {
        /*   return Etiqueta::where('nombre', 'like', '%' . $request
                       ->query('nombre') . '%')->count()>0;*/
        return Etiqueta::where('nombre', '=', $request->input('nombre'))->count() > 0;
    }
    /**
     * @param int $pk
     * @return Etiqueta|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Etiqueta::findOrFail($pk);
    }
    public function getByNameOnly($nombre)
    {
        $etiqueta= Etiqueta::where('nombre', 'like', '%' . $nombre)->count() >0;
        return $etiqueta;
    }
    public function getByEtiqPlanif($etiqueta)
    {
        $etiqueta= PlanificacionItem::where('etiqueta_id', '=',  $etiqueta)->count() >0;
        return $etiqueta;
    }

    public function getByClientServPlanif($etiqueta)
    {
        $etiqueta= ClienteServicios::where('etiqueta_id', '=',  $etiqueta)->count() >0;
        return $etiqueta;
    }
    /**
     * @param array $data
     * @return Etiqueta|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return Etiqueta::create($data);
    }

    public function update($pk, $data = [])
    {
        $etiqueta = Etiqueta::findOrFail($pk);
        $etiqueta->update($data);
        return $etiqueta;
    }

    public function delete($pk)
    {
        $ingrediente = Etiqueta::findOrFail($pk);

        $ingrediente->delete();

        return $ingrediente;
    }
    public function searchProducts($etiqueta)
    {
        $etiqueta = Etiqueta::where('etiqueta_id', $etiqueta)->count()>0;
        return $etiqueta;
    }
}
