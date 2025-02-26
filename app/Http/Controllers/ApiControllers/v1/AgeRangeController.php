<?php

namespace App\Http\Controllers\ApiControllers\v1;

use App\Http\Controllers\Controller;
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
    public function store(Request $request): AgeRange
    {
        $request->validate([
            "age_range" => "required",
        ]);

        return AgeRange::create($request->all());
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
