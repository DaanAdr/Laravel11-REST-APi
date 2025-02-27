<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\AgeRangeStoreAndPatchRequest;
use App\Http\Resources\ApiResources\v1\AgeRangeResource;
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
    public function store(AgeRangeStoreAndPatchRequest $request): AgeRangeResource
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
    public function update(int $id, AgeRangeStoreAndPatchRequest $request): bool
    {
        $age_range = AgeRange::findOrFail($id);

        return $age_range->update($request->validated());
    }

    /**
     * DELETE AgeRange
     */
    public function destroy(int $id): bool
    {
        $age_range = AgeRange::findOrFail($id);
    
        return $age_range->delete() === true; // This is to ensure a boolean return type
    }
}
