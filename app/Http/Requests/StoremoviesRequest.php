<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoremoviesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',  // Make sure 'name' is required and validated
            'released_at' => 'nullable|integer|min:1900|max:'.(date('Y') + 1),
            'posterUrl' => 'nullable|string',
            'synopsis' => 'nullable|string',
            'duration' => 'nullable|integer',
            'averageRating' => 'nullable|numeric|min:0|max:10',
            'url' => 'nullable|url',
        ];
    }
}
