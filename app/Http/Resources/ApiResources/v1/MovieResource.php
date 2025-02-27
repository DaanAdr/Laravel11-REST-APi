<?php

namespace App\Http\Resources\ApiResources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age_range' => $this->age_range->age_range, // Accessing the string value
            'actors' => $this->actors->pluck('name')->toArray()
        ];
    }
}
