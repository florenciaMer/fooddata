<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Ingrediente;
use App\Models\Receta;
use App\Models\Tipo;
use App\Models\Unidad;
use App\Models\Usuario;
use http\Params;
use Illuminate\Bus\PrunableBatchRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; //cambia la url en img
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Repositories\IngredienteRepository;
use App\Repositories\CategoriaRepository;
use App\Http\Controllers\RecetasItemsController;
use App\Models\RecetaItem;

class IngredienteController extends Controller
{
    protected $repository;

    /**
     * IngredientesController constructor.
     * Le pedimos a Laravel que nos inyecte en el constructor la clase asociada a la interface
     * IngredienteRepositoty.
     * Esa asociación la tenemos en AppServiceProvider.
     *
     * @param IngredienteRepository $repository
     */
    public function __construct(IngredienteRepository $repository)

    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $formParams['nombre'] = '';
        $ingredientes =$this->repository->all();

        if (isset($formParams['nombre'])) {

            $formParams['nombre'] = $request->query('nombre');
            $ingredientes = $this->repository->allWhitParams($formParams);

            if ($ingredientes = $this->repository->allWhitParams($formParams)) {

                $pr = $this->repository->getByName($request);
                if ($pr) {
                    $request->session()->flash('message', 'El Ingrediente no existe');
                    $request->session()->flash('message_type', 'danger');
                    $ingredientes = $this->repository->all();
                }
            }
        }
        return view('stock/ingredientes.index', compact('ingredientes', 'formParams'));
    }
    /**

     * CategoriaRepositoty.
     * Esa asociación la tenemos en AppServiceProvider.
     *
     * @param CategoriaRepository $repositorioCate
     */
    public function nuevo()
    {
        // $this->repositoryCate = $repositoryCate;
        $unidades = Unidad::all();
        $categorias = Categoria::all();
        //  $categorias = $this->repositoryCate->all();


        return view('stock/ingredientes.nuevo', compact('unidades', 'categorias'));
    }

    public function ver(Ingrediente $ingrediente)
    {
        //  $ingrediente = Ingrediente::faind($ingrediente);
        return view('ingredientes.ver', compact('ingrediente'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function crear(Request $request)
    {
        $request->validate(Ingrediente::$rules, Ingrediente::$errorMessages);

        //si no existe el ingrediente lo crea
        if (!$this->repository->getByNameOnly($request->input('nombre'))) {

                $data =$request->only(['usuario_id', 'categoria_id', 'nombre', 'impuesto', 'precio', 'unidad_id']);
                $ingrediente = $this->repository->create($data);

                return redirect()->route('ingredientes.index')
                    ->with('message', 'El ingrediente se creó exitosamente.')
                    ->with('message_type', 'success');

        } else {
            return redirect()->route('ingredientes.index')
                ->with('message', 'El ingrediente ya existe.')
                ->with('message_type', 'danger');
        }
    }

    public function eliminar(Request $request, Ingrediente $ingrediente)
    {
        $existe = $this->repository->searchRecetaItem($ingrediente);

        if (!$existe)
        {
            $ingrediente = $this->repository->delete($ingrediente->ingrediente_id);

            return redirect()->route('ingredientes.index')
                ->with('message', 'El ingrediente se eliminó exitosamente.' .$existe)
                ->with('message_type', 'success');
        }
        else{
            return redirect()->route('ingredientes.index')
                ->with('message', 'El ingrediente está usando en este momento y
                            no puede ser eliminado.')
                ->with('message_type', 'danger');
        }
    }
    public function editarForm(Ingrediente $ingrediente)
    {
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        return view('stock/ingredientes.editar', compact('ingrediente', 'unidades', 'categorias'));
    }

    public function editar(Request $request, Ingrediente $ingrediente)
    {
        $request->validate(Ingrediente::$rules, Ingrediente::$errorMessages);
        if ($this->repository->getByName($request) and (!$this->repository->getByPk($ingrediente->ingrediente_id))) {
            $this->repository->update($ingrediente->ingrediente_id, $request->only(['categoria_id', 'nombre', 'precio', 'unidad_id'.'impuesto']));
            return redirect()
                ->route('ingredientes.index')
                ->with('message', 'El ingrediente fue editado con éxito!!.');
        }

        if ($request->input('nombre') == $ingrediente->nombre) {

            $request->validate(Ingrediente::$rules, Ingrediente::$errorMessages);

            $this->repository->update($ingrediente->ingrediente_id, $request->only(['categoria_id', 'nombre', 'precio', 'unidad_id','impuesto']));
            return redirect()
                ->route('ingredientes.index')
                ->with('message', 'El ingrediente fue editado con éxito.');
        }


        if (($this->repository->getByNameOnly($request->input('nombre'))) and (($this->repository->getByPk($ingrediente->ingrediente_id)->count()) > 1)) {
            return redirect()
                ->route('ingredientes.index')
                ->with('message', 'Ya existe un ingrediente con esa descripción.')
                ->with('message_type', 'danger');
        } else {

            $this->repository->update($ingrediente->ingrediente_id, $request->only(['categoria_id', 'nombre', 'precio', 'unidad_id','impuesto']));
            //  $ingrediente->update($request->only(['categoria_id', 'nombre', 'precio', 'unidad_id', 'imagen']));

            return redirect()
                ->route('ingredientes.index')
                ->with('message', 'El ingrediente fue editado con éxito !.');
        }
    }
  }
