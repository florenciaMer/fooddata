<?php

namespace App\Http\Controllers;

use App\Models\Condicion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;
use http\Params;
use Illuminate\Bus\PrunableBatchRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class CondicionController extends Controller
{

    public function nuevo()
    {
        return view('condiciones.nuevo');
    }

    public function index(){
        /** @var TYPE_NAME $condiciones */

        $condicion = Condicion::all()->sortBy('nombre');
        return $condicion;
        return view('condiciones.index', compact('condiciones'));
    }

    public function crear(Request $request)
    {
        $request->validate(Condicion ::$rules, Condicion ::$errorMessages);

        $condicionName = $this->repository->getByName( $request);
        if (!$condicionName) {

            $data =$request->only(['nombre']);
            $condicion = $this->repository->create($data);
            return redirect()->route('condiciones.index')
                ->with('message', 'el condicion se ha creado Exitosamente.')
                ->with('message_type', 'success');
        }else{
            return redirect()->route('condiciones.index')
                // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
                ->with('message', 'el condicion y existe.')
                ->with('message_type', 'danger');
        }
    }

    public function eliminar(Request $request, Condicion $condicion)
    {
        $existe = $this->repository->searchProducts($condicion);

        $condicion = $this->repository->delete($condicion->condicion_id);
        return redirect()->route('condiciones.index')
            ->with('message', 'La condicion se elimino correctamente')
            ->with('message_type', 'success');
    }
    public function editarForm(Condicion $condicion)
    {
        return view('condiciones.editar', compact('condicion'));
    }

    public function editar(Request $request, Condicion $condicion)
    {
        $request->validate(Condicion ::$rules, Condicion ::$errorMessages);
        if ($this->repository->getByName($request) and (!$this->repository->getByPk($condicion->condicion_id)))
        {
            $this->repository->update($condicion->nombre, $request->only(['nombre','nombreFantasia','direccion','condicion']));
            return redirect()
                ->route('condiciones.index')
                ->with('message', 'La condicion de editó con éxito!!.');
        }
        if ($request->input('nombre') == $condicion->nombre) {
            $this->repository->update($condicion->condicion_id, $request->only(['nombre']));
            return redirect()
                ->route('condiciones.index')
                ->with('message', 'La condicion se editó con éxito.');
        }

        if (($this->repository->getByNameOnly($request->input('nombre')))
            and (($this->repository->getByPk($condicion->condicion_id)->count())>1))
        {
            return redirect()
                ->route('condiciones.index', $condicion)
                ->with('message', 'Ya existe una condicion con esa descripción.' )
                ->with('message_type', 'danger');
        } else {

            $this->repository->update($condicion->condicion_id, $request->only(['nombre']));
            return redirect()
                ->route('condiciones.index')
                ->with('message', 'La condicion se editó con éxito.');
        }
    }
}
