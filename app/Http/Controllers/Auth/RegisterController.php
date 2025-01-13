<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function create(){
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request){
        sleep(2);
        $validation = $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|lowercase|email|max:255',
            'password'=>'required|confirmed|min:6'

        ]);
        $user = User::create($validation);

        //send verification email
        Auth::login($user);
        return redirect()->route('home');
    }
}
