<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'bail|required|unique:users|email|max:255',
            'name' => 'bail|required|string|max:255',
            'username' => 'bail|required|unique:users|string|max:255',
            'password' => 'bail|required_with:password_confirmation|same:password_confirmation|string|max:255',
            'password_confirmation' => 'bail|required|string|max:255',
        ];
    }
}
