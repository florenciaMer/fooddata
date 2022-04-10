<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteServicios;
use App\Models\Condicion;
use App\Models\Etiqueta;
use App\Models\Planificacion;
use App\Models\Usuario;
use App\Repositories\ClienteRepository;
use App\Repositories\ClienteServiciosRepository;
use App\Repositories\CondicionesRepository;
use http\Client;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;
use Illuminate\Http\Request;
use http\Params;
use Illuminate\Bus\PrunableBatchRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;
use function PHPUnit\Framework\isEmpty;


class ClienteController extends Controller
{
    protected $repository;
    protected $repositoryClienteServicios;
    /**
     *
     * @param ClienteRepository $repository
     */

    /**
     *
     * @param ClienteServiciosRepository $repositoryClienteServicios
     */
    public function __construct(ClienteRepository $repository, ClienteServiciosRepository $repositoryClienteServicios)

    {
        $this->repository = $repository;
        $this->repositoryClienteServicios = $repositoryClienteServicios;
    }
    public function nuevo()
    {
        $condiciones = Condicion::all();

        return view('clientes.nuevo', compact('condiciones'));
    }

    public function index(){
        /** @var TYPE_NAME $clientes */

        $clientes =$this->repository->all();

        return view('clientes.index', compact('clientes'));
    }

    public function crear(Request $request)
    {
        $request->validate(Cliente::$rules, Cliente::$errorMessages);

        //si no existe el ingrediente lo crea
        if (!$this->repository->getByNameOnly($request->input('nombre'))) {

            $encontradoNombreFantasia = DB::table('clientes')
                    //encuentra el nombre y es de otro cliente
                    ->where('cliente_id', '!=', $request->input('cliente_id'))
                    ->where('nombreFantasia', '=', $request->input('nombreFantasia'))
                    ->count()>0;

            if ($encontradoNombreFantasia) {
                //encuentra el nombre y es de el
                return redirect()
                    ->route('clientes.index')
                    ->with('message', 'Ya existe un cliente con ese nombre fantasía.')
                    ->with('message_type', 'danger');
            }

            $data =$request->only(['usuario_id', 'nombre', 'nombreFantasia', 'direccion', 'condicion_id', 'unidad_id']);
            $cliente = $this->repository->create($data);

            return redirect()->route('clientes.index')
                ->with('message', 'El Cliente se creó exitosamente.')
                ->with('message_type', 'success');

        } else {
            return redirect()->route('clientes.index')
                ->with('message', 'Ya existe un cliente con ese nombre.')
                ->with('message_type', 'danger');
        }
    }

    public function eliminar(Request $request,Cliente $cliente)
    {
        $existeEnPlanif = $this->repository->getByPlaniCliente($cliente);

        if ($existeEnPlanif !=1) {
                $cliente->delete();

//            $request->session()->flash('message', 'El Cliente se eliminó correctamente');
//            $request->session()->flash('message_type', 'success');

                return redirect()->route('clientes.index')
                    ->with('message', 'El Cliente se eliminó exitosamente.')
                    ->with('message_type', 'success');

            }else {
//            $request->session()->flash('message', 'El Cliente está siendo utilizado en la planificación');
//            $request->session()->flash('message_type', 'danger');
                return redirect()->route('clientes.index')
                         ->with('message', 'El Cliente está siendo utilizado en la planificación.')
                         ->with('message_type', 'danger');
            }
        }


    public function editarForm(Request $request, Cliente $cliente)
    {
        $formParams['nombre'] = '';
        $condiciones = Condicion::all();

//        if (isset($formParams['nombre'])) {

            $formParams['nombre'] = $request->query('nombre');

            $clientesQuery = Cliente::select('cliente_id',
                'nombre')
                ->orderBy('nombre');

            if (isset($searchParams['nombre'])) {
                $clientesQuery->where('nombre', 'like', '%' .
                    $searchParams['nombre'] . '%')->orderBy('nombre');
            }

            if ($clientes = $this->repository->allWhitParams($formParams)) {

                $pr = $this->repository->getByName($request);
                if ($pr) {
                    $request->session()->flash('message', 'El Cliente no existe');
                    $request->session()->flash('message_type', 'danger');
                    $clientes = $this->repository->all();
                }
            }

            $clientes = Cliente::all()->sortBy('nombre');
            $clienteServicios = ClienteServicios::where('cliente_id','=',$cliente->cliente_id)->get();
            $etiquetas = Etiqueta::all();
            $usuarios = Usuario::all();
            $condiciones = Condicion::all();
            $clienteEncontrado = '';

//            $usuario = Cliente::select('usuario_id')->where('cliente_id','=', $cliente->cliente_id)->get();

            $usuario = DB::table('clientes')
                        ->selectRaw('usuario_id')
                        ->where('cliente_id','=', $cliente->cliente_id)
                        ->get();

            $usuario = DB::table('usuarios')
                        ->selectRaw('usuario_id')
                        ->where('usuario_id','=',$usuario[0]->usuario_id)
                        ->get();
//            $usuario = Usuario::select('usuario_id')->where('usuario_id','=', $usuario[0]->usuario_id)->get();

            $etiquetasLista = DB::table('etiquetas')
                ->join('clienteservicios', 'etiquetas.etiqueta_id', '!=', 'clienteservicios.etiqueta_id')
                ->where('clienteservicios.cliente_id', '=',$cliente)
                ->select('etiquetas.nombre')
                ->get();

            return view('clientes/editar', compact('cliente', 'condiciones','etiquetas','clienteServicios','usuarios','formParams',
                'clienteEncontrado','etiquetasLista','usuario'));

        }

    public function editar(Request $request, Cliente $cliente)
    {
        $request->validate(Cliente::$rules, Cliente::$errorMessages);

        $encontradoNombre = DB::table('clientes')
            //encuentra el nombre y es de otro cliente
            ->where('cliente_id', '=', $request->input('cliente_id'))
            ->where('nombre', '=', $request->input('nombre'))
            ->where('direccion', '=', $request->input('direccion'))
            ->where('nombreFantasia', '=', $request->input('nombreFantasia'))
            ->count()>0;

        if ($encontradoNombre) {
            //encuentra el nombre y es de el
            $this->repository->update($request->input('cliente_id'),
            $request->only(['cliente_id', 'nombre', 'nombreFantasia', 'direccion','usuario_id','condicion_id']));

            return redirect()->route('clientes.editar', compact('cliente'))
                ->with('message', 'El cliente fue editado exitosamente!.')
                ->with('message_type', 'success');
        }

        $encontradoNombreFantasia = DB::table('clientes')
                //encuentra el nombre y es de otro cliente
                ->where('cliente_id', '!=', $request->input('cliente_id'))
                ->where('nombreFantasia', '=', $request->input('nombreFantasia'))
                ->count()>0;

        if ($encontradoNombreFantasia) {
            //encuentra el nombre y es de el
            return redirect()->route('clientes.editar', compact('cliente'))
                ->with('message', 'Ya existe un cliente con ese nombre!.')
                ->with('message_type', 'danger');
        }

        $cliente = DB::table('clientes')
            //encuentra el nombre y es de otro cliente
            ->where('cliente_id', '!=', $request->input('cliente_id'))
            ->where('nombre', '=', $request->input('nombre'))
            ->count();

        //otro cliente tiene ese nombre

        if ($cliente) {
            return redirect()
                ->route('clientes.index')
                ->with('message', 'El nombre del cliente ya existe en nuestros registros.'.$encontradoNombre)
                ->with('message_type', 'danger');
        }

        $grabar = DB::table('clientes')
            //su propio nombre
            ->where('cliente_id', '!=', $request->input('cliente_id'))
            ->where('nombre', '!=', $request->input('nombre'))
            ->count();
        if ($grabar) {
            $this->repository->update($request->input('cliente_id'),
                $request->only(['cliente_id', 'nombre', 'nombreFantasia', 'direccion','usuario_id','condicion_id']));

            return redirect()
                ->route('clientes.index')
                ->with('message', 'El cliente fue editado correctamente.'.$encontradoNombre)
                ->with('message_type', 'success');
        }
    }

}
