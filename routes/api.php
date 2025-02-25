<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AgeRangeController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiresource('/v1/age_range', AgeRangeController::class);
Route::apiResource('/v1/movie', MovieController::class)->except(['update', 'show', 'destroy']);
Route::apiResource('/v1/actor', ActorController::class)->except(['update', 'show', 'destroy']);