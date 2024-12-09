<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'context' => ['required', 'string', 'max:255'],
        ];
    }

    protected function failedAuthorization()
    {
        abort(403, 'You are not authorized to create a post.');
    }
}
