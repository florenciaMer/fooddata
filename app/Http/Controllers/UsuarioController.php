<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use App\Repositories\UsuarioRepository;
use Auth;

class UsuarioController extends Controller
{
    protected $repository;

    /**
     *
     * @param \App\Http\Repositories\UsuarioRepository $repository
     */
    public function __construct(UsuarioRepository $repository)

    {
        $this->repository = $repository;
    }

    public function nuevo()
    {
        return view('usuarios.nuevo');
    }

    public function crear(Request $request)
    {
        if (!(Usuario::where('email', '=', $request->input('email'))->count() > 0)) {

            $request->validate(Usuario::$rules, Usuario::$errorMessages);
            $data =$request->only([ 'email', 'nombre', 'rol']);
            $data['password'] = Hash::make($request->input('password'));
            $usuario = $this->repository->create($data);

           /* DB::table('usuarios')->insert([
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'nombre' => $request->input('nombre'),
                'token' => 0,
                'rol' => $request->input('rol'),
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ]);
*/
            $credenciales = $request->only('password', 'email');

            if (auth()->attempt($credenciales)) {
                return redirect()->route('auth.login')
                    ->withInput()  //envia los datos del form para poder levantarlos con la funcion all
                    ->with('message', 'Solo tenés que loguearte')
                    ->with('message_type', 'success');
            } else {
                return redirect()
                    ->route('usuarios.nuevo')
                    ->with('message', 'El usuario ya existe!!.')
                    ->with('message_type', 'danger');
            }
        } else {
            return redirect()
                ->route('usuarios.nuevo')
                ->with('message', 'Ese usuario ya existe por favor probá con otro Email!!.')
                ->with('message_type', 'danger');
        }
    }
}
