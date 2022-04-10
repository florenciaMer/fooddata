<?php

namespace App\Http\Controllers;
use App\Models\Ingrediente;
use App\Models\Tipo;
use App\Models\Unidad;
use App\Models\Categoria;
use App\Models\Receta;
use App\Models\Usuario;
use App\Repositories\RecetaItemRepository;
use App\Repositories\RecetasRepository;
use App\Models\RecetaItem;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;
use App\Repositories\IngredienteRepository;
class RecetasItemsController extends Controller
{
    protected $repository;
    protected $repositoryIng;

    /**
     * @param RecetaItemRepository $repository
     */

    /**
     * @param IngredienteRepository $repositoryIng
     */

    public function __construct(RecetaItemRepository $repository, IngredienteRepository $repositoryIng)
    {
        $this->repository = $repository;
        $this->repositoryIng = $repositoryIng;
    }


    public function index($receta_id)
    {
        $formParams['nombre'] = '';
        $ingredientes = Ingrediente::all()->sortBy('nombre');

            $receta = Receta::findOrFail($receta_id);
            $recetaItems = RecetaItem::all();
            $recetaItems = $recetaItems->where('receta_id', '=', $receta_id);
            $tipos = Tipo::all();
            $unidades = Unidad::all();
            $categorias = Categoria::all();
            $usuarios = Usuario::all();

            return view('planificacion/recetas.editar', compact('receta', 'tipos', 'ingredientes', 'recetaItems', 'unidades', 'categorias', 'receta_id','usuarios','formParams'));
        }
    public function indexIngredientesSearch(Request $request, $receta_id)
    {
        $request->session()->flash('message', '');
        $request->session()->flash('message_type', 'transparent');

        $formParams['nombre'] = [];

        $receta = Receta::findOrFail($receta_id);
        $ingredientes = $this->repositoryIng->all()->sortBy('nombre');
        $recetaItems = RecetaItem::all()->where('receta_id', '=', $receta_id);
        $tipos = Tipo::all();
        $unidades = Unidad::all();
        $categorias = Categoria::all();
        $usuarios = Usuario::all();

        if (isset($formParams['nombre'])) {

            $formParams['nombre'] = $request->query('nombre');
            $ingredientes = $this->repository->allWhitParams($formParams);
            $ingredienteEncontrado = Ingrediente::where('nombre', 'like', '%' .
                $formParams['nombre'] . '%');

            if ($ingredienteEncontrado = $this->repository->allWhitParams($formParams)) {

                $pr = $this->repositoryIng->getByName($request);
                if ($pr) {
                    $ingredientes = $this->repositoryIng->all();
                    $request->session()->flash('message', 'El ingrediente no existe');
                    $request->session()->flash('message_type', 'danger');

                    return view('planificacion/recetas.editar',
                        compact('receta', 'tipos', 'ingredientes', 'recetaItems',
                            'unidades', 'categorias', 'usuarios', 'formParams', 'ingredienteEncontrado'));
                }
            } else {
                $request->session()->flash('message', 'NO SE FUE DE LA PAGINA');
                $request->session()->flash('message_type', 'success');

                return view('planificacion/recetas.editar',
                    compact('receta', 'tipos', 'ingredientes', 'recetaItems',
                        'unidades', 'categorias', 'usuarios', 'formParams', 'ingredienteEncontrado'));
            }

            $ingredientes = $this->repositoryIng->all();
            $ingredienteEncontrado = Ingrediente::select('categoria_id',
                'nombre', 'ingrediente_id', 'unidad_id', 'precio','impuesto')->with(['unidad', 'categoria'])
                ->where('nombre', 'like', '%' . $formParams['nombre'] . '%')
                ->orderBy('nombre')
                ->get();

            $request->session()->flash('message', 'Ya podés seleccionar el producto');
            $request->session()->flash('message_type', 'success');

            return view('planificacion/recetas.editar',
                compact('receta', 'tipos', 'ingredientes', 'recetaItems',
                    'unidades', 'categorias', 'usuarios', 'formParams', 'ingredienteEncontrado'));
        }
    }

    public function nuevo($receta_id)
    {
        $ingredientes = Ingrediente::all()->sortBy('nombre');

        $receta = Receta::findOrFail($receta_id);
        $recetaItems = RecetaItem::all();
        $recetaItems = $recetaItems->where('receta_id', '=', $receta_id);
        $tipos = Tipo::all();
        $unidades = Unidad::all();
        $categorias = Categoria::all();
        $usuarios = Usuario::all();

        return view('planificacion/recetas/recetaItem.nuevo', compact('receta', 'tipos', 'ingredientes', 'recetaItems', 'unidades', 'categorias', 'receta_id','usuarios'));

    }

    public function eliminar($ingrediente_id, $receta_id)
    {
        $formParams['nombre'] = '';
        $eliminado = RecetaItem::where('ingrediente_id', '=', $ingrediente_id) and
        (RecetaItem::where('receta_id', '=', $receta_id));
        $eliminado->delete();

//        $eliminado = DB::table('recetasitems')
//             ->where('receta_id','=', $receta_id and 'ingrediente_id','=' ,$ingrediente_id )
//            ->delete();
        $receta = Receta::findOrFail($receta_id);

        $ingredientes = Ingrediente::all()->sortBy('nombre');


        $recetaItems = RecetaItem::all();
        $recetaITems = $recetaItems->where('receta_id', '=', $receta_id);

        $tipos = Tipo::all();
        $unidades = Unidad::all();
        $categorias = Categoria::all();
        $usuarios = Usuario::all();

        return view('planificacion/recetas.editar',
            compact('receta', 'tipos', 'ingredientes', 'recetaItems',
                'unidades', 'categorias', 'usuarios','formParams'));
    }

    public function editar(Request $request, $receta_id)
    {
        $request->validate(RecetaItem::$rules, RecetaItem::$errorMessages);
        $recetaItemBool = DB::table('recetasitems')
            ->where('receta_id', '=', $receta_id)
            ->where('ingrediente_id', '=', $request->input('ingrediente_id'))
            ->where('recetaItem_id','!=' , $request->input('recetaItem_id'))
            ->count();
        //ingrediente ya existe

        if ($recetaItemBool > 0){
            return redirect()
                ->route('recetasItems.index', compact('receta_id'))
                ->with('message', 'El ingrediente ya existe.')
                ->with('message_type', 'danger');
        }else {
            $recetaItem = RecetaItem::where('recetaItem_id', '=', $request->input('recetaItem_id'));
                 $recetaItem->update($request->only(['ingrediente_id', 'cant','usuario_id']));

             return redirect()
                ->route('recetasItems.index', compact('receta_id'))
                ->with('message', 'El ingrediente ha sido editado.')
                ->with('message_type', 'success');
        }
    }

//
//        if ($existe) {
//            return redirect()
//                ->route('recetasItems.index', compact('receta_id'))
//                ->with('message', ' Se edita.')
//                ->with('message_type', 'success');
//        }else
//        {
//            return redirect()
//                ->route('recetasItems.index', compact('receta_id'))
//                ->with('message', ' no se edita.' )
//                ->with('message_type', 'danger');
//        }
//    }

//      si existe pero es distinta cantidad edito
//        {
//            if  (RecetaItem::where('usuario_id', '!=', auth()->user()->usuario_id)) {
//
//                $recetaItem = RecetaItem::where('ingrediente_id', '=', $request->input('ingrediente_ant'))
//                and (RecetaItem::where('receta_id', '=', $receta_id));
//
//                $recetaItem->update($request->only(['ingrediente_id', 'cant','usuario_id']));
//            }else {
//
//                $recetaItem = RecetaItem::where('ingrediente_id', '=', $request->input('ingrediente_ant'))
//                and (RecetaItem::where('receta_id', '=', $receta_id));
//
//                $recetaItem->update($request->only(['ingrediente_id', 'cant']));
//            }
//             $receta = Receta::findOrFail($receta_id);
//
//            return redirect()
//                ->route('recetasItems.index', compact('receta_id'))
//                ->with('message', 'La receta fué editada con éxito!.' )
//                ->with('message_type', 'success');
//        }



    public function agregar(Request $request) {

        $formParams['nombre'] = '';
//       $request->validate(RecetaItem::$cant_add, RecetaItem::$errorMessages);
        $receta_id = Receta::findOrFail($request->input('receta_id'));

       $cantAdd = $request->input('cant_add');

        $existe = DB::table('recetasitems')
            //si el no existe
            ->where('receta_id', '=', $request->input('receta_id'))
            ->where('ingrediente_id', '=', $request->input('ingrediente_id'))
                ->count() > 0;

            //si no existe el ingrediente lo crea
            if (!$existe) {

//                $data['cant'] =  $cantAdd;
//                $data =$request->only(['usuario_id', 'ingrediente_id', 'receta_id']);
//                $recetaItems = $this->repository->create($data);
                    DB::table('recetasitems')->insert([
                        'usuario_id' =>  auth()->user()->usuario_id,
                        'ingrediente_id' => $request->input('ingrediente_id'),
                        'receta_id' => $request->input('receta_id'),
                        'cant' => $cantAdd,
                        'created_at' => date('Y-m-d'),
                        'updated_at' => date('Y-m-d'),
                    ]);

                $receta_id = Receta::findOrFail($request->input('receta_id'));

                $ingredientes = Ingrediente::all()->sortBy('nombre');

                $recetaItems = RecetaItem::all();

                $tipos = Tipo::all();
                $unidades = Unidad::all();
                $categorias = Categoria::all();

                return redirect()
                    ->route('recetasItems.index', compact('receta_id'))
                    ->with('message', 'El ingrediente ha sido agregado.')
                    ->with('message_type', 'success');



            } else {
                $receta_id = $request->input('receta_id');

                return redirect()
                    ->route('recetasItems.index', compact('receta_id'))
                    ->with('message', 'Ya existe ese ingrediente en la receta.')
                    ->with('message_type', 'danger');

            }
        }
}

