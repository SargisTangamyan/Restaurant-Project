<script setup>

// COMPONENTS
import OrderStatusBadge from "@/components/order/OrderStatusBadge.vue";
import OrderItemList from "@/components/order/OrderItemList.vue";
import OrderStatusActions from "@/components/order/OrderStatusActions.vue";

// COMPOSABLE
import {useFormatters} from "@/composables/useFormatter.js";
const {formatDate} = useFormatters();

// EMITS
const emit = defineEmits(['status-updated']);

// PROPS
const props = defineProps({
  order: {
    type: Object,
    required: true,
  },
  isUpdating: {
    type: Boolean,
    default: false,
  }
});


// METHODS
const handleStatusUpdate = async (newStatus) => {
  emit('status-updated', {orderId: props.order.id, newStatus})
}

</script>

<template>
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-100">
      <div class="flex-1">
        <h3 class="text-lg font-bold text-gray-900 mb-1">
          Order #{{ order.id }}
        </h3>
        <div class="space-y-1">
          <p class="text-sm text-gray-600">
            <span class="font-medium">Customer:</span>
            {{ order.user?.name || 'N/A' }}
          </p>
          <p class="text-sm text-gray-600">
            <span class="font-medium">Email:</span>
            {{ order.user?.email || 'N/A' }}
          </p>
          <p class="text-sm text-gray-500">
            {{ formatDate(order.created_at) }}
          </p>
        </div>
      </div>
      <div class="text-right">
        <p class="text-2xl font-bold text-gray-900 mb-2">
          ${{ parseFloat(order.total_price).toFixed(2) }}
        </p>
        <order-status-badge :status="order.status" />
        <p v-if="order.payment_method" class="text-xs text-gray-500 mt-2">
          Payment: {{ order.payment_method }}
        </p>
      </div>
    </div>

    <div class="mb-4">
      <order-item-list :items="order.order_items || []" />
    </div>

    <div class="pt-4 border-t border-gray-100">
      <order-status-actions
        :order-id="order.id"
        :current-status="order.status"
        :loading="isUpdating"
        @update-status="handleStatusUpdate"
      />
    </div>

  </div>
</template>

<style scoped>

</style>
