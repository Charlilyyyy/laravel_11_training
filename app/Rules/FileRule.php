<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FileRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Ensure the value is a valid uploaded file
        if (!File::isFile($value)) {
            $fail('The :attribute is not a valid file.');
            return;
        }

        // Check file size (e.g., max 2MB)
        $maxSizeInBytes = 2 * 1024 * 1024; // 2MB
        if ($value->getSize() > $maxSizeInBytes) {
            $fail('The :attribute must not exceed 2MB in size.');
            return;
        }

        // Check file type (e.g., only allow images)
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($value->getMimeType(), $allowedMimeTypes)) {
            $fail('The :attribute must be a valid image file (jpeg, png, gif).');
        }
    }
}
