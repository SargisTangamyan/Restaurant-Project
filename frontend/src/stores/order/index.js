import { defineStore } from 'pinia';
import { sender } from '@/api/Sender.js';
import {ORDERS} from "@/constants/urls.js";

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
    }
  }
});
