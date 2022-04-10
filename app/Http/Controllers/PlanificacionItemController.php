<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Etiqueta;
use App\Models\Planificacion;
use App\Models\PlanificacionItem;
use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\Tipo;
use Illuminate\Http\Request;
use App\Repositories\PlanificacionItemRepository;
use Illuminate\Support\Facades\DB;
Use Illuminate\Contracts\Session\Session;

class PlanificacionItemController extends Controller
{
    protected $repository;
    /**
     *
     * @param PlanificacionItemRepository $repository
     */
    public function __construct(PlanificacionItemRepository $repository)

    {
        $this->repository = $repository;
    }

    public function index( $planificacion, $planificacionItem) {
            $planificacion = $this->repository->getByPk($planificacion->planificacion_id);
            $etiquetas = Etiqueta::all();
            $recetas = Receta::all();
            $clientes = Cliente::all();
            $tipos = Tipo::all();
        return view('/planificacion/planificacionservicios.indexCargaItem',compact('planificacionItem','recetas','tipos','cliente','etiquetas'));


    }

    public function cargaItem(Request $request)
    {
        //graba los datos de la cabecera
        //trae los datos ya cargados para esa fecha o
        //carga la pantalla con las recetas para que se empiecen a cargar

        $recetas = Receta::all();
        $tipos = Tipo::all();
        $etiquetas = Etiqueta::all();

        if ($request->input('observaciones') == '') {
            $observaciones = 'Sin observaciones' ;
            $data = $request->only(['usuario_id', 'cliente_id', 'contexto', 'cant', 'fecha','receta_id']);
            $data['observaciones'] = $observaciones;
        }else {
            $observaciones = $request->input('observaciones');
            $data = $request->only(['usuario_id', 'cliente_id', 'contexto', 'cant', 'fecha','receta_id']);
            $data['observaciones'] = $observaciones;
        }
        $planificacionItem = $this->repository->create($data);

        //trae la planificacion item
        $planificacionItem = DB::table('planificacion_item')->where('cliente_id','=', $request->input('cliente_id'))
            ->where('fecha','=', $request->input('fecha'))
            ->get();

        $cliente = Cliente::findOrFail($request->input('cliente_id'));

        return view('/planificacion/planificacionservicios.indexCargaItem',compact('planificacionItem','recetas','tipos','cliente','etiquetas'));
    }

    public function agregarItem(Request $request)
    {
        $request->validate(PlanificacionItem::$rules, PlanificacionItem::$errorMessages);
        $planificacion = Planificacion::select('planificacion_id','cant','contexto','fecha','usuario_id','cliente_id')
                                        ->where('planificacion_id','=',$request->input('planificacion_id'))
                                        ->get();

//        if ($planificacion) {
//        ***
//        }
        $recetas = Receta::all();
        $clientes = Cliente::all();
        $tipos = Tipo::all();
        $etiquetas = Etiqueta::all();
//        $planificacionItem = $this->repository->getByPlanificacion($request);

        //busco la planificacionItem_id
        $planificacionItem = PlanificacionItem::select('*')
            ->where('planificacion_id','=',$request->input('planificacion_id'))
            ->where('receta_id','=',$request->input('receta_id'))
            ->where('etiqueta_id','=',$request->input('etiqueta_id'))
            ->get()
            ->count()>0;


        if ($planificacionItem == true) { //si ya existe
            $planificacionItem = PlanificacionItem::select('*')
                ->where('planificacion_id','=',$request->input('planificacion_id'))
                ->get();

            $request->session()->flash('message', 'Ya existe una receta para esa fecha');
            $request->session()->flash('message_type', 'danger');
            return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion', 'recetas', 'clientes', 'tipos', 'planificacionItem','etiquetas'));
        } else {

            $planificacionItem = PlanificacionItem::select('*')
                    ->where('planificacion_id','=',$request->input('planificacion_id'))
                    ->where('receta_id','=',$request->input('receta_id'))
                    ->where('etiqueta_id','=',$request->input('etiqueta_id'))
                    ->get();
            $data = $request->only(['usuario_id', 'cliente_id', 'cant_rec', 'tipo_id', 'receta_id','etiqueta_id']);
            $data['planificacion_id'] = $request->input('planificacion_id');

            $planificacionItem = $this->repository->create($data);
//          $planificacionItem = $this->repository->getByPlanificacion($request);

            $planificacionItem = PlanificacionItem::select('*')
                ->where('planificacion_id','=',$request->input('planificacion_id'))
                ->get();

            $planificacion = Planificacion::select('planificacion_id','cant','contexto','fecha','usuario_id','cliente_id')
                ->where('planificacion_id','=',$request->input('planificacion_id'))
                ->get();

            $request->session()->flash('message', 'La receta fue insertada exitosamente.');
            $request->session()->flash('message_type', 'success');
            return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion', 'recetas', 'clientes', 'tipos', 'planificacionItem','etiquetas'));
        }
    }


    public function eliminar(Planificacion $planificacionItem)
    {
        $recetas = Receta::all();
        $clientes = Cliente::all();
        $tipos = Tipo::all();
        $etiquetas = Etiqueta::all();

         $planificacionItem->delete();
         $planificacionItem = PlanificacionItem::select('planificacion_id','usuario_id','cliente_id','fecha',
             'cant_rec','tipo_id','receta_id','etiqueta_id')
                    ->where('planificacion_id','=',$planificacionItem->planificacion_id)
                    ->get();

        $planificacion = Planificacion::select('planificacion_id','cant','contexto','fecha','usuario_id','cliente_id')
            ->where('planificacion_id','=',$planificacionItem->planificacion_id)
            ->get();

        return view('/planificacion/planificacionservicios.indexCargaItem',
            compact('planificacion', 'recetas', 'clientes', 'tipos',
                'planificacionItem','etiquetas'));
        }

    public function editarItem(Request $request, $planificacionItem_id)
    {
        $plan_id = PlanificacionItem::select('planificacion_id')
            ->where('planificacionItem_id', '=', $planificacionItem_id)
            ->get();
        $plan_id = $plan_id[0]->planificacion_id;

//edita la cantidad
        $planItemBool = DB::table('planificacion_item')
                ->where('planificacionItem_id', '=', $planificacionItem_id)
                ->where('receta_id', '=', $request->input('receta_id'))
                ->where('etiqueta_id', '=', $request->input('etiqueta_id'))
                ->count() > 0;

        if ($planItemBool) {
            //solo modifica la cantidad
            $planificacionItem = PlanificacionItem::where('planificacionItem_id', '=', $planificacionItem_id);
            $planificacionItem->update($request->only(['tipo_id', 'receta_id', 'cant_rec', 'usuario_id', 'etiqueta_id']));

            $recetas = Receta::all();
            $clientes = Cliente::all();
            $tipos = Tipo::all();
            $etiquetas = Etiqueta::all();
            $planificacionItem = $this->repository->getByPlanificacion($request);

            return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion', 'recetas', 'clientes', 'tipos', 'planificacionItem', 'etiquetas'));

        }
//dd($planItemBool);
//existe ese registro en otra planif
        $existe = DB::table('planificacion_item')
                ->where('receta_id', '=', $request->input('receta_id'))
                ->where('planificacion_id', '=', $request->input('planificacion_id'))
                ->where('etiqueta_id', '=', $request->input('etiqueta_id'))
                ->where('planificacionItem_id', '!=', $request->input('planificacionItem_id'))
                ->count() > 0;
//dd($existe);
        // ya existe ese registro
        if ($existe) {
            $planificacion = Planificacion::select('planificacion_id', 'cant', 'contexto', 'fecha', 'usuario_id', 'cliente_id')
                ->where('planificacion_id', '=', $request->input('planificacion_id'))
                ->get();

            $recetas = Receta::all();
            $clientes = Cliente::all();
            $tipos = Tipo::all();
            $etiquetas = Etiqueta::all();
            $planificacionItem = $this->repository->getByPlanificacion($request);

            $request->session()->flash('message', 'Ya existe ese servicio en esa fecha');
            $request->session()->flash('message_type', 'danger');
            return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion', 'recetas', 'clientes', 'tipos', 'planificacionItem', 'etiquetas'));

        } else {

            $planificacionItem = PlanificacionItem::where('planificacionItem_id', '=', $planificacionItem_id);
            $planificacionItem->update($request->only(['tipo_id', 'receta_id', 'cant_rec', 'usuario_id', 'etiqueta_id']));

            $planificacionItem = PlanificacionItem::select('planificacion_id', 'usuario_id',
                'cant_rec', 'tipo_id', 'receta_id', 'planificacionItem_id', 'etiqueta_id')
                ->where('planificacion_id', '=', $plan_id)
                ->get();

            $planificacion = Planificacion::select('planificacion_id', 'cant', 'contexto', 'fecha', 'usuario_id', 'cliente_id')
                ->where('planificacion_id', '=', $plan_id)
                ->get();

            $recetas = Receta::all();
            $clientes = Cliente::all();
            $tipos = Tipo::all();
            $etiquetas = Etiqueta::all();

            $request->session()->flash('message', 'La edición se realizó exitosamente.');
            $request->session()->flash('message_type', 'success');

            return view('/planificacion/planificacionservicios.indexCargaItem',
                compact('planificacion', 'recetas', 'clientes', 'tipos',
                    'planificacionItem', 'etiquetas'));
        }

//la receta existe y corresponde a otro item
        $existe = DB::table('planificacion_item')
                ->where('receta_id','=', $request->input('receta_id'))
                ->where('planificacionItem_id','!=',$request->input('planificacionItem_id'))
                ->where('planificacion_id','=',$request->input('planificacion_id'))
                ->get()
                ->count()>0;

        if ($existe) {
            $planificacionItem = PlanificacionItem::select('planificacion_id', 'usuario_id',
                'cant_rec', 'tipo_id', 'receta_id', 'planificacionItem_id','etiqueta_id')
                ->where('planificacion_id', '=', $plan_id)
                ->get();
            $planificacion = Planificacion::select('planificacion_id', 'cant', 'contexto', 'fecha', 'usuario_id', 'cliente_id')
                ->where('planificacion_id', '=', $plan_id)
                ->get();


            $recetas = Receta::all();
            $clientes = Cliente::all();
            $tipos = Tipo::all();
            $etiquetas = Etiqueta::all();

            $request->session()->flash('message', 'Ya existe una receta para esa fecha');
            $request->session()->flash('message_type', 'danger');
            return view('/planificacion/planificacionservicios.indexCargaItem', compact('planificacion', 'recetas', 'clientes', 'tipos', 'planificacionItem'));
        }
        //receta es diferente y la planificacion t
    }
    public function eliminarItem(Request $request, PlanificacionItem $planificacionItem)
    {
        $plan_id = $planificacionItem->planificacion_id;

        $planificacion = Planificacion::select('planificacion_id')
                                        ->where('planificacion_id','=', $plan_id = $planificacionItem->planificacion_id)
                                        ->get();

        $planificacionItem_delete = PlanificacionItem::findOrFail($planificacionItem->planificacionItem_id);
        $planificacionItem_delete->delete();

        $planificacionItem = PlanificacionItem::select('planificacion_id','etiqueta_id','tipo_id',
            'usuario_id','receta_id','cant_rec','planificacionItem_id')
            ->where('planificacion_id', '=', $request->input('planificacion_id'))
            ->get();

        $planificacion = Planificacion::select('planificacion_id','cant','contexto','fecha','usuario_id','cliente_id')
            ->where('planificacion_id','=',$plan_id)
            ->get();

        $planificacionActualEliminar = DB::table('planificacion_item')
                ->where('planificacion_id', '=', $planificacion[0]->planificacion_id)
                ->select('*')
                ->count() == 0;

        $planificacionItem = PlanificacionItem::select('planificacion_id','usuario_id',
            'cant_rec','tipo_id','receta_id','planificacionItem_id','etiqueta_id')
            ->where('planificacion_id','=',$plan_id)
            ->get();

        $recetas = Receta::all();
        $clientes = Cliente::all();
        $tipos = Tipo::all();
        $etiquetas = Etiqueta::all();

        $request->session()->flash('message', 'El registro fue eliminado exitosamente.');
        $request->session()->flash('message_type', 'success');

        return view('/planificacion/planificacionservicios.indexCargaItem',
               compact('planificacion', 'recetas', 'clientes', 'tipos',
                'planificacionItem','etiquetas'));
    }
}

