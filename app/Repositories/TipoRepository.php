<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Tipo;

class TipoRepository
{
    public function all()
    {
        $tipo = Tipo::all();
        return $tipo;
    }

    public function getByName($request)
    {
        /*   return Tipo::where('nombre', 'like', '%' . $request
                       ->query('nombre') . '%')->count()>0;*/
        return Tipo::where('nombre', '=', $request->input('nombre'))->count() > 0;
    }
    /**
     * @param int $pk
     * @return Tipo|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Tipo::findOrFail($pk);
    }
    public function getByNameOnly($nombre)
    {
        $tipo = Tipo::where('nombre', 'like', '%' . $nombre)->count() >0;
        return $tipo;
    }
    /**
     * @param array $data
     * @return Tipo|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return Tipo::create($data);
    }

    public function update($pk, $data = [])
    {
        $tipo = Tipo::findOrFail($pk);
        $tipo->update($data);
        return $tipo;
    }

    public function delete($pk)
    {
        $tipo = Tipo::findOrFail($pk);

        $tipo->delete();

        return $tipo;
    }

    public function searchRecetaTipo($tipo)
    {
        $tipo = Tipo::where('tipo_id', $tipo->tipo_id)->has('recetasTipo_id')->count()>0;
        return $tipo;
    }
}
