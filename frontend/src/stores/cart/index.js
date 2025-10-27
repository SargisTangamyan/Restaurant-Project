import { defineStore } from 'pinia';
import { sender } from '@/api/Sender.js';
import { useAuthStore } from "@/stores/index.js";
import {CART, CART_COUNT} from "@/constants/urls.js";

export const useCartStore = defineStore('cart', {
  state: () => ({
    cart: [],
    chosenIds: new Set(),
    total: 0,
    count: 0,
    loaded: false,
    isLoading: false,
  }),

  getters: {
    getCart: (state) => state.cart,
    getCount: (state) => +state.count,
    getTotal: (state) => +state.total,
    getIsLoaded: (state) => state.loaded,
    getChosenIds: (state) => Array.from(state.chosenIds),
    isAuthenticated() {
      const authStore = useAuthStore();
      return authStore.isAuthenticated;
    }
  },

  actions: {
    _checkAuth() {
      if (!this.isAuthenticated) {
        return {
          success: false,
          errors: ['User not authenticated.'],
          requiresAuth: true,
        };
      }
    },

    async getOrFetchCartCount() {
      if (this.getCount)
      {
        return this.getCount;
      } else {
        const response = await this.fetchCount();
        return response.success ? response.count : 0;
      }
    },

    async fetchCount() {
      const authCheck = this._checkAuth()
      if (authCheck) return authCheck

      const response = await sender.sendRequest('GET', CART_COUNT);
      if (response.success) {
        this.count = response.data.count;
        return {success: true, count: this.count};
      } else {
        return {success: false, errors: response.errors};
      }
    },

    async fetchCart() {
      const authCheck = this._checkAuth();
      if (authCheck) return authCheck;

      const response = await sender.sendRequest('GET', CART);
      if (response.success) {
        const cartItems = response.data.cart || [];
        this.cart = [];
        cartItems.forEach(cart => {
          this.chosenIds.add(+cart.dish.id)
          cart.dish.quantity = cart.quantity;
          this.cart.push(cart.dish);
        });
        this.total = response.data.total || 0;
        this.count = cartItems.length;
        this.loaded = true;

        return { success: true, cartItems: this.cart };
      } else {
        return { success: false, errors: response.errors };
      }
    },

    async addToCart(id, quantity = 1) {
      const authCheck = this._checkAuth()
      if (authCheck) return authCheck

      this.isLoading = true;
      const response = await sender.sendRequest('POST', `${CART}/${id}`, {quantity});
      if (response.success) {
        this.chosenIds.add(+id);

        const addedItem = response.data?.cart;
        if (addedItem && addedItem.dish) {
          this.count += 1;
          this.total += (addedItem.dish.price * quantity);
        }

        this.isLoading = false;
        return { success: true, message: 'Item added successfully.' };
      } else {
        this.isLoading = false;
        return { success: false, errors: response.errors };
      }
    },

    async updateQuantity(id, quantity) {
      const authCheck = this._checkAuth()
      if (authCheck) return authCheck

      this.isLoading = true;
      try {
        const response = await sender.sendRequest('PUT', `${CART}/${id}`, { quantity });
        if (response.success) {
          // Update local cart item quantity
          const item = this.cart.find(dish => dish.id === +id);
          if (item) {
            item.quantity = quantity;
          }

          // Recalculate total
          this.total = response.data.total;

          this.isLoading = false;
          return { success: true, message: 'Quantity updated successfully.' };
        } else {
          this.isLoading = false;
          return { success: false, errors: response.errors };
        }
      } catch (error) {
        this.isLoading = false;
        return { success: false, errors: error };
      }
    },

    async removeFromCart(id) {
      const authCheck = this._checkAuth()
      if (authCheck) return authCheck

      this.isLoading = true;
      const response = await sender.sendRequest('DELETE', `${CART}/${id}`);
      if (response.success) {
        this.cart = this.cart.filter((dish) => dish.id !== +id);
        this.chosenIds.delete(+id);
        this.count = Math.max(this.count - 1, 0);

        // Recalculate total from remaining items
        this.total = this.cart.reduce((sum, dish) => sum + (dish.price * dish.quantity), 0);

        this.isLoading = false;
        return { success: true, message: 'Item removed successfully.' };
      } else {
        this.isLoading = false;
        return { success: false, errors: response.errors };
      }
    },
  },
});
