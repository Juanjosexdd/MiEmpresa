<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function logueo(Request $request)
    {
        $name       = trim($request->input('name'));
        $password   = trim($request->input('password'));

        if(empty($name))
        {
            return redirect()->route('login')->with('noty' , 'El campo no puede estar vacío');
        }
        if(empty($password))
        {
            return redirect()->route('login')->with('noty' , 'El campo no puede estar vacío');
        }

        $credentials =
        [
            'name'      => $name,
            'password'  => $password
        ];
        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('admin.home');
        }

        return redirect()->route('login')->with('noty' , 'Las credenciales son incorrectas');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

}
