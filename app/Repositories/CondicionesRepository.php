<?php


namespace App\Repositories;
use App\Models\Condicion;

class CondicionesRepository
{
    public function all()
    {
        $condicion = Condicion::all()->sortBy('nombre');
        return $condicion;
    }

    public function getByName($request)
    {
        /*   return Condicion::where('nombre', 'like', '%' . $request
                       ->query('nombre') . '%')->count()>0;*/
        return Condicion::where('nombre', '=', $request->input('nombre'))->count() > 0;
    }
    /**
     * @param int $pk
     * @return Condicion|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Condicion::findOrFail($pk);
    }
    public function getByNameOnly($nombre)
    {
        $condicion= Condicion::where('nombre', 'like', '%' . $nombre)->count() >0;
        return $condicion;
    }
    /**
     * @param array $data
     * @return Condicion|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return Condicion::create($data);
    }

    public function update($pk, $data = [])
    {
        $condicion = Condicion::findOrFail($pk);
        $condicion->update($data);
        return $condicion;
    }

    public function delete($pk)
    {
        $ingrediente = Condicion::findOrFail($pk);

        $ingrediente->delete();

        return $ingrediente;
    }
    public function searchProducts($condicion)
    {
        $condicion = Condicion::where('condicion_id', $condicion->condicion_id)->count()>0;
        return $condicion;
    }
}
