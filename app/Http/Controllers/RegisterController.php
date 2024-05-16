<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function index() 
    {
        return view('auth.registro');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'username' => ['required','unique:users'],
            'email' => ['required','unique:users','email'],
            'password' => ['required','confirmed']
        ]);

        User::create([
            'name' => $request -> name,
            'username' => Str::slug($request -> username),
            'email' => $request -> email,
            'password' => $request -> password
        ]);

        // auth()->attempt([
        //     'email' => $request -> email,
        //     'password' => $request -> password
        // ]);

        auth()->attempt($request->only('email','password'));

        return redirect()->route('posts.index');
    }
}
