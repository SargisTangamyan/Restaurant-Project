<template>
  <div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto text-center">
      <div v-if="loading" class="py-12">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-gray-900 mx-auto"></div>
        <p class="mt-4 text-gray-600">Verifying your payment...</p>
      </div>

      <div v-else-if="success" class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-green-500 mb-4">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
        <p class="text-gray-600 mb-6">Your order has been confirmed.</p>
        <div class="bg-gray-50 rounded p-4 mb-6">
          <p class="text-sm text-gray-600">Order ID</p>
          <p class="font-mono text-lg font-semibold">#{{ orderId }}</p>
        </div>
        <div class="space-y-3">
          <router-link
            to="/user"
            class="block w-full button-cgreen transition"
          >
            View My Orders
          </router-link>
          <router-link
            to="/dishes"
            class="block w-full border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition"
          >
            Continue Shopping
          </router-link>
        </div>
      </div>

      <div v-else class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-red-500 mb-4">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Payment Verification Failed</h1>
        <p class="text-gray-600 mb-6">{{ errorMessage }}</p>
        <router-link
          to="/cart"
          class="inline-block button-cgreen transition"
        >
          Return to Cart
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import {sender} from "@/api/Sender.js";
import {STRIPE_VERIFY_PAYMENT} from "@/constants/urls.js";

const route = useRoute();
const loading = ref(true);
const success = ref(false);
const errorMessage = ref('');
const orderId = ref(null);

onMounted(async () => {
  const sessionId = route.query.session_id;
  orderId.value = route.query.order_id;

  if (!sessionId || !orderId.value) {
    errorMessage.value = 'Invalid payment session';
    loading.value = false;
    return;
  }

  try {
    const response = await sender.sendRequest('POST', STRIPE_VERIFY_PAYMENT, {
      session_id: sessionId,
      order_id: orderId.value,
    });

    if (response.data.payment_status === 'paid') {
      success.value = true;
    } else {
      errorMessage.value = 'Payment was not completed';
    }
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Payment verification failed';
  } finally {
    loading.value = false;
  }
});
</script>
