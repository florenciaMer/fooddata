<?php


namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Unidad;

class UnidadRepository
{
    public function all()
    {
        $unidad = Unidad::all()->sortBy('nombre');
        return $unidad;
    }

    public function getByName($request)
    {
        /*   return Unidad::where('nombre', 'like', '%' . $request
                       ->query('nombre') . '%')->count()>0;*/
        return Unidad::where('nombre', '=', $request->input('nombre'))->count() > 0;
    }
    /**
     * @param int $pk
     * @return Unidad|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Unidad::findOrFail($pk);
    }
    public function getByNameOnly($nombre)
    {
        $unidad = Unidad::where('nombre', 'like', '%' . $nombre)->count() >0;
        return $unidad;
    }
    /**
     * @param array $data
     * @return Unidad|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return Unidad::create($data);
    }

    public function update($pk, $data = [])
    {
        $unidad = Unidad::findOrFail($pk);
        $unidad->update($data);
        return $unidad;
    }

    public function delete($pk)
    {
        $unidad = Unidad::findOrFail($pk);

        $unidad->delete();

        return $unidad;
    }
    public function searchProducts($unidad)
    {
        $unidad = Unidad::where('unidad_id', $unidad->unidad_id)->has('ingredientes')->count()>0;
        return $unidad;
    }
}

