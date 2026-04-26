<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DishStoreRequest extends FormRequest
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
            'restaurant_id'          => 'required|exists:restaurants,id',
            'category_id'            => 'required|exists:categories,id',
            'slug'                   => 'nullable|string|max:255|unique:dishes,slug',
            'name'                   => 'required|string|max:255',
            'description'            => 'nullable|string',
            'price'                  => 'required|numeric|min:0',
            'image'                  => 'required|image|max:10240',
            'is_available'           => 'boolean',
            'ingredients'            => 'nullable|array',
            'ingredients.*.id'       => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'nullable|decimal:0,2|max:50',
        ];
    }
}
