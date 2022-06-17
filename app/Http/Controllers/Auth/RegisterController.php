<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() {
        return view('auth.register');
    }

    public function store(Request $request) {
        //dd($request);
       // dd($request->get('username'));
        //Modificando Request
        $request->request->add(['username' => Str::slug($request->username)]);//convierte a una url

       //Validation
       $this->validate($request,[
           'name'=>'required|min:5',
           'username'=>'required|unique:users|min:3|max:20',
           'email' =>'required|unique:users|email|max:600',
           'password' => 'required|confirmed|min:6'
       ]);

       User::create([
        'name'=> $request->name,
        'username'=>$request->username,
        'email'=>$request->email,
        'password'=>Hash::make($request->password)
       ]);

       //Autenticar un usuario
    //    auth()->attempt([
    //     'email'=>$request->email,
    //     'password'=>$request->password
    //    ]);
        //Otra forma de autenticar
        auth()->attempt($request->only('email','password'));

       //Redireccionando al usuario
       return redirect()->route('posts.index');
    }
}
