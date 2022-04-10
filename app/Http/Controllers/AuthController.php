<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm(){
        return view('usuarios.login');
    }

    public function login (Request $request)
    {
        if ($request->validate(Usuario::$validarEmailPassword, Usuario::$errorMessages)) {
            $credenciales = $request->only('password', 'email');

            if (!auth()->attempt($credenciales)) {
                return redirect()->route('auth.login')
                    ->withInput()  //envia los datos del form para poder levantarlos con la funcion all
                    ->with('message', 'Las credenciales no son correctas. Volvé a intentarlo')
                    ->with('message_type', 'danger');
            }

            return view('/index')
                ->with('message', 'Bienvenido!!')
                ->with('message_type', 'success');
        } else {
            return view('/login')
                ->with('message', 'Las credenciales no son correctas!!')
                ->with('message_type', 'danger');
        }
    }

    public function logout(){
        auth() ->logout();
        return redirect()->route('auth.login')
            ->with('message', 'Sesión Finalizada.')
            ->with('message_type', 'success');

    }

}
