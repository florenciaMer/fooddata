<?php


namespace App\Repositories;
 use App\Models\RecetaItem;
 use App\Models\Unidad;
    use App\Models\Categoria;
    use App\Models\Ingrediente;
    use Illuminate\Database\Eloquent\Collection;
    use Intervention\Image\Facades\Image;

    class IngredienteRepository
{
    /**
     * @param array $searchParams
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Ingrediente[]|Collection
     */
    public function allWhitParams($searchParams = [])
    {
        $ingredientesQuery = Ingrediente::select('categoria_id',
            'nombre', 'ingrediente_id','unidad_id','impuesto','precio')->with(['unidad', 'categoria'])
            ->orderBy('nombre');

        if (isset($searchParams['nombre'])) {
            $ingredientesQuery->where('nombre', 'like', '%' .
                $searchParams['nombre'] . '%')->orderBy('nombre');
        }
        return $ingredientesQuery->paginate(8);
    }

    public function all()
    {
        $ingredientesQuery =Ingrediente::select('categoria_id',
            'nombre', 'ingrediente_id','unidad_id','impuesto')->with(['unidad', 'categoria'])
            ->orderBy('nombre');

        return $ingredientesQuery->paginate(8);
    }

        public function getByName($request)
        {
            return Ingrediente::where('nombre', 'like', '%' . $request
                        ->query('nombre') . '%')->count()==0;
        }

//        public function getUnidad_id($ingrediente)
//        {
//             $unidad = Ingrediente::select('unidad_id')
//                 ->where('ingrediente_id', '=', $ingrediente);
//                return $unidad;
//        }
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
        return Ingrediente::create($data);
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

    public function cargarImagen($request)
    {
        $imagen = $request->file('imagen');
        $nombreImagen = md5(time()) . '.' . $imagen->clientExtension();
        Image::make($imagen)->resize(200, 200, function ($constraint) {
            $constraint->upsize();
            $constraint->aspectRatio();
        })->save(storage_path('app/public/img/' . $nombreImagen));
        return $nombreImagen;
    }

    public function getByNameOnly($nombre)
    {
        $ingrediente = Ingrediente::where('nombre', 'like', '%' . $nombre)->count() > 0;
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
}

