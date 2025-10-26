<script setup>

// VUE
import {ref, onMounted, watch, computed} from 'vue';

// STORE
import {useOrderStore} from "@/stores/index.js";

// COMPONENTS
import TheLoader from "@/components/ui/TheLoader.vue";
import ThePagination from "@/components/ui/ThePagination.vue";

// ORDER COMPONENTS
import OrderStatusFilter from "@/components/order/OrderStatusFilter.vue";
import AdminOrderCard from "@/components/order/AdminOrderCard.vue";
import OrdersEmptyState from "@/components/order/OrdersEmptyState.vue";
import ProfileBox from "@/components/profile/ProfileBox.vue";

// USING STORE
const orderStore = useOrderStore();
const selectedStatus = ref('all');

// COMPUTED
const orders = computed(() => orderStore.getAdminOrders);
const pagination = computed(() => orderStore.getAdminPagination);
const loading = computed(() => orderStore.getAdminLoading);
const error = computed(() => orderStore.getAdminError);

// METHODS
const fetchOrders = async (page = 1) => {
  await orderStore.fetchAdminOrders(page, 10, selectedStatus.value)
}

const updateOrderStatus = async ({orderId, newStatus}) => {
  const result = await orderStore.updateOrderStatus(orderId, newStatus);

  if (!result.success) {
    alert(result.errors || 'Failed to update order status');
  }
}

const handlePageChange = (page) => {
  fetchOrders(page);
}

const isOrderUpdating = (orderId) => {
  return orderStore.isOrderUpdating(orderId);
}

// WATCH
watch(selectedStatus, () => {
  fetchOrders(1);
})

// MOUNT
onMounted(() => {
  fetchOrders();
});

</script>

<template>
  <div>
    <profile-box heading="Manage Orders" class="min-h-screen">
      <div class="max-w-7xl mx-auto p-6">
        <!--Filters-->
        <div class="mb-6">
          <order-status-filter v-model="selectedStatus"/>
        </div>

        <!-- Error State -->
        <div v-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
          <p class="text-red-800">{{ error }}</p>
        </div>

        <!-- Loading State -->
        <the-loader v-if="loading && orders.length  === 0"/>

        <!-- orders List -->
        <template v-else>
          <div v-if="orders.length > 0" class="space-y-4">
            <admin-order-card
              v-for="order in orders"
              :key="order.id"
              :order="order"
              :is-updating="isOrderUpdating(order.id)"
              @status-updated="updateOrderStatus"
            />
          </div>

          <!-- Empty State -->
          <orders-empty-state v-else/>
        </template>

        <!-- Pagination -->
        <div v-if="pagination && pagination.last_page > 1" class="mt-8">
          <the-pagination :total-pages="pagination.last_page"
                          :current-page="pagination.current_page"
                          @move-to="handlePageChange"
          />
        </div>

      </div>
    </profile-box>
  </div>
</template>

<style scoped>

</style>
