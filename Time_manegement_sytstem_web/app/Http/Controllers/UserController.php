<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        if(Auth::check()){
            if(Auth::user()->role ==='Admin'){
                return redirect()->route('dashboard');
            }else{
                return('Success');
            }
        }
        return view('welcome');
    }
}
