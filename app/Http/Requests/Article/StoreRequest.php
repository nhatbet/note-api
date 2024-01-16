<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'bail|required|string|max:255',
            'content' => 'bail|required|string|max:3000',
            'status' => 'bail|integer|min:1',
            'tags' => 'array|max:4',
            'tags.*' => 'bail|required|string',
        ];
    }
}
