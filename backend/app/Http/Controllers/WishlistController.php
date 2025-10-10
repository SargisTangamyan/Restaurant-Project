<?php

namespace App\Http\Controllers;

use App\Http\Resources\DishResource;
use App\Models\Dish;
use Illuminate\Http\Request;
use App\Enums\ResponseStatus;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlist = $request->user()->wishlist()->get();

        return $this->responder->send(
            'Wishlist Contains',
            ['wishlist' => DishResource::collection($wishlist)],
        );
    }

    public function store(Request $request, Dish $dish)
    {
        $user = $request->user();

        if ($user->wishlist()->where('dish_id', $dish->id)->exists()) {
            return $this->responder->send(
                'Already in Wishlist',
                status: ResponseStatus::CONFLICT->value,
            );
        }

        $user->wishlist()->attach($dish->id);
        return $this->responder->send(
            'Added to Wishlist',
        );
    }

    public function destroy(Request $request, String $id)
    {
        $user = $request->user();
        $user->wishlist()->detach($id);

        return $this->responder->send(
            'Dish removed from Wishlist'
        );
    }
}
