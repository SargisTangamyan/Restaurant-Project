import { defineStore } from 'pinia';
import { sender } from '@/api/Sender.js';
import {ADMIN_ORDERS, ORDER_CANCEL, ORDER_STATUS_UPDATE, ORDERS} from "@/constants/urls.js";

export const useOrderStore = defineStore('order', {
  state: () => ({
    orders: [],
    pagination: {
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0,
      from: null,
      to: null,
    },
    loading: false,
    error: null,
    selectedOrder: null,

    // For Admin
    adminOrders: [],
    adminPagination: {
      current_page: 1,
      last_page: 1,
      per_page: 10,
      total: 0,
      from: null,
      to: null,
    },
    adminLoading: false,
    adminError: null,

    updatingOrders: {},
  }),

  getters: {
    getOrders(state) {
      return state.orders;
    },
    getPagination(state) {
      return state.pagination;
    },
    isLoading(state) {
      return state.loading;
    },
    getSelectedOrder(state) {
      return state.selectedOrder;
    },

    // For Admin
    getAdminOrders(state) {
      return state.adminOrders;
    },
    getAdminPagination(state) {
      return state.adminPagination;
    },
    getAdminLoading(state) {
      return state.adminLoading;
    },
    getAdminError(state) {
      return state.adminError;
    },
    isOrderUpdating: (state) => (orderId) => {
      return state.updatingOrders[orderId] || false;
    }
  },

  actions: {
    async fetchOrders(page = 1, perPage = 10) {
      this.loading = true;
      this.error = null;

      const result = await sender.sendRequest('GET', `${ORDERS}?page=${page}&per_page=${perPage}`);
      this.loading = false;

      if (result.success) {
        this.orders = result.data.orders.data;
        this.pagination = result.data.orders.pagination;
      } else {
        this.error = result.errors;
      }

      return result;
    },

    async fetchOrderDetails(orderId) {
      this.loading = true;
      this.error = null;

      const result = await sender.sendRequest('GET', `${ORDERS}/${orderId}`);

      this.loading = false;

      if (result.success) {
        this.selectedOrder = result.data.order;
      } else {
        this.error = result.errors;
      }

      return result;
    },

    async cancelOrder(orderId) {
      this.updatingOrders[orderId] = true;
      this.error = null;

      const result = await sender.sendRequest('PATCH', ORDER_CANCEL(orderId));

      this.updatingOrders[orderId] = false;

      if (result.success) {
        // Update order status in the list
        const orderIndex = this.orders.findIndex(o => o.id === orderId);
        if (orderIndex !== -1) {
          this.orders[orderIndex].status = 'cancelled';
        }

        // Update selected order if it's the one being cancelled
        if (this.selectedOrder && this.selectedOrder.id === orderId) {
          this.selectedOrder.status = 'cancelled';
        }
      } else {
        this.error = result.errors;
      }

      return result;
    },

    clearOrders() {
      this.orders = [];
      this.pagination = {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
        from: null,
        to: null,
      };
      this.selectedOrder = null;
    },

    // Admin Actions
    async fetchAdminOrders(page = 1, perPage = 10, statusFilter = null) {
      this.adminLoading = true;
      this.adminError = null;

      let url = `${ADMIN_ORDERS}?page=${page}&per_page=${perPage}`;
      if (statusFilter && statusFilter !== 'all') {
        url += `&status=${statusFilter}`;
      }

      const result = await sender.sendRequest('GET', url);
      this.adminLoading = false;

      if (result.success) {
        this.adminOrders = result.data.orders.data;
        this.adminPagination = result.data.orders.pagination;
      } else {
        this.adminError = result.errors;
      }

      return result;
    },

    async updateOrderStatus(orderId, newStatus) {
      this.updatingOrders[orderId] = true;
      this.adminError = null;

      const result = await sender.sendRequest('PATCH', ORDER_STATUS_UPDATE(orderId), {status: newStatus});

      this.updatingOrders[orderId] = false;

      if (result.success) {
        // Update in admin orders list
        const adminOrderIndex = this.adminOrders.findIndex(order => order.id === orderId);
        if (adminOrderIndex !== -1) {
          this.adminOrders[adminOrderIndex].status = newStatus;
          if (result.data.order) {
            this.adminOrders[adminOrderIndex] = result.data.order;
          }
        }

        // Update in user orders list
        const userOrderIndex = this.orders.findIndex(order => order.id === orderId);
        if (userOrderIndex !== -1) {
          this.orders[userOrderIndex].status = newStatus;
          if (result.data.order) {
            this.orders[userOrderIndex] = result.data.order;
          }
        }

        // Update selected order
        if (this.selectedOrder && this.selectedOrder.id === orderId) {
          this.selectedOrder.status = newStatus;
          if (result.data.order) {
            this.selectedOrder = result.data.order;
          }
        }
      } else {
        this.adminError = result.errors;
      }

      return result;
    },

    clearAdminOrders() {
      this.adminOrders = [];
      this.adminPagination = {
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
        from: null,
        to: null,
      };
      this.adminError = null;
    },

    clearAllOrders() {
      this.clearOrders();
      this.clearAdminOrders();
      this.updatingOrders = {};
    },

    removeOrderFromList(orderId) {
      this.orders = this.orders.filter(order => order.id !== orderId);
      this.adminOrders = this.adminOrders.filter(order => order.id !== orderId);
    }
  }
});
