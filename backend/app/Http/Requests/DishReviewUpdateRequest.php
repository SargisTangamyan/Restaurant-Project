<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishReviewUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating'  => ['sometimes', 'numeric', 'min:0.5', 'max:5', function (string $attribute, mixed $value, \Closure $fail) {
                if (fmod((float) $value * 2, 1) !== 0.0) {
                    $fail('The rating must be in 0.5 increments.');
                }
            }],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }
}