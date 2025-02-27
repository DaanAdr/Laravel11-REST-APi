<?php

namespace App\Http\Requests\ApiFormRequests\v1;

use Illuminate\Foundation\Http\FormRequest;

class AgeRangeStoreAndPatchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'age_range' => 'required|string|max:255',
        ];
    }
}
