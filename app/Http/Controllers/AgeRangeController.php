<?php

namespace App\Http\Controllers;

use App\Models\AgeRange;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $request->validate([
            "age_range" => "required",
        ]);

        return AgeRange::create($request->all());
    }

    /**
     * GET AgeRange by ID
     */
    public function show(string $id)
    {
        return AgeRange::findOrFail($id);
    }

    /**
     * PUT AgeRange
     */
    public function update(Request $request, string $id)
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
    public function destroy(string $id)
    {
        $ageRange = $this->show($id);

        return $ageRange->delete();
    }
}
