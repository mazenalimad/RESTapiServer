<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $fields = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'fname' => $fields['fname'],
            'lname'=> $fields['lname'],
            'email'=> $fields['email'],
            'type' => 'basic',
            'password'=> bcrypt($fields['password']),
        ]);

        $token = $user->createToken('basic')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response,201);
    }
    
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();
        if(!$user || !Hash::check($fields['password'], $user->password)){ 
            return response([
                'message' => 'Bad creds'
            ],401);
        }


        $token = $user->createToken('basic')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response,201);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message'=> 'logged out'
        ];
    }
}
