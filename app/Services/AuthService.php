<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    // CREATE USER
    function signup($request)
    {
       $response =  User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);
        return ['status' => true,'response' => $response,'msg' => 'User registration successfully'];
    }
    // LOGIN 
    function login($request)
    {
        $userdata = ['email'=> $request->email,'password'  => $request->password];
        if (Auth::attempt($userdata)) // CHECK LOGIN
        {
            $user = Auth::user();
            $user->token =  $user->createToken('MyApp')-> accessToken; 
            return ['status' => true,'response' => $user,'msg' => 'User login successfully'];
        }
        else{
            return ['status' => false,'response' => '','msg' => 'Invalid credential'];
        }
    }
}

?>