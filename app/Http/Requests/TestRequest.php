<?php

namespace App\Http\Requests;
use App\Rules\FileRule;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', new FileRule()],
        ];
    }
}
