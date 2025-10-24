<?php

namespace App\Http\Controllers;

use App\Contracts\ResponseStrategy;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use App\Enums\ResponseStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
    public function __construct(ResponseStrategy $responder)
    {
        parent::__construct($responder);
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe checkout session
     */
    public function createCheckoutSession(Request $request)
    {
        $user = $request->user();

        $cartItems = Cart::with('dish')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return $this->responder->send(
                'Your cart is empty',
                status: ResponseStatus::BAD_REQUEST->value,
            );
        }

        $order = null;

        try {
            $total = $cartItems->sum(fn($item) => $item->dish->price * $item->quantity);

            // Create line items for Stripe
            $lineItems = $cartItems->map(function ($item) {
                return [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->dish->name,
                            'description' => $item->dish->description ?? '',
                        ],
                        'unit_amount' => (int) ($item->dish->price * 100), // Convert to cents
                    ],
                    'quantity' => $item->quantity,
                ];
            })->toArray();

            // Create a temporary order with pending payment status
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'payment_method' => 'card',
                'status' => OrderStatus::Pending->value,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'dish_id' => $cartItem->dish_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->dish->price,
                ]);
            }

            // Get frontend URL
            $frontendUrl = config('app.frontend_url');

            if (!$frontendUrl) {
                throw new \Exception('Frontend URL is not configured');
            }

            // Create Stripe checkout session
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => $frontendUrl . '/payment/success?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
                'cancel_url' => $frontendUrl . '/payment/cancel?order_id=' . $order->id,
                'customer_email' => $user->email,
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                ],
            ]);

            // Only commit if Stripe session was created successfully
            DB::commit();

            return $this->responder->send(
                'Checkout session created',
                [
                    'checkout_url' => $checkoutSession->url,
                    'session_id' => $checkoutSession->id,
                    'order_id' => $order->id,
                ]
            );

        } catch (\Throwable $error) {
            DB::rollBack();

            Log::error('Stripe checkout error', [
                'message' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
                'user_id' => $user->id ?? null,
            ]);

            return $this->responder->send(
                'Failed to create checkout session',
                ['error' => $error->getMessage()],
                ResponseStatus::INTERNAL_ERROR->value,
            );
        }
    }

    /**
     * Verify payment success
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'order_id' => 'required|exists:orders,id',
        ]);

        try {
            $session = Session::retrieve($request->session_id);

            if ($session->payment_status === 'paid') {
                $order = Order::findOrFail($request->order_id);

                // Update order status if not already updated by webhook
                if ($order->status === OrderStatus::Pending->value) {
                    $order->update(['status' => OrderStatus::Confirmed->value]);
                }

                // Clear the cart after successful payment
                Cart::where('user_id', $order->user_id)->delete();

                return $this->responder->send(
                    'Payment verified successfully',
                    [
                        'order' => $order->load('items.dish'),
                        'payment_status' => 'paid',
                    ]
                );
            }

            return $this->responder->send(
                'Payment not completed',
                ['payment_status' => $session->payment_status],
                ResponseStatus::BAD_REQUEST->value,
            );

        } catch (\Throwable $error) {
            Log::error('Payment verification error', [
                'message' => $error->getMessage(),
                'session_id' => $request->session_id ?? null,
            ]);

            return $this->responder->send(
                'Payment verification failed',
                ['error' => $error->getMessage()],
                ResponseStatus::INTERNAL_ERROR->value,
            );
        }
    }

    /**
     * Handle payment cancellation
     */
    public function cancelPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        try {
            $order = Order::findOrFail($request->order_id);

            // Cancel the order
            $order->update(['status' => OrderStatus::Cancelled->value]);

            return $this->responder->send(
                'Payment cancelled',
                ['order_id' => $order->id]
            );

        } catch (\Throwable $error) {
            return $this->responder->send(
                'Failed to cancel payment',
                ['error' => $error->getMessage()],
                ResponseStatus::INTERNAL_ERROR->value,
            );
        }
    }
}
