<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\MovieFormRequests\StoreMovieFormRequest;
use App\Models\Movie;
use App\Http\Resources\ApiResources\v1\MovieResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
    /**
     * GET all Movies
     */
    public function index(): AnonymousResourceCollection
    {
        $movies = Movie::with('age_range')->with('actors')->get();
        return MovieResource::collection($movies);
    }

    /**
     * POST Movie
     */
    public function store(StoreMovieFormRequest $request): MovieResource
    {
        $movie = Movie::create($request->validated());
        return new MovieResource($movie);
    }
}
