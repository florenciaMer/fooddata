<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteServicios;
use App\Models\Etiqueta;
use App\Models\Ingrediente;
use App\Models\PlanificacionItem;
use App\Models\Receta;
use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Planificacion;
use App\Repositories\PlanificacionRepository;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\This;
use function PHPUnit\Framework\isEmpty;

use Illuminate\Database\Eloquent\Collection;

class PlanificacionController extends Controller
{
    protected $repository;
    /**
     *
     * @param PlanificacionRepository $repository
     */
    public function __construct(PlanificacionRepository $repository)

    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('planificacion.index');
    }

    public function indexCarga()
    {
        $clientes = Cliente::all();
        $recetas = Receta::all();
        $tipos = Tipo::all();
        $planificacion = Planificacion::all();
        return view('/planificacion/planificacionservicios.indexCarga',compact('clientes','recetas','tipos','planificacion'));
    }

    public function agregarCabecera(Request $request)
    {
        $request->validate(Planificacion::$rules, Planificacion::$errorMessages);
        $recetas = Receta::all();
        $clientes = Cliente::all();
        $tipos = Tipo::all();
        $etiquetas = Etiqueta::all();

        $planificacionCargada = Planificacion::where('cliente_id', '=', $request->input('cliente_id'))
            ->where('fecha', '=', $request->input('fecha'))
            ->where('contexto', '=', $request->input('contexto'))
            ->get();

        //existe una planificacion cargada
        if (isset($_POST['cargar'])) {

            if ($planificacionCargada->isNotEmpty()) {
//dd($planificacionCargada);
                $planificacionItem = PlanificacionItem::where('planificacion_id', '=',
                        $planificacionCargada[0]->planificacion_id)
                        ->count() > 0; // existe item para esa planificacion

                if (!$planificacionItem) {
                    // si no hay planificacionItem tomo la planificada cargada y la envio a la view

                    $planificacion = DB::table('planificacion')
                        ->select('cliente_id', 'observaciones', 'planificacion_id', 'fecha', 'contexto', 'cant')
                        ->where('cliente_id', '=', $request->input('cliente_id'))
                        ->where('fecha', '=', $request->input('fecha'))
                        ->where('contexto', '=', $request->input('contexto'))
                        ->get();
//                $planificacionItem = $this->repository->getByPlanificacion($request);
                    $planificacionItem = Planificacion::where('planificacion_id', '=',
                        $planificacionCargada[0]->planificacion_id);

                    $recetas = Receta::all();
                    $clientes = Cliente::all();
                    $tipos = Tipo::all();
                    $etiquetas = Etiqueta::all();

                    $request->session()->flash('message', 'Podés comenzar a cargar datos.');
                    $request->session()->flash('message_type', 'success');
                    return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion',
                        'recetas', 'clientes', 'tipos', 'planificacionItem', 'etiquetas'));
                }
            } // fin planificacion cargada con datos
            $planificacion = Planificacion::all();

            $planificacion = DB::table('planificacion')
                    ->where('cliente_id', '=', $request->input('cliente_id'))
                    ->where('fecha', '=', $request->input('fecha'))
                    ->where('contexto', '=', $request->input('contexto'))
                    ->count() == 0;

            if ($request->input('observaciones') == '') {
                $observaciones = 'Sin observaciones';

            } else {
                $observaciones = $request->input('observaciones');
            }

            if ($planificacion)

                //no existe carga previa
//        if (count($planificacion) == 0)
            {
                $data = $request->only(['usuario_id', 'cliente_id', 'contexto', 'cant', 'fecha','observaciones']);
                $data['observaciones'] = $observaciones;
                $planificacion = $this->repository->create($data);
//dd($planificacion);

                $planificacion = Planificacion::select('*')
                    ->where('cliente_id', '=', $request->input('cliente_id'))
                    ->where('fecha', '=', $request->input('fecha'))
                    ->where('contexto', '=', $request->input('contexto'))
                    ->get();
//dd($planificacion);
//dd($planificacion[0]->planificacion_id);
                $planificacionItem = DB::table('planificacion_item')
                    ->selectRaw('*')
                    ->where('planificacion_id', '=', $planificacion[0]->planificacion_id)
                    ->get();
                $recetas = Receta::all();
                $clientes = Cliente::all();
                $tipos = Tipo::all();
                $etiquetas = Etiqueta::all();

                $request->session()->flash('message', 'Podés comenzar a cargar datos');
                $request->session()->flash('message_type', 'success');
                return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion',
                    'recetas', 'clientes', 'tipos', 'planificacionItem', 'etiquetas'));
            } else {
                //ya existe una planificacion para esa fecha
//valido si tiene carga item

                $planificacion = DB::table('planificacion')
                    ->where('cliente_id', '=', $request->input('cliente_id'))
                    ->where('fecha', '=', $request->input('fecha'))
                    ->where('contexto', '=', $request->input('contexto'))
                    ->get();

                $pla_id = $planificacion[0]->planificacion_id;

                $planificacionItem = PlanificacionItem::select('planificacion_id', 'usuario_id',
                        'cant_rec', 'tipo_id', 'receta_id', 'planificacionItem_id', 'etiqueta_id')
                        ->where('planificacion_id', '=', $pla_id)
                        ->get();

                if ($planificacionItem) ;
                {
                    $planificacion = Planificacion::select('*')
                        ->where('planificacion_id', '=', $pla_id)
                        ->get();

//****************************************************************dd($planificacion);
                    $request->session()->flash('message', 'Podés comenzar a cargar datos.!');
                    $request->session()->flash('message_type', 'success');
                    return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion',
                        'recetas', 'clientes', 'tipos', 'planificacionItem', 'etiquetas'));
                }
            }
        }else {

        //isset editar
                if ($request->input('observaciones') == '' || $request->input('observaciones') == 'nul' ) {
                    $observaciones = 'Sin observaciones';
                } else {
                    $observaciones = $request->input('observaciones');
                }
            //edito la cabecera

            $planificacionEdit = $this->repository->getByPk($request->input('planificacion_id'));

//            $planificacionEdit = Planificacion::selectRaw('*')
//                ->where('planificacion_id', '=', $request->input('planificacion_id'))
//                ->get();
            $planificacionEdit['observaciones'] =  $observaciones;
            $planificacionEdit->update($request->only(['fecha','cliente_id', 'usuario_id','cant','contexto']));
//dd($planificacionEdit);
            $planificacion = Planificacion::where('planificacion_id', '=',
                $request->input('planificacion_id'))
                ->get();

//            $planificacion = $this->repository->getByPk($planificacionCargada[0]->planificacion_id);
//dd($planificacion);
            $planificacionItem = PlanificacionItem::where('planificacion_id', '=',
                $request->input('planificacion_id'))->get();

            $recetas = Receta::all();
            $clientes = Cliente::all();
            $tipos = Tipo::all();
            $etiquetas = Etiqueta::all();

            $request->session()->flash('message', 'La planificación fue editada exitosamente.');
            $request->session()->flash('message_type', 'success');
//dd($planificacionItem);
            return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion',
                'recetas', 'clientes', 'tipos', 'planificacionItem', 'etiquetas'));
            }
    }

    public function editarCabecera(Request $request, $planificacion_id)
    {
        //verifico si carga o edita

        $recetas = Receta::all();
        $clientes = Cliente::all();
        $tipos = Tipo::all();
        $etiquetas = Etiqueta::all();

        $planificacionItem = DB::table('planificacion_item')
            ->where('planificacion_id', '=', $request->input('planificacion_id'))
            ->get();
        if ($nombreBoton = 'cargar') {

//        $request->validate(Planificacion::$rules, Planificacion::$errorMessages);
            $existe = DB::table('planificacion')
                ->where('cliente_id', '=', $request->input('cliente_id'))
                ->where('fecha', '=', $request->input('fecha'))
                ->where('contexto', '=', $request->input('contexto'))
                ->count();

            if ($existe > 0) {

                $request->session()->flash('message', 'Ya existe una planificacion con esa descripción   ');
                $request->session()->flash('message_type', 'danger');
                return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion',
                    'recetas', 'clientes', 'tipos', 'planificacionItem', 'etiquetas'));

            } else {
                $planificacion = Planificacion::all();
                $planificacion = $planificacion
                    ->where('planificacion_id', '=', $request->input('planificacion_id'))
                    ->where('fecha', '=', $request->input('fecha'));

                $planificacion = $this->repository->getByPk($planificacion_id);
                $planificacion->update($request->only(['fecha', 'contexto', 'cliente_id', 'cant']));

                $request->session()->flash('message', 'La Planificación fué editada Exitosamente ');
                $request->session()->flash('message_type', 'success');

                $planificacion = Planificacion::all();
                $planificacion = $planificacion->where('planificacion_id', '=', $request->input('planificacion_id'));

                return view('/planificacion/planificacionservicios.indexCargaItem',
                    compact('planificacion', 'recetas', 'clientes', 'tipos',
                        'planificacionItem', 'etiquetas'));
            }
            $planificacion = Planificacion::all();
            $planificacion = $planificacion
                ->where('planificacion_id', '=', $request->input('planificacion_id'))
                ->where('fecha', '!=', $request->input('fecha'));


            $planificacion_id_ant = $this->repository->getByPk($planificacion_id);
            $planificacion = Planificacion::all();
            $planificacion->create($request->only(['fecha', 'contexto', 'cliente_id', 'cant']));

            $planificacion = $planificacion
                ->where('planificacion_id', '=', $request->input('planificacion_id'))
                ->where('fecha', '!=', $request->input('fecha'));

            //creo la nueva copia de la planificacion
            $data = $request->only(['usuario_id', 'cliente_id', 'contexto', 'cant', 'fecha']);
            $data['observaciones'] = $observaciones;
            $planificacion = $this->repository->create($data);

            //creo la nueva copia de la planificacion
//        $planificacionItem = DB::table('planificacion_item')
//            ->where('planificacion_id', '=', $planificacion_id_ant)
//            ->get();
            $data = $request->only(['usuario_id', 'tipo_id', 'receta_id', 'cant_rec', 'etiqueta', '']);
            $data['planificacion_id'] = $planificacion_id_ant;
            $planificacionItem = PlanificacionItem::create($data);

        }
    }
    public function eliminar($planificacion)
    {
        //$planificacion es planificacion_id
        $formParams['nombre'] = '';
        $eliminado = Planificacion::where('planificacion_id', '=', $planificacion);
        $eliminado->delete();

        $planificacion = $this->repository->finOrFail($planificacion);
        $cliente = $planificacion->cliente_id;


//            para la cargar el servicio
        $clientes = Cliente::all();
        $recetas = Receta::all();
        $tipos = Tipo::all();
        $usuarios = Usuario::all();

        return view('/planificacion/planificacionservicios.indexCarga',compact('clientes','recetas','tipos', 'planificacion'));

    }
}
