<script setup>
// VUE
import {computed, onMounted, watch} from 'vue';

// ROUTE IMPORT
import {useRouter, useRoute} from 'vue-router';

// STORE IMPORT
import {useOrderStore} from '@/stores/index.js';

// COMPONENTS
import ProfileBox from "@/components/profile/ProfileBox.vue";
import OrderStatusBadge from "@/components/order/OrderStatusBadge.vue";
import ThePagination from "@/components/ui/ThePagination.vue";

// COMPOSABLES
import {useFormatters} from '@/composables/useFormatter.js'
import {useQueryFunctionality} from '@/composables/useQueryFunctionality';

// ROUTES
const router = useRouter();
const route = useRoute();

// STORES
const ordersStore = useOrderStore();

// COMPOSABLES
const {writeQuery} = useQueryFunctionality();
const {formatDate} = useFormatters();

const orders = computed(() => ordersStore.getOrders);
const pagination = computed(() => ordersStore.getPagination);
const isLoading = computed(() => ordersStore.isLoading);

const loadOrders = async (page = 1) => {
  await ordersStore.fetchOrders(page);
};

const goToPage = (page) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    writeQuery('page', page);
  }
};

const viewOrderDetails = (orderId) => {
  router.push({name: 'order_detail', params: {id: orderId}});
};

onMounted(() => {
  const page = parseInt(route.query.page) || 1;
  loadOrders(page);
});

watch(
  () => route.query.page,
  (newPage) => {
    if (newPage) {
      loadOrders(parseInt(newPage));
    }
  }
);
</script>

<template>
  <profile-box heading="My orders">
    <div class="max-w-5xl my-0 mx-auto p-5">
      <the-loader v-if="isLoading && orders.length === 0"/>

      <div v-else-if="orders.length === 0 && !isLoading" class="empty-orders">
        <p class="text-gray-500 text-center py-12">You don't have any orders yet.</p>
      </div>

      <div v-else class="orders-list">
        <div
          v-for="order in orders"
          :key="order.id"
          class="bg-white hover:border-[#0DA487] mb-4 p-4 border rounded-lg hover:shadow-md transition-shadow"
        >
          <div class="order-header flex justify-between items-start mb-3">
            <div>
              <p class="font-semibold text-lg">Order #{{ order.id }}</p>
              <p class="text-sm text-gray-600">
                {{ formatDate(order.created_at) }}
              </p>
            </div>
            <div class="text-right">
              <p class="font-bold text-lg">${{ order.total_price }}</p>
              <order-status-badge :status="order.status" />
            </div>
          </div>

          <div class="order-items mb-3">
            <p class="text-sm text-gray-700 mb-2">
              {{ order.order_items.length }} item(s)
            </p>
            <div class="flex flex-wrap gap-2">
              <div
                v-for="item in order.order_items.slice(0, 3)"
                :key="item.id"
                class="text-xs bg-gray-100 px-2 py-1 rounded"
              >
                {{ item.product?.name || 'Product' }} x{{ item.quantity }}
              </div>
              <div
                v-if="order.order_items.length > 3"
                class="text-xs bg-gray-100 px-2 py-1 rounded"
              >
                +{{ order.order_items.length - 3 }} more
              </div>
            </div>
          </div>

          <div class="order-actions flex justify-end gap-2">
            <button
              @click="viewOrderDetails(order.id)"
              class="button-cgreen mt-0 transition-colors"
            >
              View Details
            </button>
          </div>
        </div>

        <!-- Pagination -->
        <the-pagination :total-pages="pagination.last_page" :current-page="pagination.current_page"
                        @move-to="goToPage"/>

      </div>
    </div>
  </profile-box>
</template>

<style scoped>
</style>
