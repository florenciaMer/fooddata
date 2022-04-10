<?php


namespace App\Repositories;

use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\Unidad;
use App\Models\Categoria;
use App\Models\Ingrediente;
use Illuminate\Database\Eloquent\Collection;
use Intervention\Image\Facades\Image;


class RecetaItemRepository
{

    public function all()
    {
        $recetaItem =RecetaItem::all();

        return $recetaItem;
    }

    public function allWhitParams($searchParams = [])
    {
        $ingrediente = Ingrediente::with(['unidad', 'categoria'])
            ->orderBy('nombre');

        if (isset($searchParams['nombre'])) {
                $ingrediente->where('nombre', 'like', '%' .
                $searchParams['nombre'] . '%');
            }
        return $ingrediente;
    }

    public function getByIngrediente_id($ingrediente)
    {
        $existe =  RecetaItem::where('ingrediente_id', '=', $ingrediente);
        return $existe;
    }
    public function getByRecetaITem_pk($pk)
    {
        $existe =  RecetaItem::where('recetaItem_id', '=', $pk);
        return $existe;
    }
    public function getByCant($request)
    {
        $existe =  RecetaItem::where('recetaItem_id', '=', $request->input('recetaItem_id'))
                    and RecetaItem::where('cant', '=', $request->input('cant'));
        return $existe;
    }

    public function getByReceta_id($pk)
    {
        $existe =  RecetaItem::where('receta_id', '=', $pk);
        return $existe;
    }
    public function cantSearch($request)
    {
        if(RecetaItem::where('cant', '=', $request->input('cant'))) {
            return true;
                }
            else {
                return false;
            }
        }
    /**
     * @param int $pk
     * @return Ingrediente|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Ingrediente::findOrFail($pk);
    }
    public function order($ingredientesQuery)
    {
        return $ingredientesQuery->orderBy('nombre');
    }

    /**
     * @param array $data
     * @return Ingrediente|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return RecetaItem::create($data);
    }

    public function update($pk, $data = [])
    {
        $ingrediente = Ingrediente::findOrFail($pk);
        $ingrediente->update($data);

        return $ingrediente;
    }

    public function delete($pk)
    {
        $ingrediente = Ingrediente::findOrFail($pk);

        $ingrediente->delete();

        return $ingrediente;
    }



    public function request($request, $array)
    {
        $data = $request->only($array);
        return $data;
    }
    public function searchRecetaItem($ingrediente)
    {
        $ingrediente = Ingrediente::where('ingrediente_id', $ingrediente->ingrediente_id)->has('recetaItem')->count()>0;
        return $ingrediente;
    }
    public function ingGetByPkEnIngredientes($pk)
    {
        return Ingrediente::findOrFail($pk);
    }
}
