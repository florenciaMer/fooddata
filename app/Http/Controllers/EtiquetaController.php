<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;
use App\Repositories\EtiquetaRepository;
use Illuminate\Http\Request;
use http\Params;
use Illuminate\Bus\PrunableBatchRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Composer\Autoload\includeFile;


class EtiquetaController extends Controller
{
    protected $repository;
    /**
     *
     * @param EtiquetaRepository $repository
     */
    public function __construct(EtiquetaRepository $repository)

    {
        $this->repository = $repository;
    }
    public function nuevo()
    {
        return view('/planificacion/servicios/etiquetas.nuevo');
    }

    public function index(){
        /** @var TYPE_NAME $etiquetas */

        $etiquetas = $this->repository->all()->sortBy('nombre');
        return view('planificacion/servicios/etiquetas.index', compact('etiquetas'));
    }

    public function crear(Request $request)
    {
        $request->validate(Etiqueta ::$rules, Etiqueta ::$errorMessages);

        $etiquetaName = $this->repository->getByName( $request);
        if (!$etiquetaName) {

            $data =$request->only(['nombre']);
            $etiqueta = $this->repository->create($data);
            return redirect()->route('etiquetas.index')
                ->with('message', 'La Etiqueta se ha creado Exitosamente.')
                ->with('message_type', 'success');
        }else{
            return redirect()->route('etiquetas.index')
                // with() nos permite sumarle una "variable flash" de sesión a la respuesta.
                ->with('message', 'La Etiqueta y existe.')
                ->with('message_type', 'danger');
        }
    }

    public function eliminar(Request $request, $etiqueta)
    {
        $existeEnPlanif = $this->repository->getByEtiqPlanif($etiqueta);
           if ($existeEnPlanif != 1) {
               $existeEnClienteServicios = $this->repository->getByClientServPlanif($etiqueta);
               if ($existeEnClienteServicios != 1){
                   $etiqueta = $this->repository->getByPk($etiqueta);
                     $etiqueta->delete();
                   return redirect()->route('etiquetas.index')
                       ->with('message', 'El servicio se elimino correctamente')
                       ->with('message_type', 'success');
               }else {
                   return redirect()->route('etiquetas.index')
                       ->with('message', 'El servicio está siendo utilizada por algún cliente.')
                       ->with('message_type', 'danger');
               }
           }else{
               return redirect()->route('etiquetas.index')
                ->with('message', 'El servicio está siendo utilizada en la planificación.')
                ->with('message_type', 'danger');
           }
        }

    public function editarForm(Etiqueta $etiqueta)
    {
        return view('planificacion/servicios/etiquetas.editar', compact('etiqueta'));
    }

    public function editar(Request $request, Etiqueta $etiqueta)
    {
        $request->validate(Etiqueta ::$rules, Etiqueta ::$errorMessages);
        if ($this->repository->getByName($request) and (!$this->repository->getByPk($etiqueta->etiqueta_id)))
        {
            $this->repository->update($etiqueta->nombre, $request->only(['nombre']));
            return redirect()
                ->route('etiquetas.index')
                ->with('message', 'El Servicio de editó con éxito!!.');
        }
        if ($request->input('nombre') == $etiqueta->nombre) {
            $this->repository->update($etiqueta->etiqueta_id, $request->only(['nombre']));
            return redirect()
                ->route('etiquetas.index')
                ->with('message', 'El servicio se editó con éxito.');
        }

        if (($this->repository->getByNameOnly($request->input('nombre')))
            and (($this->repository->getByPk($etiqueta->etiqueta_id)->count())>1))
        {
            return redirect()
                ->route('etiquetas.index', $etiqueta)
                ->with('message', 'Ya existe una etiqueta con esa descripción.' )
                ->with('message_type', 'danger');
        } else {

            $this->repository->update($etiqueta->etiqueta_id, $request->only(['nombre']));
            return redirect()
                ->route('etiquetas.index')
                ->with('message', 'El servicio se editó con éxito.');
        }
    }
}
