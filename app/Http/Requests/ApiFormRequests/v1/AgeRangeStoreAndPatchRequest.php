<?php

namespace App\Http\Requests\ApiFormRequests\v1;

use Illuminate\Foundation\Http\FormRequest;

class AgeRangeStoreAndPatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'age_range' => 'required|string|max:255'
        ];
    }
}
