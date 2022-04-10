<?php


namespace App\Repositories;
use App\Models\Ingrediente;
use App\Models\Planificacion;
use App\Models\Receta;
use Illuminate\Database\Eloquent\Collection;
use App\Models\RecetaItem;
use Illuminate\Support\Facades\DB;

class RecetasRepository
{
    /**
     * @param array $searchParams
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Receta[]|Collection
     */
    public function allWhitParams($searchParams = [])
    {
        $recetasQuery =Receta::select('receta_id', 'nombre', 'descripcion', 'tipo_id', 'base',
            'usuario_id')->with(['recetaItem', 'ingredientes'])
            ->orderBy('nombre');
        if (isset($searchParams['nombre'])) {
            $recetasQuery->where('nombre', 'like', '%' .
                $searchParams['nombre'] . '%')
            ->orderBy('nombre');
        }

        return $recetasQuery->paginate(8);
    }

    public function all()
    {
        $recetasQuery =Receta::select('receta_id', 'nombre', 'descripcion', 'tipo_id', 'base',
            'usuario_id')->with(['recetaItem', 'ingredientes'])
            ->orderBy('nombre');

        return $recetasQuery->paginate(8);
    }

    public function getByName($nombre)
    {
        $receta = Receta::where('nombre', 'like', '%' . $nombre)->count() > 0;
        return $receta;
    }

    public function existsPlanif($receta_id)
    {
        $receta = Planificacion::where('receta_id', '=',  $receta_id)->count() > 0;
        return $receta;
    }
    /**
     * @param int $pk
     * @return Receta|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Receta::findOrFail($pk);
    }

    /**
     * @param array $data
     * @return Receta|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return Receta::create($data);
    }

    public function update($pk, $data = [])
    {
        $receta = Receta::findOrFail($pk);
        $receta->update($data);

        return $receta;
    }

    public function delete($pk)
    {
        $receta = Receta::findOrFail($pk);

        $receta->delete();

        return $receta;
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
        $receta = Receta::where('nombre', 'like', '%' . $nombre)->count() > 0;
        return $receta;
    }

    public function request($request, $array)
    {
        $data = $request->only($array);
        return $data;
    }

    public function getByRecetaItem($pk)
    {
        $recetaITem =  RecetaItem::all();
        $recetaITem = $recetaITem->where('receta_id', '=', $pk);

        return $recetaITem;
    }
}
