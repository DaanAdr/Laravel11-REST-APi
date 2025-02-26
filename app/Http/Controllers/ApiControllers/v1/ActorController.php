<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actor;

class ActorController extends Controller
{
    /**
     * GET all Actors
     */
    public function index()
    {
        return Actor::all();
    }

    /**
     * POST Actor
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
        ]);

        return Actor::create($request->all());
    }
}
