<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    function login()
    {
        return view('/login');
    }
    function loginPost(Request $request)
    {

        $request->validate([
            'email' =>'required',
            'password' =>'required'
        ]);

        $employee = Employee::where('email','=', $request->email)->first();
        if ($employee)
        {
            if(Hash::check($request->password, $employee->password))
            {
                $request->session()->regenerate();
                $request->session()->put('loginId', $employee->id);
                return redirect('dashboard');
            }else
            {
                return back()->with('fail','Password not matches.');
            }
        } else
        {
            return back()->with('fail','Username not registered.');
        }
        /*
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials))
        //{
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with("success","Login success");;
        //}
        return redirect(route('login'))->with("error","Login details are incorrect");
        */
    }
    function logout()
    {
        //method1: logout
        if(Session::has('loginId'))
        {
            Session::pull('loginId');
            return redirect(route('login'));
        }

        //method2: logout
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
    function dashboard()
    {
        $data = array();
        if(Session::has('loggedIn'))
        {
            $data = Employee::where('id','=', Session::get('loggedIn'))->first();
        }
        return view('dashboard',compact('data'));
    }
    function addEmployee(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'password' =>'required|min:6|max:15',
            'mobileNumber' =>'required|min:10|max:15'
        ]);

        $empolyee=new Employee();
        $empolyee->name=$request->name;
        $empolyee->password=Hash::make($request->password);
        $empolyee->mobileNumber=$request->mobileNumber;
        $res=$empolyee->save();
        if($res)
        {
            return back()->with('success','Employee registered successfully');
        }else
        {
            return back()->with('fail','Somting wrong');
        }


    }
}
