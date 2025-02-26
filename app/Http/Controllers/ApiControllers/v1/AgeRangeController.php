<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\AgeRangeFormRequests\StoreAgeRangeFormRequest;
use App\Http\Resources\ApiResources\v1\AgeRangeResource;
use Illuminate\Http\Request;
use App\Models\AgeRange;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AgeRangeController extends Controller
{
    /**
     * GET all AgeRanges
     */
    public function index(): AnonymousResourceCollection
    {
        $age_ranges = AgeRange::all();
        return AgeRangeResource::collection($age_ranges);
    }

    /**
     * POST AgeRange
     */
    public function store(StoreAgeRangeFormRequest $request): AgeRangeResource
    {
        $age_range = AgeRange::create($request->validated());
        return new AgeRangeResource($age_range);
    }

    /**
     * GET AgeRange by ID
     */
    public function show(int $id): AgeRangeResource
    {
        $age_range = AgeRange::findOrFail($id);
        return new AgeRangeResource($age_range);
    }

    /**
     * PUT AgeRange
     */
    public function update(Request $request, int $id): bool
    {
        $request->validate([
            "age_range" => "required",
        ]);

        $ageRange = $this->show($id);
        return $ageRange->update($request->all()); #Updates the entire record
    }

    /**
     * DELETE AgeRange
     */
    public function destroy(int $id): bool|null
    {
        $ageRange = $this->show($id);

        return $ageRange->delete();
    }
}
