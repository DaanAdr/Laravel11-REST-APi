<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actor;
use Illuminate\Database\Eloquent\Collection;

class ActorController extends Controller
{
    /**
     * GET all Actors
     */
    public function index(): Collection
    {
        return Actor::all();
    }

    /**
     * POST Actor
     */
    public function store(Request $request): Actor
    {
        $request->validate([
            "name" => "required",
        ]);

        return Actor::create($request->all());
    }
}
