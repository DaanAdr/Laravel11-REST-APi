<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

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
