<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Ingrediente;
use App\Models\Planificacion;
use App\Models\PlanificacionItem;
use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\Tipo;
use App\Models\Unidad;
use App\Models\Usuario;
use App\Repositories\RecetasRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; //cambia la url en img
use Illuminate\Support\Facades\Validator;
use http\Params;
use Illuminate\Bus\PrunableBatchRepository;
use Illuminate\Contracts\Validation\Rule;
use Intervention\Image\Facades\Image;
use App\Repositories\IngredienteRepository;
use App\Repositories\CategoriaRepository;
use PHPUnit\Framework\Constraint\IsEmpty;


class RecetasController extends Controller
{
    protected $repository;

    /**

     * @param RecetasRepository $repository
     */
    public function __construct(RecetasRepository $repository)

    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $formParams['nombre'] = '';
        $recetas =$this->repository->all();

        if (isset($formParams['nombre'])) {

            $formParams['nombre'] = $request->query('nombre');
            $recetas = $this->repository->allWhitParams($formParams);

                $pr = $this->repository->allWhitParams($formParams)->count()>0;
                if (!$pr) {
                    $request->session()->flash('message', 'La receta no existe'.$pr);
                    $request->session()->flash('message_type', 'danger');
                    $recetas = $this->repository->all();
                }else {
                    $request->session()->flash('message', '');
                    $request->session()->flash('message_type', 'transparent');
                }
        }
        return view('planificacion/recetas.index', compact('recetas', 'formParams'));
    }

    public function indexSinFormParams(Request $request)
    {
        $formParams['nombre'] = '';
        $recetas =$this->repository->all();

        return view('planificacion/recetas.index', compact('recetas', 'formParams'));

    }

    public function nuevo()
    {
        $unidades = Unidad::all();
        $categorias = Categoria::all();
        $tipos = Tipo::all();

        return view('planificacion/recetas.nuevo', compact('unidades', 'categorias','tipos'));
        }

    public function crear(Request $request)
    {
        $request->validate(Receta::$rules, Receta::$errorMessages);

        if (!$this->repository->getByName($request->input('nombre'))) {

            $request->validate(Receta::$rules, Receta::$errorMessages);
            $data =$request->only(['usuario_id', 'nombre', 'tipo', 'base', 'descripcion']);
            $data['imagen'] =  'img';
            if ($request->input('descripcion') == '') {
                $data['descripcion'] =  'Receta sin descripción';
            }
            //    Unidad::create($request->all());

            $receta = $this->repository->create($data);
            return redirect()->route('recetas.indexSinFormParams')
                // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
                ->with('message', 'La Receta se ha creado Exitosamente.')
                ->with('message_type', 'success');
        } else {
            return redirect()->route('recetas.indexSinFormParams')
                ->with('message', 'Ya existe una receta con esa descripción.')
                ->with('message_type', 'danger');
        }
    }

    public function editarForm(Request $request, Receta $receta)
    {
        $formParams['nombre'] = '';
        $ingredientes =Ingrediente::all();

        if (isset($formParams['nombre'])) {

            $formParams['nombre'] = $request->query('nombre');
//
//            $ingredientes = $this->repository->allWhitParams($formParams);
            $ingredientesQuery = Ingrediente::select('categoria_id',
                'nombre', 'ingrediente_id', 'unidad_id', 'impuesto')->with(['unidad', 'categoria'])
                ->orderBy('nombre');

            if (isset($searchParams['nombre'])) {
                $ingredientesQuery->where('nombre', 'like', '%' .
                    $searchParams['nombre'] . '%')->orderBy('nombre');
            }

            if ($ingredientes = $this->repository->allWhitParams($formParams)) {

                $pr = $this->repository->getByName($request);
                if ($pr) {
                    $request->session()->flash('message', 'El ingrediente no existe');
                    $request->session()->flash('message_type', 'danger');
                    $ingredientes = $this->repository->all();
                }
            }
            $ingredientes = Ingrediente::all()->sortBy('nombre');

            $recetaItems = $this->repository->getByRecetaItem($receta->receta_id);
            $tipos = Tipo::all();
            $unidades = Unidad::all();
            $categorias = Categoria::all();
            $usuarios = Usuario::all();
            $ingredienteEncontrado = '';

            return view('planificacion/recetas.editar', compact('receta', 'tipos', 'ingredientes', 'recetaItems', 'unidades', 'categorias', 'usuarios','formParams','ingredienteEncontrado'));

        }
    }

    public function eliminar($receta)
    {

        $existe = PlanificacionItem::where('receta_id', '=', $receta)
            ->select('receta_id')
            ->get()
            ->count()==0;

        if ($existe){
            $receta = DB::table('recetas')->where('receta_id','=', $receta)->delete();
                return redirect()
                    ->route('recetas.indexSinFormParams')
                    ->with('message', 'La receta fué eliminada con éxito !.')
                    ->with('message_type', 'success');
            } else {

                return redirect()
                    ->route('recetas.indexSinFormParams')
                    ->with('message', 'La receta está siendo utilizada en la planificación!.')
                    ->with('message_type', 'danger');
            }


//            return view('planificacion/recetas.index',array('message'=>'La receta se eliminó', compact('recetas', 'formParams')));
        }

    public function IngredienteRecetaEliminar(Ingrediente $ingrediente, Receta $receta)
    {
        /* $existe = DB::table('carrito')
             ->where('ingrediente_id', '=', $receta->ingrediente_id)
             ->get();
         $existePago = DB::table('pagos')
             ->where('ingrediente_id', '=', $receta->ingrediente_id)
             ->get();

         if ($existe->isEmpty() and $existePago->isEmpty())
   */
        {
          //  $receta = $this->repository->delete($receta->receta_id);

            $eliminar = $this->repository->deleteIngredienteReceta($receta->receta_id, $ingrediente->ingrediente_id);
            return redirect()->route('/planificacion/recetas.index')
                ->with('message', 'La receta se eliminó exitosamente.')
                ->with('message_type', 'success');
        }
        /*else{
            return redirect()->route('ingredientes.index')
                ->with('message', 'El ingrediente se está usando en este momento y
                            no puede ser eliminado.')
                ->with('message_type', 'danger');
        }*/
    }
    public function editarCabecera(Request $request, $receta_id)
    {
        $request->validate(Receta::$rules, Receta::$errorMessages);
        $recetaBol = DB::table('recetas')
            ->where('receta_id', '!=', $receta_id)
            ->where('nombre', '=', $request->input('nombre'))
            ->count();
        //el nombre de la receta ya existe

        if ($recetaBol > 0) {
            $receta = Receta::findOrFail($receta_id);

            $formParams['nombre'] = '';
            $ingredientes = Ingrediente::all()->sortBy('nombre');

            $recetaItems = RecetaItem::all();
            $recetaItems = $recetaItems->where('receta_id', '=', $receta_id);
            $tipos = Tipo::all();
            $unidades = Unidad::all();
            $categorias = Categoria::all();
            $usuarios = Usuario::all();

            $request->session()->flash('message','Ya existe una receta con ese nombre ');
            $request->session()->flash('message_type', 'danger');

            return view('planificacion/recetas.editar', compact('receta', 'tipos', 'ingredientes',
                'recetaItems', 'unidades', 'categorias', 'receta_id','usuarios','formParams'));
        }
         else {
            $receta = $this->repository->getByPk($receta_id);
             if ($request->input('descripcion') == '') {
                 $descripcion = '';

                 $receta->descripcion = $descripcion;

                 $receta->update($request->only(['nombre', 'base', 'tipo_id']));
             }else {
                 $receta->update($request->only(['nombre', 'base', 'tipo_id', 'descripcion']));
             }
                 $formParams['nombre'] = '';
                 $ingredientes = Ingrediente::all()->sortBy('nombre');

                 $receta = Receta::findOrFail($receta_id);
                 $recetaItems = RecetaItem::all();
                 $recetaItems = $recetaItems->where('receta_id', '=', $receta_id);
                 $tipos = Tipo::all();
                 $unidades = Unidad::all();
                 $categorias = Categoria::all();
                 $usuarios = Usuario::all();

                 $request->session()->flash('message','La receta fue editada Exitosamente ');
                 $request->session()->flash('message_type', 'success');

                 return view('planificacion/recetas.editar', compact('receta', 'tipos', 'ingredientes',
                     'recetaItems', 'unidades', 'categorias', 'receta_id','usuarios','formParams')
                 );
         }
    }
 }


