<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Etiqueta;
use App\Models\Ingrediente;
use App\Models\Planificacion;
use App\Models\PlanificacionItem;
use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\ServicioPlanificado;
use App\Models\Tipo;
use App\Repositories\ServiciosPlanificadosRepository;
use Carbon\Carbon;
use Database\Seeders\ClientesSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\EventDispatcher\Event;
use function PHPUnit\Framework\isEmpty;

class ServiciosPlanificadosController extends Controller
{
    protected $repository;

    /**
     * IngredientesController constructor.
     * Le pedimos a Laravel que nos inyecte en el constructor la clase asociada a la interface
     * IngredienteRepositoty.
     * Esa asociación la tenemos en AppServiceProvider.
     *
     * @param ServiciosPlanificadosRepository $repository
     */
    public function __construct(ServiciosPlanificadosRepository $repository)

    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $clientes = Cliente::all();
        return view('/planificacion/serviciosPlanificados.index', compact('clientes'));
    }

    public function indexApertura(Request $request)
    {
        $clientes = Cliente::all();
        return view('/planificacion/serviciosPlanificados.serviciosPlanificadosIndex', compact('clientes'));
    }

    public function calendario(ServicioPlanificado $servicios)
    {
        $recetas = Receta::all();
        $ingredientes = Ingrediente::all();
        $recetaItem = RecetaItem::all();

        return view('/planificacion/serviciosPlanificados.calendario', compact('servicios', 'recetas', 'ingredientes', 'recetaItem'));
    }

    public function cargaServicios(Request $request)
    {
        $fi = $this->repository->devolverFechaI($request->input('mes'), $request->input('anio'));
        $ff = $this->repository->devolverFechaF($request->input('mes'), $request->input('anio'));

        $planificacion = DB::table('planificacion')
            ->select('fecha', 'cant', 'planificacion_id', 'contexto',
                'cliente_id', 'usuario_id')
            ->whereBetween('fecha', [$fi, $ff])
            ->get();

        if ($planificacion->count()==0) { //no hay una planificacion para esas fechas
            $clientes = Cliente::all();
            $request->session()->flash('message', 'No existen registros cargados para los parámetros ingresados');
            $request->session()->flash('message_type', 'danger');
            return view('/planificacion/serviciosPlanificados.index', compact('clientes'));

        } else {
            $cont = 0;
            foreach ($planificacion as $planItem) {
                $buscarPlanItem = DB::table('planificacion_item')
                        ->where('planificacion_item.planificacion_id', '=',
                            $planItem->planificacion_id)
                        ->count() > 0;
                if ($buscarPlanItem) {
                    $cont = $cont + 1;
                }
            }
//                    dd($cont);
            if ($cont == 0) //  no encuentra items para una planificacion en planificacion item
            {
                $cliente = Cliente::findOrFail($request->input('cliente_id'));
                $clientes = Cliente::all();
                $request->session()->flash('message', 'No existen registros cargados para los parámetros ingresados');
                $request->session()->flash('message_type', 'danger');
                return view('/planificacion/serviciosPlanificados.index', compact('clientes'));
            } else {
                //ya existe una planificacion para esa fecha

                $planificacion = Planificacion::selectRaw('planificacion_id, fecha, contexto, usuario_id, cliente_id')
                    ->where('cliente_id', '=', $request->input('cliente_id'))
                    ->where('contexto', '=', $request->input('contexto'))
                    ->where('fecha', '>=', $fi and 'fecha', '<=', $ff)
                    ->get();

                $planificacionItem = PlanificacionItem::where('planificacion_id','=',$planItem->planificacion_id)
                                    ->count()>0; // existe item para esa planificacion

                $pla_id = $planificacion[0]->planificacion_id;
                $clientes = Cliente::all();
                $cliente = Cliente::findOrFail($request->input('cliente_id'));

                $request->session()->flash('message', 'Ya existe una planificación para esa fecha, podés editarla desde este panel');
                $request->session()->flash('message_type', 'success');

                $serviciosPlanificados = DB::table('planificacion')
                    ->join('planificacion_item', 'planificacion.planificacion_id', '=',
                        'planificacion_item.planificacion_id')
                    ->join('recetas', 'recetas.receta_id', '=', 'planificacion_item.receta_id')
                    ->join('etiquetas', 'etiquetas.etiqueta_id', '=', 'planificacion_item.etiqueta_id')
                    ->join('tipos', 'tipos.tipo_id', '=', 'planificacion_item.tipo_id')

                    ->select('planificacion.fecha', 'planificacion.cant', 'planificacion.planificacion_id', 'planificacion.contexto',
                        'planificacion.cliente_id', 'planificacion.usuario_id'
                        , 'planificacion.observaciones', 'planificacion_item.planificacionItem_id', 'planificacion_item.etiqueta_id',
                        'planificacion_item.planificacionItem_id', 'planificacion_item.receta_id', 'planificacion_item.cant_rec',
                        'tipos.nombre as tipoNombre', 'planificacion_item.tipo_id', 'recetas.nombre as recetaNombre',
                        'recetas.receta_id', 'etiquetas.nombre as etiquetaNombre', 'recetas.base', 'etiquetas.etiqueta_id')
                    ->whereBetween('fecha', [$fi, $ff])
                    ->where('contexto', '=', $request->input('contexto'))
                    ->where('cliente_id', '=', $request->input('cliente_id'))
                    ->groupBy('planificacion.fecha', 'planificacion.planificacion_id', 'planificacion.contexto',
                        'planificacion.cliente_id', 'planificacion.usuario_id', 'planificacion.cant'
                        , 'planificacion.observaciones', 'planificacion_item.planificacionItem_id', 'planificacion_item.etiqueta_id',
                        'planificacion_item.planificacionItem_id', 'planificacion_item.receta_id', 'planificacion_item.cant_rec',
                        'planificacion_item.tipo_id', 'tipos.nombre', 'etiquetas.nombre', 'recetas.nombre',
                        'recetas.receta_id', 'etiquetas.etiqueta_id', 'recetas.base')
//                    ->orderBy('planificacion.fecha')
                    ->orderBy('planificacion_item.etiqueta_id')
                    ->get();
                $fecha = $serviciosPlanificados[0]->fecha;
                $etiqueta_id = $serviciosPlanificados[0]->etiqueta_id;
                foreach ($serviciosPlanificados as $servicio) {
                    $diaDeSem = $this->repository->dayWeek($servicio->fecha); //Martes
                    $servicios[] = [
                        'fecha' => $servicio->fecha,
                        'dia' => $diaDeSem,
                        'contexto' => $servicio->contexto,
                        'planificacion_id' => $servicio->planificacion_id,
                        'planificacionItem_id' => $servicio->planificacionItem_id,
                        'recetaNombre' => $servicio->recetaNombre,
                        'receta_id' => $servicio->receta_id,
                        'etiquetaNombre' => $servicio->etiquetaNombre,
                        'etiqueta_id' => $servicio->etiqueta_id,
                        'cliente_id' => $servicio->cliente_id,
                        'usuario_id' => $servicio->usuario_id,
                        'observaciones' => $servicio->observaciones,
                        'cant_rec' => $servicio->cant_rec,
                        'tipoNombre' => $servicio->tipoNombre,
                        'tipo_id' => $servicio->tipo_id,
                        'cant' => $servicio->cant,
                        'base' => $servicio->base,

                    ];
                };
                $servicios = json_encode($servicios);
                $servicios = json_decode($servicios);
                $clienteServicios = DB::table('clienteservicios')
                    ->select('*')
                    ->where('cliente_id', '=', $request->input('cliente_id'))
                    ->get();

                $etiquetas = Etiqueta::all();
                $clientes = Cliente::all();
                $recetas = Receta::all();
                $ingredientes = Ingrediente::all();
                $recetaItem = RecetaItem::all();
                $request->session()->flash('message', '');
                $request->session()->flash('message_type', 'transparent');

                return view('/planificacion/serviciosPlanificados.resumen', compact('cliente','servicios', 'recetas', 'ingredientes', 'recetaItem','clienteServicios','etiquetas','clientes'));
            }
        }
    }

    public function listadoServiciosPlanificados(Request $request)
    {
        $fi = $request->input('fi');
        $ff = $request->input('ff');

        if ($fi >= $ff) {
            $clientes = Cliente::all();
            return redirect()
                ->route('serviciosPlanificados.indexApertura', compact('clientes'))
                ->with('message', 'La fecha inicial no puede ser menos a la final.')
                ->with('message_type', 'danger');
        }

        $planificacion = DB::table('planificacion')
            ->select('fecha', 'cant', 'planificacion_id', 'contexto',
                'cliente_id', 'usuario_id')
            ->where('contexto', '=', $request->input('contexto'))
            ->where('cliente_id', '=', $request->input('cliente_id'))
            ->whereBetween('fecha', [$request->input('fi'), $request->input('ff')])
            ->get();

            $cont = 0;
            foreach ($planificacion as $planItem) {
                $buscarPlanItem = DB::table('planificacion_item')
                        ->where('planificacion_item.planificacion_id', '=',
                            $planItem->planificacion_id)
                        ->count() > 0;
                if ($buscarPlanItem) {
                    $cont = $cont + 1;
                }
            }
                //ya existe una planificacion para esa fecha
        if ($cont > 0) {

            $planificacionItem = PlanificacionItem::where('planificacion_id','=',$planItem->planificacion_id)
                    ->count()>0; // existe item para esa planificacion

            $pla_id = $planificacion[0]->planificacion_id;
            $cliente = Cliente::findOrFail($request->input('cliente_id'));

            $serviciosPlanificados = DB::table('planificacion')
                ->join('planificacion_item', 'planificacion.planificacion_id', '=',
                    'planificacion_item.planificacion_id')
                ->join('recetas', 'recetas.receta_id', '=', 'planificacion_item.receta_id')
                ->join('etiquetas', 'etiquetas.etiqueta_id', '=', 'planificacion_item.etiqueta_id')
                ->join('tipos', 'tipos.tipo_id', '=', 'planificacion_item.tipo_id')

                ->select('planificacion.fecha', 'planificacion.cant', 'planificacion.planificacion_id', 'planificacion.contexto',
                    'planificacion.cliente_id', 'planificacion.usuario_id'
                    , 'planificacion.observaciones', 'planificacion_item.planificacionItem_id', 'planificacion_item.etiqueta_id',
                    'planificacion_item.planificacionItem_id', 'planificacion_item.receta_id', 'planificacion_item.cant_rec',
                    'tipos.nombre as tipoNombre', 'planificacion_item.tipo_id', 'recetas.nombre as recetaNombre',
                    'recetas.receta_id', 'etiquetas.nombre as etiquetaNombre', 'recetas.base', 'etiquetas.etiqueta_id')
                ->whereBetween('fecha', [$request->input('fi'), $request->input('ff')])
                ->where('contexto', '=', $request->input('contexto'))
                ->where('cliente_id', '=', $request->input('cliente_id'))
                ->orderBy('fecha')
                ->orderBy('planificacion_item.etiqueta_id')
                 ->get();
            $fecha = $serviciosPlanificados[0]->fecha;
            $etiqueta_id = $serviciosPlanificados[0]->etiqueta_id;
            foreach ($serviciosPlanificados as $servicio) {
                $diaDeSem = $this->repository->dayWeek($servicio->fecha); //Martes
                $servicios[] = [
                    'fecha' => $servicio->fecha,
                    'dia' => $diaDeSem,
                    'contexto' => $servicio->contexto,
                    'planificacion_id' => $servicio->planificacion_id,
                    'planificacionItem_id' => $servicio->planificacionItem_id,
                    'recetaNombre' => $servicio->recetaNombre,
                    'receta_id' => $servicio->receta_id,
                    'etiquetaNombre' => $servicio->etiquetaNombre,
                    'etiqueta_id' => $servicio->etiqueta_id,
                    'cliente_id' => $servicio->cliente_id,
                    'usuario_id' => $servicio->usuario_id,
                    'observaciones' => $servicio->observaciones,
                    'cant_rec' => $servicio->cant_rec,
                    'tipoNombre' => $servicio->tipoNombre,
                    'tipo_id' => $servicio->tipo_id,
                    'cant' => $servicio->cant,
                    'base' => $servicio->base,
                    'fi' => $request->input('fi'),
                    'ff' => $request->input('ff'),

                ];
            };
            $servicios = json_encode($servicios);
            $servicios = json_decode($servicios);
            $recetas = Receta::all();
            $ingredientes = Ingrediente::all();
            $recetaItem = RecetaItem::all();
            $request->session()->flash('message', '');
            $request->session()->flash('message_type', 'transparent');

            return view('/planificacion/serviciosPlanificados.calendario', compact('cliente','servicios', 'recetas', 'ingredientes', 'recetaItem'));
    }else{
            $clientes = Cliente::all();
             return redirect()
                ->route('serviciosPlanificados.indexApertura', compact('clientes'))
                ->with('message', 'No existen registros cargados para los parámetros ingresados')
                ->with('message_type', 'danger');
        }
    }

    public function aperturaSeleccion(Request $request)
    {
        $planificacion = DB::table('planificacion')
            ->select('fecha', 'cant', 'planificacion_id', 'contexto',
                'cliente_id', 'usuario_id')
            ->where('contexto', '=', $request->input('contexto'))
            ->where('cliente_id', '=', $request->input('cliente_id'))
            ->whereBetween('fecha', [$request->input('fi'), $request->input('ff')])
            ->get();

        $cont = 0;
        foreach ($planificacion as $planItem) {
            $buscarPlanItem = DB::table('planificacion_item')
                    ->where('planificacion_item.planificacion_id', '=',
                        $planItem->planificacion_id)
                    ->count() > 0;
            if ($buscarPlanItem) {
                $cont = $cont + 1;
            }
        }
        //ya existe una planificacion para esa fecha

        $planificacionItem = PlanificacionItem::where('planificacion_id','=',$planItem->planificacion_id)
                ->count()>0; // existe item para esa planificacion

        $pla_id = $planificacion[0]->planificacion_id;
        $cliente = Cliente::findOrFail($request->input('cliente_id'));

        $serviciosPlanificados = DB::table('planificacion')
            ->join('planificacion_item', 'planificacion.planificacion_id', '=',
                'planificacion_item.planificacion_id')
            ->join('recetas', 'recetas.receta_id', '=', 'planificacion_item.receta_id')
            ->join('etiquetas', 'etiquetas.etiqueta_id', '=', 'planificacion_item.etiqueta_id')
            ->join('tipos', 'tipos.tipo_id', '=', 'planificacion_item.tipo_id')

            ->select('planificacion.fecha', 'planificacion.cant', 'planificacion.planificacion_id', 'planificacion.contexto',
                'planificacion.cliente_id', 'planificacion.usuario_id'
                , 'planificacion.observaciones', 'planificacion_item.planificacionItem_id', 'planificacion_item.etiqueta_id',
                'planificacion_item.planificacionItem_id', 'planificacion_item.receta_id', 'planificacion_item.cant_rec',
                'tipos.nombre as tipoNombre', 'planificacion_item.tipo_id', 'recetas.nombre as recetaNombre',
                'recetas.receta_id', 'etiquetas.nombre as etiquetaNombre', 'recetas.base', 'etiquetas.etiqueta_id')
            ->whereBetween('fecha', [$request->input('fi'), $request->input('ff')])
            ->where('contexto', '=', $request->input('contexto'))
            ->where('cliente_id', '=', $request->input('cliente_id'))
            ->where('planificacion_item.etiqueta_id', '=', $request->input('etiqueta_id'))
            ->get();

        $fecha = $serviciosPlanificados[0]->fecha;
        $etiqueta_id = $serviciosPlanificados[0]->etiqueta_id;
        foreach ($serviciosPlanificados as $servicio) {
            $diaDeSem = $this->repository->dayWeek($servicio->fecha); //Martes
            $servicios[] = [
                'fecha' => $servicio->fecha,
                'dia' => $diaDeSem,
                'contexto' => $servicio->contexto,
                'planificacion_id' => $servicio->planificacion_id,
                'planificacionItem_id' => $servicio->planificacionItem_id,
                'recetaNombre' => $servicio->recetaNombre,
                'receta_id' => $servicio->receta_id,
                'etiquetaNombre' => $servicio->etiquetaNombre,
                'etiqueta_id' => $servicio->etiqueta_id,
                'cliente_id' => $servicio->cliente_id,
                'usuario_id' => $servicio->usuario_id,
                'observaciones' => $servicio->observaciones,
                'cant_rec' => $servicio->cant_rec,
                'tipoNombre' => $servicio->tipoNombre,
                'tipo_id' => $servicio->tipo_id,
                'cant' => $servicio->cant,
                'base' => $servicio->base,
                'fi' => $request->input('fi'),
                'ff' => $request->input('ff'),

            ];
        };
        $servicios = json_encode($servicios);
        $servicios = json_decode($servicios);

        $recetas = Receta::all();
        $ingredientes = Ingrediente::all();
        $recetaItem = RecetaItem::all();
        $request->session()->flash('message', '');
        $request->session()->flash('message_type', 'transparent');

        return view('/planificacion/serviciosPlanificados.calendario', compact('cliente','servicios', 'recetas', 'ingredientes', 'recetaItem'));
    }


}
