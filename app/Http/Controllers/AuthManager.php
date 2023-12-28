<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    function login()
    {
        return view('/login');
    }
    function loginPost(Request $request)
    {
        print_r($request);
        $request->validate([
            'email' =>'required',
            'password' =>'required'
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            return redirect()->intended(route('home'))->with("success","Login success");;
        }
        return redirect(route('login'))->with("error","Login details are incorrect");
    }
    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
