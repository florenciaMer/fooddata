<?php


namespace App\Repositories;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Database\Eloquent\Collection;

class CategoriaRepository
{
    public function all()
    {
        $categoria = Categoria::all()->sortBy('nombre');
        return $categoria;
    }

    public function getByName($request)
    {
        /*   return Categoria::where('nombre', 'like', '%' . $request
                       ->query('nombre') . '%')->count()>0;*/
        return Categoria::where('nombre', '=', $request->input('nombre'))->count() > 0;
    }
    /**
     * @param int $pk
     * @return Categoria|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Categoria::findOrFail($pk);
    }
    public function getByNameOnly($nombre)
    {
        $categoria= Categoria::where('nombre', 'like', '%' . $nombre)->count() >0;
        return $categoria;
    }
    /**
     * @param array $data
     * @return Categoria|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return Categoria::create($data);
    }

    public function update($pk, $data = [])
    {
        $categoria = Categoria::findOrFail($pk);
        $categoria->update($data);
        return $categoria;
    }

    public function delete($pk)
    {
        $ingrediente = Categoria::findOrFail($pk);

        $ingrediente->delete();

        return $ingrediente;
    }
    public function searchProducts($categoria)
    {
        $categoria = Categoria::where('categoria_id', $categoria->categoria_id)->has('ingredientes')->count()>0;
        return $categoria;
    }
}

