<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DishResource extends JsonResource
{
    protected bool $showIngredients = false;

    public function withIngredients(bool $show = true) {
        $this->showIngredients = $show;
        return $this;
    }


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image ? Storage::url($this->image) : null,
            'thumbnail' => $this->thumbnail ? Storage::url($this->thumbnail) : null,
            'category' => new CategoryResource($this->category),
            'allergy_status' => $this->allergy_status ?? null,
            'match_score'    => $this->match_score ?? null,
            $this->mergeWhen($this->showIngredients, [
                'ingredients' => IngredientResource::collection($this->ingredients),
            ]),
        ];
    }
}
