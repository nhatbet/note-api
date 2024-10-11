<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'content' => 'bail|required|string|max:2000',
            'type' => [
                'required',
                Rule::in([Report::TYPE_1, Report::TYPE_2, Report::TYPE_3, Report::TYPE_4])
            ],
        ];
    }
}
