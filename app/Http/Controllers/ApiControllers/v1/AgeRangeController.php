<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiFormRequests\v1\AgeRangeFormRequests\StoreAgeRangeFormRequest;
use Illuminate\Http\Request;
use App\Models\AgeRange;
use Illuminate\Database\Eloquent\Collection;

class AgeRangeController extends Controller
{
    /**
     * GET all AgeRanges
     */
    public function index(): Collection
    {
        return AgeRange::all();
    }

    /**
     * POST AgeRange
     */
    public function store(StoreAgeRangeFormRequest $request): AgeRange
    {
        return AgeRange::create($request->validated());
    }

    /**
     * GET AgeRange by ID
     */
    public function show(int $id): AgeRange
    {
        return AgeRange::findOrFail($id);
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
