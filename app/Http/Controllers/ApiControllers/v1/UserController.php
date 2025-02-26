<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\LoginFormRequest;
use App\Http\Requests\ApiFormRequests\v1\RegisterFormRequest;
use App\Http\Resources\ApiResources\v1\LoginResource;
use App\Http\Resources\ApiResources\v1\RegisterResource;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    /**
     * Register new user
     */
    public function register(RegisterFormRequest $request): RegisterResource
    {
        $user = User::create($request->validated());
        return new RegisterResource($user);
    }

    /**
     * Login
     */
    public function login(LoginFormRequest $request)
    {
        if(Auth::attempt(['email' => $request->email,'password'=> $request->password])) {
            $user = Auth::user();
            $token = $user->createToken("SuperSecretKey")->plainTextToken;

            return new LoginResource($user->setAttribute('token', $token));
        }
        else
        {
            return response()->json(["error"=> "No such user"],404);
        }
    }
}
