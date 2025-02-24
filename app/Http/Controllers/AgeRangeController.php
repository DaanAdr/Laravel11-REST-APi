<?php

namespace App\Http\Controllers;

use App\Models\AgeRange;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class AgeRangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return AgeRange::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "age_range" => "required",
        ]);

        return AgeRange::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return AgeRange::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "age_range" => "required|regex:/^[\p{L}]+$/u",
        ]);

        $ageRange = $this->show($id);
        return $ageRange->update($request->all()); #Updates the entire record
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ageRange = $this->show($id);

        return $ageRange->delete();
    }
}
