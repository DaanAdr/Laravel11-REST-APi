<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AgeRangeController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiresource('/v1/age_range', AgeRangeController::class);
Route::apiResource('/v1/movie', MovieController::class)->except(['update', 'show', 'destroy']);
Route::apiResource('/v1/actor', ActorController::class)->except(['update', 'show', 'destroy']);


#region Auth stuff
Route::post('/v1/user/register', function (Request $request) {
    $request->validate([
        "name" => "required",
        "email" => "required|email",
        "password" => "required",
    ]);

    return User::create($request->all());
});

Route::post("/v1/user/login", function (Request $request) {
    if(Auth::attempt(['email' => $request->email,'password'=> $request->password])) {
        $user = Auth::user();

        $response = [];
        $response["token"] = $user->createToken("SuperSecretKey")->plainTextToken;
        $response["name"] = $user->name;
        $response["email"] = $user->email;
       
        return $response;
    }
    else
    {
        return response()->json(["error"=> "No such user"],404);
    }
});
#endregion