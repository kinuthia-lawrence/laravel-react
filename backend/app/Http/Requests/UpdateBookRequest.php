<?php

namespace App\Http\Requests;

use App\Enums\BookGenre;
use App\Enums\BookStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // No authentication for now
    }
    
    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'author' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url|max:2048',
            'book_url' => 'nullable|url|max:2048',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 5),
            'isbn' => 'nullable|string|max:20',
            'genre' => 'nullable|string|in:' . implode(',', BookGenre::values()),
            'status' => 'nullable|string|in:' . implode(',', BookStatus::values()),
            'pages' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ];
    }
}