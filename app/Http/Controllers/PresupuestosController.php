<?php

namespace App\Http\Controllers;

use App\Models\ClienteServicios;
use App\Models\Condicion;
use App\Models\Etiqueta;
use App\Models\Ingrediente;
use App\Models\Planificacion;
use App\Models\PlanificacionItem;
use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\Tipo;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Element;
use function GuzzleHttp\Promise\all;
use function PHPUnit\Framework\isEmpty;
use function Symfony\Component\String\b;

class PresupuestosController extends Controller
{
    public function index(){
        $clientes = Cliente::all();
        $etiquetas = Etiqueta::all();
        return view('/planificacion/presupuestos.index',
            compact('clientes'));
    }

    public function verDetalle(){

    }


public function calcular(Request $request)
{
    $clientes = Cliente::all();
    $recetas = Receta::all();
    $etiquetas = Etiqueta::all();
    $tipos = Tipo::all();
    $ingredientes = Ingrediente::all();


    $planificacionCargada = Planificacion::where('cliente_id', '=', $request->input('cliente_id'))
        ->where('contexto', '=', $request->input('contexto'))
        ->whereBetween('fecha', [$request->input('fechaI'), $request->input('fechaF')])
        ->get();
        //existe una planificacion cargada
    if ($planificacionCargada->count() > 0) {
        //busco los id de las planificaciones cargadas para esa fecha en planificacionItem
        foreach ($planificacionCargada as $plan) {
//                var_dump($plan->planificacion_id);

            $planificacionItem = PlanificacionItem::select('planificacion_id', 'usuario_id',
                'cant_rec', 'tipo_id', 'receta_id', 'planificacionItem_id','etiqueta_id')
                ->where('planificacion_id', '=', $plan->planificacion_id)
                    ->get();

            if ($planificacionItem->count() > 0) {
                $serviciosPlanificados = DB::table('planificacion_item')
                    ->join('planificacion', 'planificacion_item.planificacion_id', '=',
                        'planificacion.planificacion_id')
                    ->join('recetas', 'recetas.receta_id', '=', 'planificacion_item.receta_id')
                    ->join('etiquetas', 'etiquetas.etiqueta_id', '=', 'planificacion_item.etiqueta_id')
                    ->join('tipos', 'tipos.tipo_id', '=', 'planificacion_item.tipo_id')
                    ->join('clientes', 'clientes.cliente_id', '=', 'planificacion.cliente_id')
                    ->select('planificacion.fecha', 'planificacion.cant', 'planificacion.planificacion_id',
                        'planificacion.contexto','planificacion.cliente_id', 'planificacion.usuario_id'
                        , 'planificacion.observaciones', 'planificacion_item.planificacionItem_id', 'planificacion_item.etiqueta_id',
                        'planificacion_item.planificacionItem_id', 'planificacion_item.receta_id', 'planificacion_item.cant_rec',
                        'tipos.nombre as tipoNombre', 'planificacion_item.tipo_id', 'recetas.nombre as recetaNombre',
                        'recetas.receta_id', 'planificacion_item.etiqueta_id', 'etiquetas.nombre as etiquetaNombre', 'recetas.base',
                        'clientes.condicion_id')
                    ->where('planificacion_item.planificacion_id', '=', $plan->planificacion_id)
                    ->orderBy('fecha')
                    ->orderBy('etiquetas.nombre')
                    ->orderBy('tipos.nombre')
                    ->get();
                $etiqueta_id = $serviciosPlanificados[0]->planificacion_id;
                $tipo_id = $serviciosPlanificados[0]->planificacion_id;
                $fecha = $serviciosPlanificados[0]->fecha;


                foreach ($serviciosPlanificados as $servicio) {
                    $recetaCostoGravado = 0;
                    $recetaCostoExento = 0;
                    $costoGravado = 0;
                    $costoExento = 0;
                    $cant_rec = $servicio->cant_rec;
                    $tipoGravado = 0;
                    $etiquetaGravado =0;

                    if ($servicio->fecha == $fecha) {
                        if ($servicio->etiqueta_id == $etiqueta_id and sizeof($serviciosPlanificados) > 0) {
                            if ($servicio->tipo_id == $tipo_id) {
                                $costoGravado = 0;
                                $costoExento = 0;
                                foreach ($recetas as $recetaIte) {
                                    if ($recetaIte->receta_id == $servicio->receta_id) {
                                        //encuentro la receta
                                        $recetaItem = RecetaItem::selectRaw('*')
                                            ->where('receta_id', '=', $servicio->receta_id)
                                            ->get();
                                        foreach ($recetas as $recetaIte) {
                                            if ($recetaIte->receta_id == $servicio->receta_id) {
                                                //encuentro la receta
                                                $recetaItem = RecetaItem::selectRaw('*')
                                                    ->where('receta_id', '=', $servicio->receta_id)
                                                    ->get();

                                                foreach ($recetaItem as $recetaIte) {
                                                    foreach ($ingredientes as $ingrediente) {
                                                        if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                                                            $costoGravado = $costoGravado + $recetaIte->cant * $ingrediente->precio / 100;

                                                            $costoExento = $costoExento + $recetaIte->cant * $ingrediente->precio / 100 *
                                                                $ingrediente->impuesto/100 + $recetaIte->cant * $ingrediente->precio / 100 ;
                                                        } //cierro el if receta
                                                    }
                                                    //cierro el foreach de ingredientes
                                                    $costoGravado = ($costoGravado / $servicio->base);
                                                    $costoExento = ($costoExento / $servicio->base);
                                                }// cierro el foreach de recetas

                                            }// cierro el foreach de recetas
                                        }
                                    }
                                }

                            } else {
                                $costoGravado = 0;
                                $costoExento = 0;
                                $tipoGravado = 0;
                                $etiquetaGravado = 0;
                                foreach ($recetas as $recetaIte) {
                                    if ($servicio->receta_id == $recetaIte->receta_id) {
                                        //encuentro la receta
                                        $recetaItem = DB::table('recetasitems')
                                            ->select('*')
                                            ->where('receta_id', '=', $servicio->receta_id)
                                            ->get();
                                        foreach ($recetaItem as $recetaIte) {
                                            foreach ($ingredientes as $ingrediente) {
                                                if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                                                    $costoGravado = $costoGravado + ($recetaIte->cant * $ingrediente->precio / 100);
                                                    $costoExento = $costoExento + $recetaIte->cant * $ingrediente->precio / 100 *
                                                        $ingrediente->impuesto / 100 + $recetaIte->cant * $ingrediente->precio / 100;
                                                } //cierro el if receta
                                            }
                                        }
                                        //cierro el foreach de ingredientes
                                        $costoGravado = ($costoGravado / $servicio->base);
                                        $costoExento = ($costoExento / $servicio->base);
                                    }// cierro el foreach de recetas
                                }
                            }// cierro if etiqueta
//*******************
                        } else { //es el else de etiqueta == almuerzo cena des

                            $costoGravado = 0;
                            $costoExento = 0;
                            $tipoGravado = 0;
                            $etiquetaGravado = 0;

                            foreach ($recetas as $recetaIte) {
                                if ($servicio->receta_id == $recetaIte->receta_id) {
                                    //encuentro la receta
                                    $recetaItem = DB::table('recetasitems')
                                        ->select('*')
                                        ->where('receta_id', '=', $servicio->receta_id)
                                        ->get();
                                    foreach ($recetaItem as $recetaIte) {
                                        foreach ($ingredientes as $ingrediente) {
                                            if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                                                $costoGravado = $costoGravado + ($recetaIte->cant * $ingrediente->precio / 100);
                                                $costoExento = $costoExento + $recetaIte->cant * $ingrediente->precio / 100 *
                                                $ingrediente->impuesto / 100 + $recetaIte->cant * $ingrediente->precio / 100;

                                            } //cierro el if receta
                                        }
                                    }
                                    //cierro el foreach de ingredientes
                                    $costoGravado = ($costoGravado / $servicio->base);
                                    $costoExento = ($costoExento / $servicio->base);
                                }// cierro el foreach de recetas
                            }
                            $tipoGravado = $costoGravado * $servicio->cant + $tipoGravado;
                        }
//                       **********************************************
                    }else { //ele de fecha

                        $costoGravado = 0;
                        $costoExento = 0;
                        $tipoGravado = 0;
                        $etiquetaGravado = 0;

                        foreach ($recetas as $recetaIte) {
                            if ($servicio->receta_id == $recetaIte->receta_id) {
                                //encuentro la receta
                                $recetaItem = DB::table('recetasitems')
                                    ->select('*')
                                    ->where('receta_id', '=', $servicio->receta_id)
                                    ->get();
                                foreach ($recetaItem as $recetaIte) {
                                    foreach ($ingredientes as $ingrediente) {
                                        if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                                            $costoGravado = $costoGravado + ($recetaIte->cant * $ingrediente->precio / 100);
                                            $costoExento = $costoExento + $recetaIte->cant * $ingrediente->precio / 100 *
                                                $ingrediente->impuesto / 100 + $recetaIte->cant * $ingrediente->precio / 100;
                                        } //cierro el if receta
                                    }
                                }
                                //cierro el foreach de ingredientes
                                $costoGravado = ($costoGravado / $servicio->base);
                                $costoExento = ($costoExento / $servicio->base);
                            }// cierro el foreach de recetas
                        }
                    }

                     $servicios[] = [
                            'fecha' => $servicio->fecha,
                            'fechaI' => $request->input('fechaI'),
                            'fechaF' => $request->input('fechaF'),
                            'contexto' => $servicio->contexto,
                            'planificacion_id' => $servicio->planificacion_id,
                            'planificacionItem_id' => $servicio->planificacionItem_id,
                            'recetaNombre' => $servicio->recetaNombre,
                            'receta_id' => $servicio->receta_id,
                            'etiquetaNombre' => $servicio->etiquetaNombre,
                            'etiqueta_id' => $servicio->etiqueta_id,
                            'cliente_id' => $servicio->cliente_id,
                            'usuario_id' => $servicio->usuario_id,
                            'cant_rec' => $servicio->cant_rec,
                            'tipoNombre' => $servicio->tipoNombre,
                            'tipo_id' => $servicio->tipo_id,
                            'cant' => $servicio->cant,
                            'base' => $servicio->base,
                            'costoRecetaGravado' => $costoGravado ,
                            'costoRecetaExento' => $costoExento,
                            'costoLineaGravado' => $costoGravado * $servicio->cant_rec ,
                            'costoLineaExento' => $costoExento * $servicio->cant_rec ,
                            'costoTipoGravado' => $tipoGravado,
                            'costoEtiquetaGravado' => $etiquetaGravado,
//                          'costoEtiquetaExento' => $etiquetaExento,
                        ];
                 }
                $servicios = json_encode($servicios);
                $servicios = json_decode($servicios);
                $etiqueta_id = $servicio->etiqueta_id;

            }//cierro foreach planificacionItem
        }
     }//cierro el foreach de planificacionItem >0
   //cierro el if de si hay planificacion cargada
    else {
        return redirect()
            ->route('presupuestos.index')
            ->with('message', 'No hay datos.');
         }

return view('/planificacion/presupuestos/detalle', compact('servicios','clientes', 'recetas','costoGravado'));

}


    public function detalleGlobal(Request $request)
    {
        $clientes = Cliente::all();
        $recetas = Receta::all();
        $etiquetas = Etiqueta::all();
        $tipos = Tipo::all();
        $ingredientes = Ingrediente::all();
        $costoGravado = 0;
        $costoExento = 0;


        $planificacionCargada = Planificacion::where('cliente_id', '=', $request->input('cliente_id'))
            ->where('contexto', '=', $request->input('contexto'))
            ->whereBetween('fecha', [$request->input('fechaI'), $request->input('fechaF')])
            ->get();
        //existe una planificacion cargada
        if ($planificacionCargada->count() > 0) {
            //busco los id de las planificaciones cargadas para esa fecha en planificacionItem
            foreach ($planificacionCargada as $plan) {

                $planificacionItem = PlanificacionItem::select('planificacion_id', 'usuario_id',
                    'cant_rec', 'tipo_id', 'receta_id', 'planificacionItem_id','etiqueta_id')
                    ->where('planificacion_id', '=', $plan->planificacion_id)
                    ->get();

                if ($planificacionItem->count() > 0) {

                    $serviciosPlanificados = DB::table('planificacion_item')
                        ->join('planificacion', 'planificacion_item.planificacion_id', '=',
                            'planificacion.planificacion_id')
                        ->join('recetas', 'recetas.receta_id', '=', 'planificacion_item.receta_id')
                        ->join('etiquetas', 'etiquetas.etiqueta_id', '=', 'planificacion_item.etiqueta_id')
                        ->join('tipos', 'tipos.tipo_id', '=', 'planificacion_item.tipo_id')
                        ->join('clientes', 'clientes.cliente_id', '=', 'planificacion.cliente_id')
                        ->select('planificacion.fecha', 'planificacion.cant', 'planificacion.planificacion_id',
                            'planificacion.contexto','planificacion.cliente_id', 'planificacion.usuario_id'
                            , 'planificacion.observaciones', 'planificacion_item.planificacionItem_id', 'planificacion_item.etiqueta_id',
                            'planificacion_item.planificacionItem_id', 'planificacion_item.receta_id', 'planificacion_item.cant_rec',
                            'tipos.nombre as tipoNombre', 'planificacion_item.tipo_id', 'recetas.nombre as recetaNombre',
                            'recetas.receta_id', 'planificacion_item.etiqueta_id', 'etiquetas.nombre as etiquetaNombre', 'recetas.base',
                            'clientes.condicion_id')
                        ->where('planificacion_item.planificacion_id', '=', $plan->planificacion_id)
                        ->orderBy('etiquetas.nombre')
                        ->get();
                    foreach ($serviciosPlanificados as $servicio) {
//                        dd($servicio);
                        $costoGravado = 0;
                        $costoExento = 0;
                            foreach ($recetas as $recetaIte) {
                                if ($servicio->receta_id == $recetaIte->receta_id) {
                                    //encuentro la receta
                                    $recetaItem = DB::table('recetasitems')
                                        ->select('*')
                                        ->where('receta_id', '=', $servicio->receta_id)
                                        ->get();
                                    foreach ($recetaItem as $recetaIte) {
                                        foreach ($ingredientes as $ingrediente) {
                                            if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                                                $costoGravado = $costoGravado + ($recetaIte->cant * $ingrediente->precio / 100);
                                                $costoExento = $costoExento + $recetaIte->cant * $ingrediente->precio / 100 *
                                                    $ingrediente->impuesto / 100 + $recetaIte->cant * $ingrediente->precio / 100;
                                            } //cierro el if receta
                                        }
                                    }
                                    //cierro el foreach de ingredientes
                                    $costoGravado = ($costoGravado / $servicio->base);
                                    $costoExento = ($costoExento / $servicio->base);
                                }
                            }// cierro el foreach de recetas
                        $servicios[] = [
                            'fecha' => $servicio->fecha,
                            'fechaI' => $request->input('fechaI'),
                            'fechaF' => $request->input('fechaF'),
                            'contexto' => $servicio->contexto,
                            'planificacion_id' => $servicio->planificacion_id,
                            'planificacionItem_id' => $servicio->planificacionItem_id,
                            'etiquetaNombre' => $servicio->etiquetaNombre,
                            'etiqueta_id' => $servicio->etiqueta_id,
                            'cliente_id' => $servicio->cliente_id,
                            'condicion_id' => $servicio->condicion_id,
                            'usuario_id' => $servicio->usuario_id,
                            'cant_rec' => $servicio->cant_rec,
                            'cant' => $servicio->cant,
                            'costoGravado' => $costoGravado,
                            'costoExento' => $costoExento,
                        ];

                        $servicios = json_encode($servicios);
                        $servicios = json_decode($servicios);

                        $etiqueta_id = $servicio->etiqueta_id;

                     }// cierro el foreach de servicios
                  } // cierro el if si tiene planif
               }

           }

        //cierro el if de si hay planificacion cargada
        else {
            return redirect()
                ->route('presupuestos.index')
                ->with('message', 'No hay datos para esos parámetros.');
        }
        return view('/planificacion/presupuestos/detalleGlobal', compact('servicios','clientes', 'recetas','costoGravado'));

    }

}
