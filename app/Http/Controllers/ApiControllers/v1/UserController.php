<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\UserFormRequests\LoginFormRequest;
use App\Http\Requests\ApiFormRequests\v1\UserFormRequests\RegisterFormRequest;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    /**
     * Register new user
     * @param \App\Http\Requests\ApiFormRequests\v1\UserFormRequests\RegisterFormRequest $request
     * @return User
     */
    public function register(RegisterFormRequest $request): User
    {
        return User::create($request->validated());
    }

    /**
     * Login
     * @param \App\Http\Requests\ApiFormRequests\v1\UserFormRequests\LoginFormRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(LoginFormRequest $request)
    {
        // TODO: Use the form request
        
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
