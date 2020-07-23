<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if(Auth::check())
        {
            return redirect()->route('admin.home');
        }
        return view('admin.index');
    }

    public function home()
    {
        $users = Auth::user();
        return view('admin.dashboard', compact('users'));
    }

    public function login(Request $request)
    {
        if(in_array('', $request->only('email', 'password'))) {
            $json['message'] = $this->message->error('Ooops, informe todos os dados para efetuar o login')->render();
            return response()->json($json);
        }

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL))
        {
            $json['message'] = $this->message->error('Ooops, informe um e-mail válido')->render();
            return response()->json($json);
        }

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if(!Auth::attempt($credentials))
        {
            $json['message'] = $this->message->error('Usuário e senha não conferem')->render();
            return response()->json($json);
        } else {
            $json['message'] = $this->message->success('Logado com sucesso :-)')->render();
            $json['redirect'] = route('admin.home');
            return response()->json($json);
        }
    }

    public function logout()
    {
        Auth::logout();
        $json['message'] = $this->message->success('Deslogado com sucesso :-)')->render();
        return redirect()->route('admin.login');
    }
}
