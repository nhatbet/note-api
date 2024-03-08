<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'bail|string|max:255',
            'content' => 'bail|string|max:3000',
            'solution' => 'bail|string|max:3000',
            'tags' => 'array|required|max:4',
            'tags.*' => 'bail|required|string',
        ];
    }
}
