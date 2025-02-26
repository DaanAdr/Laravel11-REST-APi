<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\MovieFormRequests\StoreMovieFormRequest;
use App\Models\Movie;
use App\Http\Resources\MovieResource;

class MovieController extends Controller
{
    /**
     * GET all Movies
     */
    public function index()
    {
        $movies = Movie::with('age_range')->with('actors')->get();
        return MovieResource::collection($movies);
    }

    /**
     * POST Movie
     */
    public function store(StoreMovieFormRequest $request): Movie
    {
        return Movie::create($request->validated());
    }
}
