<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Send_mail;



class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

   public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard'); 
        }
      

        return back()->withErrors(['email' => 'Identifiants incorrects']);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/register');
    }
}