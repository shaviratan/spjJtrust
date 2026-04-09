<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoHP implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // contoh validasi nomor HP hanya angka dan panjang minimal 10
        if (!preg_match('/^[0-9]{10,15}$/', $value)) {
            $fail('Format nomor HP tidak valid.');
        }
    }
}
