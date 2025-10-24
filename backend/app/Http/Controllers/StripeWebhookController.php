<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeWebhookController extends CashierController
{
    /**
     * Handle checkout session completed event
     */
    public function handleCheckoutSessionCompleted(array $payload)
    {
        Log::info('Checkout session completed', ['payload' => $payload]);

        $session = $payload['data']['object'];
        $orderId = $session['metadata']['order_id'] ?? null;

        if (!$orderId) {
            Log::error('Order ID not found in session metadata');
            return;
        }

        $order = Order::find($orderId);

        if (!$order) {
            Log::error('Order not found: ' . $orderId);
            return;
        }

        // Update order status to confirmed
        $order->update([
            'status' => OrderStatus::Confirmed->value,
        ]);

        // Clear the user's cart
        Cart::where('user_id', $order->user_id)->delete();

        Log::info('Order confirmed successfully', ['order_id' => $orderId]);
    }

    /**
     * Handle payment intent succeeded event
     */
    public function handlePaymentIntentSucceeded(array $payload)
    {
        Log::info('Payment intent succeeded', ['payload' => $payload]);

        // Additional logic if needed
    }

    /**
     * Handle payment intent failed event
     */
    public function handlePaymentIntentPaymentFailed(array $payload)
    {
        Log::error('Payment intent failed', ['payload' => $payload]);

        $paymentIntent = $payload['data']['object'];

        // Extract metadata if available
        $orderId = $paymentIntent['metadata']['order_id'] ?? null;

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['status' => OrderStatus::Cancelled->value]);
                Log::info('Order cancelled due to payment failure', ['order_id' => $orderId]);
            }
        }
    }
}
