<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\ActorFormRequests\StoreActorFormRequest;
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
    public function store(StoreActorFormRequest $request): Actor
    {
        return Actor::create($request->validated());
    }
}
