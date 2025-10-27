<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($categoryId) {
                    if ($value && $categoryId && $value == $categoryId) {
                        $fail('A category cannot be its own parent.');
                    }
                },
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => strtolower($this->name ?? ''),
        ]);
    }
}
