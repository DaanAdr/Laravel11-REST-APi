<?php

namespace App\Http\Requests\ApiFormRequests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'age_range_id' => 'required|integer|exists:age_ranges,id',
            'name' => 'required|string|max:255',
        ];
    }
}
