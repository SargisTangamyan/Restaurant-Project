<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Dish;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $cartItems = Cart::with('dish')->where('user_id', $userId)->get();
        return $this->responder->send(
            'Cart Content',
            [
                'dishes' => $cartItems,
            ]
        );
    }

    public function store(Request $request, Dish $dish)
    {
        $request->validate([
            'quantity' => 'integer|min:1',
        ]);

        $userId = $request->user()->id;
        $quantity = $request->quantity ?? 1;

        $cartItem = Cart::firstOrCreate(
            ['user_id' => $userId, 'dish_id' => $dish->id],
            ['quantity' => 0]
        );

        $cartItem->quantity += $quantity;
        $cartItem->save();

        return $this->responder->send(
            'Dish added to cart',
            [
                'cart' => $cartItem,
            ],
        );
    }

    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::findOrFail($dish->id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return $this->responder->send(
            'Cart updated',
            [
                'cart' => $cartItem,
            ]
        );
    }

    public function destroy(Dish $dish)
    {
        $cartItem = Cart::findOrFail($dish->id);
        $cartItem->delete();

        return $this->responder->send(
            'Dish removed from the cart'
        );
    }
}
