<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Dish;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function calculateTotal(int $userId)
    {
        return Cart::where('user_id', $userId)->with('dish')->get()->sum(function ($item) {
            return $item->dish->price * $item->quantity;
        });
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $cartItems = Cart::with('dish')->where('user_id', $user->id)->get();

        $collection = new CartCollection($cartItems);

        return $this->responder->send('Cart Content', $collection->toArray($request));
    }

    public function count(Request $request)
    {
        $user = $request->user();
        $count = Cart::where('user_id', $user->id)->count();

        return $this->responder->send('Cart Count', ['count' => $count]);
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

        // Load the dish relationship
        $cartItem->load('dish');

        return $this->responder->send(
            'Dish added to cart',
            [
                'cart' => new CartResource($cartItem),
            ],
        );
    }

    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = $request->user()->id;

        $cartItem = Cart::where('user_id', $userId)->where('dish_id', $dish->id)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        // Load the dish relationship
        $cartItem->load('dish');

        $total = $this->calculateTotal($userId);

        return $this->responder->send(
            'Cart updated',
            [
                'cart' => new CartResource($cartItem),
                'total' => $total,
            ]
        );
    }

    public function destroy(Request $request, Dish $dish)
    {
        $userId = $request->user()->id;

        $cartItem = Cart::where('user_id', $userId)->where('dish_id', $dish->id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        $total = $this->calculateTotal($userId);

        return $this->responder->send(
            'Dish removed from the cart',
            ['total' => $total]
        );
    }
}
