<template>
  <profile-box heading="Order Detail">
    <div class="max-w-5xl mx-auto p-5">
      <!-- Back Button -->
      <button
        @click="goBack"
        class="mb-4 text-blue-600 hover:text-blue-800 flex items-center gap-2"
      >
        Back to Orders
      </button>

      <!-- Loader -->
      <the-loader v-if="isLoading" />

      <!-- Order Found -->
      <div v-else-if="order" class="bg-white rounded-lg">
        <!-- Header -->
        <div class="mb-6 border-b pb-4">
          <h1 class="text-2xl font-bold mb-2">Order #{{ order.id }}</h1>
          <p class="text-gray-600">Placed on {{ formatDate(order.created_at) }}</p>
        </div>

        <!-- Order Info & Delivery -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <div class="p-4 border rounded-lg bg-white">
            <h3 class="font-semibold mb-3">Order Information</h3>
            <div class="space-y-2 text-sm">
              <p>
                <span class="text-gray-600 inline-block pr-2">Status:</span>
                <order-status-badge :status="order.status" />
              </p>
              <p>
                <span class="text-gray-600">Total:</span>
                <span class="font-semibold ml-2">${{ order.total_price }}</span>
              </p>
            </div>
          </div>
        </div>

        <!-- Items -->
        <div>
          <h3 class="font-semibold mb-4 text-lg">Order Items</h3>
          <div class="space-y-3">
            <div
              v-for="item in order.order_items"
              :key="item.id"
              class="flex gap-4 p-4 border rounded-lg bg-white hover:shadow-sm transition"
            >
              <div class="w-20 h-20 object-cover rounded">
                <image-display :image-path="item.dish.thumbnail" :alt="item.dish.name" />
              </div>
              <div class="flex-1">
                <h4 class="font-semibold">{{ item.dish.name }}</h4>
                <p class="text-sm text-gray-600">Quantity: {{ item.quantity }}</p>
              </div>
              <div class="text-right">
                <p class="font-semibold">${{ item.price }}</p>
                <p class="text-sm text-gray-600">
                  ${{ item.price * item.quantity }} total
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Not Found -->
      <div v-else class="text-center py-12">
        <p class="text-gray-500">Order not found.</p>
      </div>
    </div>
  </profile-box>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useOrderStore } from '@/stores/index.js'
import ProfileBox from "@/components/profile/ProfileBox.vue"
import OrderStatusBadge from "@/components/order/OrderStatusBadge.vue";
import ImageDisplay from "@/components/ui/image/ImageDisplay.vue";

const route = useRoute()
const router = useRouter()
const ordersStore = useOrderStore()

const order = computed(() => ordersStore.getSelectedOrder)
const isLoading = computed(() => ordersStore.isLoading)

const goBack = () => {
  router.push({ name: 'my_orders' })
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}

onMounted(() => {
  const orderId = route.params.id
  ordersStore.fetchOrderDetails(orderId)
})
</script>
