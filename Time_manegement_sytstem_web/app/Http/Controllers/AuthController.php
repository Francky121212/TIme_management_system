<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //

    public function validator(Request $validator){

        $validator = $request->all();
            $validator = Validator::make($request)([
                'Firstname' => 'required|string|max:255',
                'Lastname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                "role" => 'required|enum',
                'password' => 'required|string|min:8',
            ]);
        }


    public function register(Request $request){

        $user = User::create([
        'Firstname' => $request->Firstname,
        'Lastname' => $request->Lastname,
        'email' => $request->email,
        'role' => $request->role,
        'password' =>Hash::make($request ->password),
        ]);

        return redirect('/success');

    }


public function AdminLogin(){
    $admin = User::create([
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'Admin'
    ]);
}
    
    



}
