<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DishResource extends JsonResource
{
    protected bool $showIngredients = false;

    public function withIngredients(bool $show = true)
    {
        $this->showIngredients = $show;
        return $this;
    }

    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'slug'           => $this->slug,
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => $this->price,
            'image'          => $this->image ? Storage::url($this->image) : null,
            'thumbnail'      => $this->thumbnail ? Storage::url($this->thumbnail) : null,
            'average_rating' => $this->average_rating,
            'reviews_count'  => $this->reviews_count,
            'is_available'   => $this->is_available,
            'category'       => new CategoryResource($this->category),
            'restaurant_id'  => $this->restaurant_id,
            'allergy_status' => $this->allergy_status ?? null,
            'match_score'    => $this->match_score ?? null,
            $this->mergeWhen($this->showIngredients, [
                'ingredients' => IngredientResource::collection($this->ingredients),
            ]),
        ];
    }
}