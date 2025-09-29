<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->checkForSimilarName($this->name)) {
                    $validator->errors()->add(
                        'name',
                        'There is a category with almost the same name!'
                    );
                }
            }
        ];
    }

    private function checkForSimilarName(string $name): bool
    {
        $slug = Category::makeSimpleSlug($name);
        $categoryWithSameSlug = Category::where('slug', $slug)->first();
        return (bool)$categoryWithSameSlug;
    }
}
