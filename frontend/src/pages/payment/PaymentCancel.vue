<template>
  <div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto text-center">
      <the-loader v-if="loading" />

      <div v-else class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-yellow-500 mb-4">
          <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Payment Cancelled</h1>
        <p class="text-gray-600 mb-6">Your payment was cancelled. The order has been cancelled and your cart items are still available.</p>
        <div class="space-y-3">
          <router-link
            :to="{name: 'cart'}"
            class="block w-full button-cgreen transition"
          >
            Return to Cart
          </router-link>
          <router-link
            :to="{name: 'dishes'}"
            class="block w-full border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition"
          >
            Continue Shopping
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import {sender} from "@/api/Sender.js";
import {STRIPE_CANCEL_PAYMENT} from "@/constants/urls.js";
import TheLoader from "@/components/ui/TheLoader.vue";

const route = useRoute();
const loading = ref(true);

onMounted(async () => {
  const orderId = route.query.order_id;

  if (orderId) {
    try {
      await sender.sendRequest('POST', STRIPE_CANCEL_PAYMENT, {
        order_id: orderId,
      });
    } catch (error) {
      console.error('Failed to cancel payment:', error);
    }
  }

  loading.value = false;
});
</script>
