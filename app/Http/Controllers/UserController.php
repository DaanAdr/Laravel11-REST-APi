<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    /**
     * POST register
     * @param \Illuminate\Http\Request $request
     * @return User
     */
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
        ]);
    
        return User::create($request->all());
    }

    /**
     * POST login
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email,'password'=> $request->password])) {
            $user = Auth::user();
    
            $response = [];
            $response["token"] = $user->createToken("SuperSecretKey")->plainTextToken;
            $response["name"] = $user->name;
            $response["email"] = $user->email;
           
            return response()->json($response, 200);
        }
        else
        {
            return response()->json(["error"=> "No such user"],404);
        }
    }
}
