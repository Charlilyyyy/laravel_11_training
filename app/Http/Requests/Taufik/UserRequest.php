<?php

namespace App\Http\Requests\Taufik;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules(): object
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email','unique:users,email'],
            'password' => ['required'],
        ];
    }
}
