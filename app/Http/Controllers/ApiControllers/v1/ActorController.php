<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\ActorFormRequests\StoreActorFormRequest;
use App\Http\Resources\ApiResources\v1\ActorResource;
use App\Models\Actor;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ActorController extends Controller
{
    /**
     * GET all Actors
     */
    public function index(): AnonymousResourceCollection
    {
        $actors = Actor::all();
        return ActorResource::collection($actors);
    }

    /**
     * POST Actor
     */
    public function store(StoreActorFormRequest $request): ActorResource
    {
        $actor = Actor::create($request->validated());
        return new ActorResource($actor);
    }
}
