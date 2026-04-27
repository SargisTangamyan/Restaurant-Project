<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DishReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'user_name'  => trim($this->user->first_name . ' ' . $this->user->last_name),
            'user_image' => $this->user->profile_image ? Storage::url($this->user->profile_image) : null,
            'rating'     => $this->rating,
            'comment'    => $this->comment,
            'created_at' => $this->created_at->format('F j, Y'),
        ];
    }
}