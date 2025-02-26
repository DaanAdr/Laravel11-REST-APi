<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $request->validate([
            "age_range_id" => "required|regex:/^[-+]?\d+$/",
            "name" => "required",
        ]);

        return Movie::create($request->all());
    }
}
