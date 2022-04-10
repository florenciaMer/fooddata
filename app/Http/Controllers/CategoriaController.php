<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Ingrediente;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;
use App\Repositories\CategoriaRepository;

class CategoriaController extends Controller
{
    protected $repository;

    /**
     *
     * @param CategoriaRepository $repository
     */
    public function __construct(CategoriaRepository $repository)

    {
        $this->repository = $repository;
    }
    public function nuevo()
    {
        return view('/stock/ingredientes/categorias.nuevo');
    }

    public function index(){
        /** @var TYPE_NAME $categorias */

//        session()->flash('message','');
//        session()->flash('message_type','transparent');
        //  $productos = $this->repository->all();
        $categorias = $this->repository->all();
        return view('/stock/ingredientes/categorias.index', compact('categorias'));
    }

    public function crear(Request $request)
    {
        $request->validate(Categoria ::$rules, Categoria ::$errorMessages);

        $categoriaName = $this->repository->getByName( $request);
        if (!$categoriaName) {

            $data =$request->only(['nombre']);
            $categoria = $this->repository->create($data);
            return redirect()->route('categorias.index')
                ->with('message', 'La Categoría se ha creado Exitosamente.')
                ->with('message_type', 'success');
        }else{
            return redirect()->route('categorias.index')
                // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
                ->with('message', 'La Categoría y existe.')
                ->with('message_type', 'danger');
        }
    }

    public function eliminar(Request $request, Categoria $categoria)
    {
        $existe = $this->repository->searchProducts($categoria);
        if ($existe == 0) {
            //  $categoria->delete();
            $categoria = $this->repository->delete($categoria->categoria_id);
            return redirect()->route('categorias.index')
                ->with('message', 'La categoria se elimino correctamente')
                ->with('message_type', 'success');
        }else{
            return redirect()->route('categorias.index')
                ->with('message', 'La categoría está siendo utilizada por uno o varios productos.')
                ->with('message_type', 'danger');
        }
    }
    public function editarForm(Categoria $categoria)
    {
        return view('/stock/ingredientes/categorias.editar', compact('categoria'));
    }

    public function editar(Request $request, Categoria $categoria)
    {
        $request->validate(Categoria ::$rules, Categoria ::$errorMessages);
        if ($this->repository->getByName($request) and (!$this->repository->getByPk($categoria->categoria_id)))
        {
            $this->repository->update($categoria->nombre, $request->only(['nombre']));
            return redirect()
                ->route('categorias.index')
                ->with('message', 'La Categoría de editó con éxito!!.');
        }
        if ($request->input('nombre') == $categoria->nombre) {
            $this->repository->update($categoria->categoria_id, $request->only(['nombre']));
            return redirect()
                ->route('categorias.index')
                ->with('message', 'La categoria se editó con éxito.');
        }

        if (($this->repository->getByNameOnly($request->input('nombre')))
            and (($this->repository->getByPk($categoria->categoria_id)->count())>1))
        {
            return redirect()
                ->route('categorias.index', $categoria)
                ->with('message', 'Ya existe una categoria con esa descripción.' )
                ->with('message_type', 'danger');
        } else {

            $this->repository->update($categoria->categoria_id, $request->only(['nombre']));
            return redirect()
                ->route('categorias.index')
                ->with('message', 'La categoria se editó con éxito.');
        }
    }
}
