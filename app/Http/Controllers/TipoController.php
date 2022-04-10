<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Tipo;
use Illuminate\Http\Request;
use App\Repositories\TipoRepository;

class TipoController extends Controller
{
    protected $repository;

    /**
     * TiposController constructor.
     *
     * @param TipoRepository $repository
     */
    public function __construct(TipoRepository $repository)

    {
        $this->repository = $repository;
    }
    public function index()
    {
        /** @var TYPE_NAME $tipos */

        $tipos = $this->repository->all();
        return view('/planificacion/recetas/tipo.index', compact('tipos'));
    }

    public function nuevo()
    {
        return view('/planificacion/recetas/tipo.nuevo');
    }

    public function crear(Request $request)
    {
        $tipoName = $this->repository->getByName( $request);
        if (!$tipoName) {
            //   if (!(Tipo::where('nombre', '=', $request->input('nombre'))->count() > 0)) {

            $request->validate(Tipo::$rules, Tipo::$errorMessages);
            //    Tipo::create($request->all());

            $data =$request->only(['nombre']);
            $tipo = $this->repository->create($data);

            return redirect()->route('tipos.index')
                // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
                ->with('message', 'El Tipo de receta se ha creado Exitosamente.')
                ->with('message_type', 'success');
        } else {
            return redirect()->route('tipos.index')
                ->with('message', 'El Tipo de receta ya existe.')
                ->with('message_type', 'danger');
        }
    }

    public function eliminar(Request $request, Tipo $tipo)
    {
        $existe = $this->repository->searchRecetaTipo($tipo);

        if (!$existe) {

            $tipo = $this->repository->delete($tipo->tipo_id);

            return redirect()->route('tipos.index')
                ->with('message', 'El tipo de receta se eliminó exitosamente.' .$existe)
                ->with('message_type', 'success');

        } else {
            return redirect()->route('tipos.index')
                ->with('message', 'El tipo de receta está siendo utilizado por una o mas Recetas.')
                ->with('message_type', 'danger');
        }
    }

    public function editarForm(Tipo $tipo)
    {
        return view('/planificacion/recetas/tipo.editar', compact('tipo'));
    }

    public function editar(Request $request, Tipo $tipo)
    {

        $request->validate(Tipo::$rules, Tipo::$errorMessages);
        /* if (!(Tipo::where('nombre', '=', $request->input('nombre'))->count() > 0)
           and (Tipo::where('producto_id', '=', $request->input('producto_id'))->count()))
        */
        if ($this->repository->getByName($request) and (!$this->repository->getByPk($tipo->tipo_id)))
        {
            $this->repository->update($tipo->tipo_id, $request->only(['nombre']));
            return redirect()
                ->route('undiades.index')
                ->with('message', 'El tipo de receta se editó con éxito!!.');
        }
        if ($request->input('nombre') == $tipo->nombre) {

            $this->repository->update($tipo->tipo_id, $request->only(['nombre']));
            return redirect()
                ->route('tipos.index')
                ->with('message', 'El tipo de receta se editó con éxito.');
        }

        if (($this->repository->getByNameOnly($request->input('nombre')))
            and (($this->repository->getByPk($tipo->tipo_id)->count())>1))
        {
            return redirect()
                ->route('tipos.index', $tipo)
                ->with('message', 'Ya existe un tipo de receta con esa descripción.' )
                ->with('message_type', 'danger');
        } else {

            $this->repository->update($tipo->tipo_id, $request->only(['nombre']));
            return redirect()
                ->route('tipos.index')
                ->with('message', 'El tipo de receta se editó con éxito.');
            //  $tipo->update($request->only(['categoria_id', 'nombre', 'precio', 'tipo_id', 'imagen']));
        }
    }

}
