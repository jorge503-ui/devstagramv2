<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user){
        return view('perfil.index');
    }

    public function store(Request $request){

        $request->request->add(['username' => Str::slug($request->username)]);//convierte a una url

        $this->validate($request, [
            'username'=> ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20', 'not_in:twitter,editar-perfil'],
        ]);
    }
}
