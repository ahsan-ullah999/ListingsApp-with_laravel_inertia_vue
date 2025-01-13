<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class AuthenticateController extends Controller
{
    public function create(){
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request){
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($validation, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended();
        }
        return back()->withErrors([
            'email'=>'The provided credential do not match out records.'
        ])->onlyInput('email');
    }
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
