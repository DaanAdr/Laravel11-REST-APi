<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AgeRangeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/age_range', AgeRangeController::class);

        Route::apiResource('/movie', MovieController::class)->except(['update', 'show', 'destroy', 'index']);
    
        Route::apiResource('/actor', ActorController::class)->except(['update', 'show', 'destroy']);
    });

    Route::get('/movie', [MovieController::class, 'index']);
    
    Route::prefix('/user')->group(function () {
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/login', [UserController::class, 'login']);
    });
});
#endregion