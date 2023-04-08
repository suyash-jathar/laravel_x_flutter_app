<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth\Sanctum;
use App\Models\User;


class AuthController extends Controller
{
    //Register user
    public function register(Request $request)
    {
        // validate incoming request
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // create user 
        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password'])
        ]);

        // return user with token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ]);
    }

    //Login user
    public function login(Request $request)
    {
        // validate incoming request
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // attempt login
        if (!Auth::attempt($attrs)) {
            return response([
                'user' => Auth::user(),
                'message' => 'Invalid credentials'
            ], 401);
        }

        // return user with token in response
        return response([
            'user' => Auth::user(),
            'token' => Auth::user()->createToken('secret')->plainTextToken
        ]);
    }

    // logout user
    public function logout(){
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logged out'
        ], 200);
    }

    // get user details
    public function user(){
        return response([
            'user' => auth()->user()
        ], 200);
    }

}
