<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cart' => $this->collection,
            'total' => $this->calculateTotal(),
        ];
    }

    protected function calculateTotal(): float
    {
        return $this->collection->sum(function ($item) {
            return $item->resource->dish->price * $item->resource->quantity;
        });
    }
}
