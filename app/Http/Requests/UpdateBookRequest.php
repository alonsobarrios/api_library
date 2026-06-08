<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|max:20|unique:books,isbn',
            'publication_year' => 'sometimes|required|integer|min:1000|max:' . date('Y'),
            'pages' => 'sometimes|required|integer|min:1',
            'description' => 'sometimes|required|string',
            'available_stock' => 'sometimes|required|integer|min:0',
            'authors' => 'sometimes|required|array|min:1',
            'authors.*' => 'exists:authors,id'
        ];
    }
}
