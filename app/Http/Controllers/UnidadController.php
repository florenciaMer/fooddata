<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;
use App\Models\Unidad;
use Illuminate\Http\Request;
use App\Repositories\UnidadRepository;

class UnidadController extends Controller
{
    protected $repository;

    /**
     * ProductosController constructor.
     * Le pedimos a Laravel que nos inyecte en el constructor la clase asociada a la interface
     * ProductoRepositoty.
     * Esa asociación la tenemos en AppServiceProvider.
     *
     * @param UnidadRepository $repository
     */
    public function __construct(UnidadRepository $repository)

    {
        $this->repository = $repository;
    }
    public function index()
    {
        /** @var TYPE_NAME $unidades */

        //$unidades = Unidad::all();
        $unidades = $this->repository->all();
        return view('/stock/ingredientes/unidades.index', compact('unidades'));
    }

    public function nuevo()
    {
        return view('/stock/ingredientes/unidades.nuevo');
    }

    public function crear(Request $request)
    {
        $unidadName = $this->repository->getByName( $request);
        if (!$unidadName) {
            //   if (!(Unidad::where('nombre', '=', $request->input('nombre'))->count() > 0)) {

            $request->validate(Unidad::$rules, Unidad::$errorMessages);
            //    Unidad::create($request->all());

            $data =$request->only(['nombre']);
            $unidad = $this->repository->create($data);

            return redirect()->route('unidades.index')
                // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
                ->with('message', 'La Unidad se ha creado Exitosamente.')
                ->with('message_type', 'success');
        } else {
            return redirect()->route('unidades.index')
                ->with('message', 'La Unidad ya existe.')
                ->with('message_type', 'danger');
        }
    }

    public function eliminar(Request $request, Unidad $unidad)
    {
        // $existe = (Unidad::where('unidad_id', $unidad->unidad_id)->has('productos')->count());
        $existe = $this->repository->searchProducts($unidad);
        if ($existe == 0) {
            //  $unidad->delete();
            $unidad = $this->repository->delete($unidad->unidad_id);

            //   $unidad->delete();

            return redirect()->route('unidades.index')
                ->with('message', 'La Unidad de Medida se eliminó exitosamente.')
                ->with('message_type', 'success');

        } else {
            return redirect()->route('unidades.index')
                ->with('message', 'La Unidad de Medida está siendo utilizada por uno o mas Productos.')
                ->with('message_type', 'danger');
        }
    }

    public function editarForm(Unidad $unidad)
    {
        return view('/stock/ingredientes/unidades.editar', compact('unidad'));
    }

    public function editar(Request $request, Unidad $unidad)
    {

        $request->validate(Unidad::$rules, Unidad::$errorMessages);
        /* if (!(Unidad::where('nombre', '=', $request->input('nombre'))->count() > 0)
           and (Unidad::where('producto_id', '=', $request->input('producto_id'))->count()))
        */
        if ($this->repository->getByName($request) and (!$this->repository->getByPk($unidad->unidad_id)))
        {
            $this->repository->update($unidad->unidad_id, $request->only(['nombre']));
            return redirect()
                ->route('undiades.index')
                ->with('message', 'La unidad de editó con éxito!!.');
        }
        if ($request->input('nombre') == $unidad->nombre) {

            $this->repository->update($unidad->unidad_id, $request->only(['nombre']));
            return redirect()
                ->route('unidades.index')
                ->with('message', 'La unidad se editó con éxito.');
        }

        if (($this->repository->getByNameOnly($request->input('nombre')))
            and (($this->repository->getByPk($unidad->unidad_id)->count())>1))
        {
            return redirect()
                ->route('unidades.index', $unidad)
                ->with('message', 'Ya existe una unidad con esa descripción.' )
                ->with('message_type', 'danger');
        } else {

            $this->repository->update($unidad->unidad_id, $request->only(['nombre']));
            return redirect()
                ->route('unidades.index')
                ->with('message', 'La unidad se editó con éxito.');
            //  $unidad->update($request->only(['categoria_id', 'nombre', 'precio', 'unidad_id', 'imagen']));
        }
    }
    public function select(){ $unidad=DB::table('unidades')
        ->select('nombre')
        ->get();
        return view('pruebas.select')->with('unidad',$unidad);
    }
    public function postSelect(Request $request){
        dd($request->all());
    }

}


