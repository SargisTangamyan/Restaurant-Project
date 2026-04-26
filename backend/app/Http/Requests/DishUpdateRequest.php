<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishUpdateRequest extends FormRequest
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
            'restaurant_id'          => 'exists:restaurants,id',
            'category_id'            => 'exists:categories,id',
            'slug'                   => 'string|max:255|unique:dishes,slug,' . $this->dish?->id,
            'name'                   => 'string|max:255',
            'description'            => 'nullable|string',
            'price'                  => 'numeric|min:0',
            'image'                  => 'nullable|image|max:2048',
            'is_available'           => 'boolean',
            'ingredients'            => 'nullable|array',
            'ingredients.*.id'       => 'exists:ingredients,id',
            'ingredients.*.quantity' => 'decimal:0,2|max:50',
        ];
    }
}
