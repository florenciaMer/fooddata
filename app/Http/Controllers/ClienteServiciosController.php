<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Condicion;
use App\Models\Etiqueta;
use App\Models\Planificacion;
use App\Models\PlanificacionItem;
use App\Models\Usuario;
use App\Repositories\ClienteRepository;
use App\Repositories\EtiquetaRepository;
use App\Repositories\ClienteServiciosRepository;
use App\Repositories\IngredienteRepository;
use App\Repositories\RecetaItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClienteServicios;

use http\Params;
use Illuminate\Bus\PrunableBatchRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ClienteServiciosController extends Controller
{
    protected $repository;
    protected $repositoryEtiq;
    protected $repositoryClienteServicios;


    /**
     * @param ClienteServiciosRepository $repository
     */

    /**
     * @param  ClienteRepository $repositoryCliente
     */

    /**
     * @param EtiquetaRepository $repositoryEtiq
     */


    public function __construct(ClienteServiciosRepository $repository, EtiquetaRepository $repositoryEtiq, ClienteRepository $clienteRepository)
    {
        $this->repository = $repository;
        $this->repositoryEtiq = $repositoryEtiq;
        $this->repossitoryCliente = $clienteRepository;
    }


    public function index($cliente_id)
    {
        $formParams['nombre'] = '';
        $clientes = Cliente::all()->sortBy('nombre');

        $cliente = Cliente::findOrFail($cliente_id);
        $clienteServicios = ClienteServicios::all();
        $clienteServicios = $clienteServicios->where('$cliente_id', '=', $cliente_id);
        $etiquetas = Etiqueta::all();
        $usuarios = Usuario::all();
        $condiciones = Condicion::all();

        $usuario = DB::table('clientes')
            ->selectRaw('usuario_id')
            ->where('cliente_id','=', $cliente->cliente_id)
            ->get();

        $usuario = DB::table('usuarios')
            ->selectRaw('usuario_id')
            ->where('usuario_id','=',$usuario[0]->usuario_id)
            ->get();


        return view('clientes.editar', compact('cliente', 'clienteServicios',
            'etiquetas', 'usuarios','formParams','condiciones','usuario'));
    }

    public function indexEtiquetasSearch(Request $request, $cliente_id)
    {
//        $request->session()->flash('message', '');
//        $request->session()->flash('message_type', 'transparent');


        $formParams['nombre'] = [];

        $cliente = Cliente::findOrFail($cliente_id);
        $etiquetas = $this->repositoryEtiq->all()->sortBy('nombre');
        $clienteServicios = ClienteServicios::all()->where('cliente_id', '=', $cliente_id);
        $etiquetas = Etiqueta::all();
        $usuarios = Usuario::all();

        if (isset($formParams['nombre'])) {

            $formParams['nombre'] = $request->query('nombre');
            $etiquetas = $this->repository->allWhitParams($formParams);
            $etiquetaEncontrada = Etiqueta::where('nombre', 'like', '%' .
                $formParams['nombre'] . '%');

            if ($etiquetaEncontrada = $this->repository->allWhitParams($formParams)) {

                $pr = $this->repositoryEtiq->getByName($request);
                if ($pr) {
                    $etiquetas = $this->repositoryEtiq->all();
                    $request->session()->flash('message', 'El Cliente no existe');
                    $request->session()->flash('message_type', 'danger');

                    return view('clientes.editar', compact('cliente',
                        'clienteServicios', 'etiquetas', 'usuarios','formParams'));
                }
            } else {
                return view('clientes.editar', compact('cliente',
                    'clienteServicios', 'etiquetas', 'usuarios','formParams'));
            }

            $etiquetas = $this->repositoryEtiq->all();
            $etiquetaEncontrada = Etiqueta::select('etiqueta_id',
                'nombre')
                ->where('nombre', 'like', '%' . $formParams['nombre'] . '%')
                ->orderBy('nombre')
                ->get();

            $request->session()->flash('message', 'Ya podés seleccionar el producto');
            $request->session()->flash('message_type', 'success');

            return view('clientes.editar', compact('cliente',
                'clienteServicios', 'etiquetas', 'usuarios','formParams','etiquetaEncontrada'));
        }
    }


    public function nuevo($cliente_id)
    {
        $etiquetas = Etiqueta::all()->sortBy('nombre');

        $cliente = Cliente::findOrFail($cliente_id);
        $clienteServicios = ClienteServicios::all();
        $clienteServicios = $clienteServicios->where('cliente_id', '=', $cliente_id);
        $usuarios = Usuario::all();

        return view('clientes/clienteServicios.nuevo', compact('cliente', 'etiquetas', 'clienteServicios', 'cliente_id','usuarios'));
    }

    public function eliminar($etiqueta_id, $cliente_id)
    {
        //elimino el servicio para ese cliente
        $formParams['nombre'] = '';
        $cliente = Cliente::findOrFail($cliente_id);

        $etiquetas = Etiqueta::all()->sortBy('nombre');
        $etiqueta = Etiqueta::all()->sortBy('nombre');
        $condiciones = Condicion::all();
        $clienteServicios = ClienteServicios::all();
        $clienteServicios = $clienteServicios->where('cliente_id', '=', $cliente_id);
        $usuarios = Usuario::all();

        //existe en planif

        $planificacion = Planificacion::selectRaw('*')
                    ->where('cliente_id', '=', $cliente_id)->get();

        $clienteServicio = DB::table('planificacion')
            ->join('planificacion_item', 'planificacion.planificacion_id', '=',
                'planificacion_item.planificacion_id')
              ->select('*')
            ->where('planificacion.cliente_id', '=', $cliente_id)
            ->where('planificacion_item.etiqueta_id','=', $etiqueta_id)
            ->count()>0;


        if ($clienteServicio >0) {

//            $request->session()->flash('message', 'El Servicio ya existe para ese cliente');
//            $request->session()->flash('message_type', 'danger');
//
//            return view('clientes/editar',
//                compact('cliente', 'clienteServicios', 'etiquetas',
//                    'usuarios', 'formParams', 'condiciones'));

//*********************************

//            return view('clientes/editar',
//                compact('cliente', 'clienteServicios', 'etiquetas',
//                    'usuarios', 'formParams', 'condiciones'));

            return redirect()->route('clientes.editar', compact('cliente'))
                ->with('message', 'El Servicio se está utilizando en la planificación')
                ->with('message_type', 'danger');

//            return redirect()->route('clientes.index', compact($cliente))
//                ->with('message', 'El Servicio se está utilizando en la planificación')
//                ->with('message_type', 'danger');

        } else {

            $eliminar = DB::table('clienteservicios')
                    ->where('etiqueta_id', '=', $etiqueta_id)
                    ->where('cliente_id', '=', $cliente_id)
                    ->delete();
            $cliente = Cliente::findOrFail($cliente_id);
            $etiquetas = Etiqueta::all()->sortBy('nombre');
            $etiqueta = Etiqueta::all()->sortBy('nombre');
            $condiciones = Condicion::all();
            $clienteServicios = ClienteServicios::all();
            $clienteServicios = $clienteServicios->where('cliente_id', '=', $cliente_id);
            $usuarios = Usuario::all();


//            $request->session()->flash('message', 'El Servicio ya existe para ese cliente');
//            $request->session()->flash('message_type', 'danger');
//

            return redirect()->route('clientes.editar', compact('cliente'))
                ->with('message', 'El Servicio fue eliminado correctamente')
                ->with('message_type', 'success');


//            return view('clientes/editar',
//                compact('cliente', 'clienteServicios', 'etiquetas',
//                    'usuarios', 'formParams', 'condiciones'))
//                    ->with('message', 'El Servicio fué eliminado con éxito!.')
//                    ->with('message_type', 'success');


//            return redirect()->route('clientes.index', compact($cliente))
//                ->with('message', 'El Servicio ha sido eliminado exitosamente')
//                ->with('message_type', 'success');
        }
    }


    public function editar(Request $request, $cliente)
    {
       $request->validate(ClienteServicios::$rules, ClienteServicios::$errorMessages);
        $formParams['nombre'] = '';

        $existe = DB::table('clienteservicios')
            ->where('cliente_id', '=', $request->input('cliente_id'))
            ->where('etiqueta_id', '=', $request->input('etiqueta_id'))
            ->where('clienteServicio_id','!=' , $request->input('clienteServicio_id'))
            ->count();
        //etiqueta ya existe

        if ($existe > 0){

            $request->session()->flash('message', 'El Servicio ya existe para ese cliente');
            $request->session()->flash('message_type', 'danger');

            return view('clientes/editar',
                compact('cliente', 'clienteServicios', 'etiquetas',
                    'usuarios', 'formParams', 'condiciones'));

        }else {
            $clienteServicio = ClienteServicios::where('clienteServicio_id', '=', $request->input('clienteServicio_id'));
            //linea editable
            $clienteServicio->update($request->only(['cliente_id', 'precio','usuario_id','etiqueta_id']));
            $cliente = Cliente::findOrFail($request->input('cliente_id'));
            $etiquetas = Etiqueta::all()->sortBy('nombre');
            $etiqueta = Etiqueta::all()->sortBy('nombre');
            $condiciones = Condicion::all();
            $clienteServicios = ClienteServicios::all();
            $clienteServicios = $clienteServicios->where('cliente_id', '=',$request->input('cliente_id'));
            $usuarios = Usuario::all();

            $usuario = DB::table('clientes')
                ->selectRaw('usuario_id')
                ->where('cliente_id','=', $cliente->cliente_id)
                ->get();

            $usuario = DB::table('usuarios')
                ->selectRaw('usuario_id')
                ->where('usuario_id','=',$usuario[0]->usuario_id)
                ->get();

//            $request->session()->flash('message', 'El Servicio fué editado correctamente');
//            $request->session()->flash('message_type', 'success');

//            return view('clientes/editar',
//                       compact('cliente', 'clienteServicios', 'etiquetas',
//                           'usuarios', 'formParams', 'condiciones','usuario'));

            return redirect()->route('clientes.editar', compact('cliente'))
                ->with('message', 'El Cliente fue editado correctamente')
                ->with('message_type', 'success');
//                   mensaje se edito
        }

    }
    public function agregar(Request $request)
    {
//        $request->validate(ClienteServicios::$cant_add, ClienteServicios::$errorMessages);

        $formParams['nombre'] = '';


        $existe = DB::table('clienteservicios')
                //si no existe
                ->where('cliente_id', '=', $request->input('cliente_id'))
                ->where('etiqueta_id', '=', $request->input('etiqueta_id'))
                ->count() == 0;

        if ($existe) {
//NO existe ese servicio para el cliente
            $data =$request->only(['usuario_id', 'cliente_id', 'precio', 'etiqueta_id']);
            $cliente = $this->repository->create($data);


        $cliente = Cliente::findOrFail($request->input('cliente_id'));

        $clientes = Cliente::all()->sortBy('nombre');
        $clienteServicios = ClienteServicios::where('cliente_id','=',$cliente->cliente_id)->get();
        $etiquetas = Etiqueta::all();
        $usuarios = Usuario::all();
        $condiciones = Condicion::all();
        $clienteEncontrado = '';

        $etiquetasLista = DB::table('etiquetas')
            ->join('clienteservicios', 'etiquetas.etiqueta_id', '!=', 'clienteservicios.etiqueta_id')
            ->where('clienteservicios.cliente_id', '=',$cliente)
            ->select('etiquetas.nombre')
            ->get();

            return redirect()->route('clientes.editar', compact('cliente'))
                ->with('message', 'El Cliente fue creado exitosamente')
                ->with('message_type', 'success');

    }else{
            $cliente = Cliente::findOrFail($request->input('cliente_id'));

            $etiquetasLista = DB::table('etiquetas')
                ->join('clienteservicios', 'etiquetas.etiqueta_id', '!=', 'clienteservicios.etiqueta_id')
                ->where('clienteservicios.cliente_id', '=', $request->input('cliente_id'))
                ->select('etiquetas.nombre')
                ->get();

            $clientes = Cliente::all()->sortBy('nombre');
            $clienteServicios = ClienteServicios::where('cliente_id','=',$cliente->cliente_id)->get();
            $etiquetas = Etiqueta::all();
            $usuarios = Usuario::all();
            $condiciones = Condicion::all();
            $clienteEncontrado = '';

            $request->session()->flash('message', 'El Servicio ya existe para ese cliente');
            $request->session()->flash('message_type', 'danger');

            $etiquetasLista = DB::table('etiquetas')
                ->join('clienteservicios', 'etiquetas.etiqueta_id', '!=', 'clienteservicios.etiqueta_id')
                ->where('clienteservicios.cliente_id', '=',$cliente)
                ->select('etiquetas.nombre')
                ->get();

//            return view('clientes/editar', compact('cliente', 'condiciones','etiquetas','clienteServicios','usuarios','formParams',
//                'clienteEncontrado','etiquetasLista'))
//                ->with('message', 'Ya existe ese Servicio para ese cliente')
//                ->with('message_type','success');

            return redirect()->route('clientes.editar', compact('cliente'))
                ->with('message', 'Ya existe ese servicio para ese cliente')
                ->with('message_type', 'danger');

        }
    }
}
