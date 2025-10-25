<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Enums\ResponseStatus;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $user = $request->user();

        $orders = Order::with('items.dish')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        return $this->responder->send(
            'Your Orders',
            ['orders' => new OrderCollection($orders)],
        );
    }

    public function show(Request $request, int $id)
    {
        $user = $request->user();
        $currentOrder = $user->orders()->with('items.dish')->findOrFail($id);
        return $this->responder->send(
            'Current Order',
            ['order' => new OrderResource($currentOrder)],
        );
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $cartItems = Cart::with('dish')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return $this->responder->send(
                'Your cart is empty',
                status: ResponseStatus::BAD_REQUEST->value,
            );
        }

        DB::beginTransaction();
        try {
            $total = $cartItems->sum(fn($item) => $item->dish->price * $item->quantity);

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'payment_method' => $request->input('payment_method', 'cash'),
                'status' => 'pending',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'dish_id' => $cartItem->dish_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->dish->price,
                ]);
            }

            // Clear the cart after placing the order
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return $this->responder->send(
                'Order placed successfully',
                [
                    'order_id' => $order->id,
                    'total_price' => $total,
                ],
            );
        } catch (\Throwable $error) {
            DB::rollBack();
            return $this->responder->send(
                'Order creation failed',
                [
                    'error' => $error->getMessage(),
                ],
                ResponseStatus::INTERNAL_ERROR->value,
            );
        }
    }

    // Update order status (admin or system)
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,completed,delivered,cancelled',
        ]);

        $oldStatus = $order->status->value;
        $order->update(['status' => $request->status]);

        return $this->responder->send(
            "Order status updated from {$oldStatus} to {$order->status->value}",
            ['order' => $order],
        );
    }

    // Cancel order (user)
    public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)->findOrFail($id);

        if (!$order->canBeCancelled()) {
            return $this->responder->send(
                'Order cannot be cancelled anymore',
                status: ResponseStatus::BAD_REQUEST->value,
            );
        }

        $order->update(['status' => OrderStatus::Cancelled->value]);

        return $this->responder->send('Order cancelled successfully');
    }
}
