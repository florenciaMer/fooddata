<?php


namespace App\Repositories;
use App\Models\Cliente;
use App\Models\ClienteServicios;
use App\Models\Planificacion;
use App\Models\Usuario;
use App\Models\Etiqueta;

class ClienteServiciosRepository
{
    public function all()
    {
        $clienteServicios =ClienteServicios::all();

        return $clienteServicios;
    }


    public function allWhitParams($searchParams = [])
    {
        $etiqueta = Etiqueta::with(['unidad', 'categoria'])
            ->orderBy('nombre');

        if (isset($searchParams['nombre'])) {
            $etiqueta->where('nombre', 'like', '%' .
                $searchParams['nombre'] . '%');
        }
        return $etiqueta;
    }

    public function getByEtiqueta_id($etiqueta)
    {
        $existe =  ClienteServicios::where('etiqueta_id', '=', $etiqueta);
        return $existe;
    }
    public function getByClienteServicios_pk($pk)
    {
        $existe =  ClienteServicios::where('clienteServicios_id', '=', $pk);
        return $existe;
    }
    public function getByPrecio($request)
    {
        $existe =  ClienteServicios::where('clienteServicios_id', '=', $request->input('clienteServicios_id'))
        and ClienteServicios::where('precio', '=', $request->input('precio'));
        return $existe;
    }

    public function getByCliente_id($pk)
    {
        $existe =  ClienteServicios::where('cliente_id', '=', $pk);
        return $existe;
    }
    public function cantSearch($request)
    {
        if(ClienteServicios::where('precio', '=', $request->input('precio'))) {
            return true;
        }
        else {
            return false;
        }
    }

    public function update($pk, $data = [])
    {
        $clienteServicios = ClienteServicios::findOrFail($pk);
        $clienteServicios->update($data);

        return $clienteServicios;
    }
    /**
     * @param int $pk
     * @return Etiqueta|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Etiqueta::findOrFail($pk);
    }

    /**
     * @param int $pk
     * @return Etiqueta|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByClienteItem($pk)
    {
        return Cliente::findOrFail($pk);
    }

    public function servicesByClient($pk)
    {
        return ClienteServicios::where('cliente_id','=', $pk);
    }

    public function order($etiquetasQuery)
    {
        return $etiquetasQuery->orderBy('nombre');
    }

    /**
     * @param array $data
     * @return Etiqueta|\Illuminate\Database\Eloquent\Model
     */

    public function create($data = [])
    {
        return ClienteServicios::create($data);
    }

    public function delete($pk)
    {
        $etiqueta = Etiqueta::findOrFail($pk);

        $etiqueta->delete();

        return $etiqueta;
    }



    public function request($request, $array)
    {
        $data = $request->only($array);
        return $data;
    }
    public function searchClienteServicios($etiqueta)
    {
        $etiqueta = Etiqueta::where('etiqueta_id', $etiqueta->etiqueta_id)->has('clienteServicios')->count()>0;
        return $etiqueta;
    }


    public function ingGetByPkEnEtiquetas($pk)
    {
        return Etiqueta::findOrFail($pk);
    }
}
