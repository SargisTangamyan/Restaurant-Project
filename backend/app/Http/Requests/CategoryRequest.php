<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CategoryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        // When updating, we must ignore the current record in the unique rule.
        $categoryId = $this->route('category')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],

            // parent_id is optional, but if present it must point to an existing category
            // and cannot point to itself
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

    /**
     * Additional validation after basic rules.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (isset($this->name) && $this->checkForSimilarName($this->name)) {
                    $validator->errors()->add(
                        'name',
                        'There is a category with almost the same name!'
                    );
                }
            },
        ];
    }

    /**
     * Custom method to check for similar names using slug comparison.
     */
    private function checkForSimilarName(string $name): bool
    {
        $slug = Category::makeSimpleSlug($name);

        $query = Category::where('slug', $slug);

        // Ignore the current category when updating
        if ($this->route('category')) {
            $query->where('id', '!=', $this->route('category')->id);
        }

        return $query->exists();
    }
}
