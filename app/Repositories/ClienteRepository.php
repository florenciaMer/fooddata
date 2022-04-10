<?php


namespace App\Repositories;

use App\Models\Cliente;
use App\Models\Condicion;

use App\Models\Planificacion;
use Illuminate\Database\Eloquent\Collection;

class ClienteRepository
{
    public function all()
    {
//        $clientes =Cliente::select('cliente_id', 'nombre', 'nombreFantasia', 'direccion', 'condicion_id',
//            'usuario_id')->with(['condiciones'])
       $clientes = Cliente::all();

        return $clientes;
    }

    public function allWhitParams($searchParams = [])
    {
        $clientesQuery =Cliente::select('cliente_id', 'nombre', 'nombreFantasia', 'condicion_id', 'direccion',
            'usuario_id')->with(['condicion'])
            ->orderBy('nombre');
        if (isset($searchParams['nombre'])) {
            $clientesQuery->where('nombre', 'like', '%' .
                $searchParams['nombre'] . '%')
                ->orderBy('nombre');
        }

        return $clientesQuery->paginate(8);
    }

    public function getByName($request)
    {
        /*   return Cliente::where('nombre', 'like', '%' . $request
                       ->query('nombre') . '%')->count()>0;*/
        return Cliente::where('nombre', '=', $request->input('nombre'))->count() > 0;
    }

    public function getByNameFantasy($nombreFantasia)
    {
        $cliente= Cliente::where('nombrefantasia', 'like', '%' . $nombreFantasia)->count() >0;
        return $cliente;
    }
    /**
     * @param int $pk
     * @return Cliente|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getByPk($pk)
    {
        return Cliente::findOrFail($pk);
    }
    public function getByNameOnly($nombre)
    {
        $cliente= Cliente::where('nombre', 'like', '%' . $nombre)->count() >0;
        return $cliente;
    }
    /**
     * @param array $data
     * @return Cliente|\Illuminate\Database\Eloquent\Model
     */
    public function create($data = [])
    {
        return Cliente::create($data);
    }

    public function update($pk, $data = [])
    {
        $cliente = Cliente::findOrFail($pk);
        $cliente->update($data);
        return $cliente;
    }

    public function delete($pk)
    {
        $ingrediente = Cliente::findOrFail($pk);

        $ingrediente->delete();

        return $ingrediente;
    }
    public function searchProducts($cliente)
    {
        $cliente = Cliente::where('cliente_id', $cliente->cliente_id)->count()>0;
        return $cliente;
    }

    public function searchUsuario($cliente)
    {
        $usuario = Cliente::select('usuario_id')->where('cliente_id', $cliente->cliente_id);
        return $usuario;
    }
    public function getByPlaniCliente($cliente)
      {
          $cliente = Planificacion::where('cliente_id', $cliente->cliente_id)->has('cliente')->count()>0;
          return $cliente;
      }


}
