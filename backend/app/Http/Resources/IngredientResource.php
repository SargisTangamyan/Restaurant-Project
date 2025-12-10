<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IngredientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'unit' => $this->unit,
            'price' => $this->price,
            'is_allergic' => $this->is_allergic,
        ];

        $quantity = $this->pivot?->quantity;
        if ($quantity) {
            $resource['quantity'] = $quantity;
        }

        return $resource;
    }
}
