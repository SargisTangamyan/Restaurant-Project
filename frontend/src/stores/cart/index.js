import { defineStore } from 'pinia';
import { sender } from '@/api/Sender.js';
import {CART, CART_COUNT} from "@/constants/urls.js";

export const useCartStore = defineStore('cart', {
  state: () => ({
    cart: [],
    chosenIds: new Set(),
    total: 0,
    count: 0,
    loaded: false,
  }),

  getters: {
    getCart: (state) => state.cart,
    getCount: (state) => +state.count,
    getTotal: (state) => +state.total,
    getIsLoaded: (state) => state.loaded,
    getChosenIds: (state) => Array.from(state.chosenIds),
  },

  actions: {
    async getOrFetchCart() {
      if (this.getIsLoaded) {
        return this.getCart;
      } else {
        const response = await this.fetchCart();
        if (response.success)
        {
          return response.cartItems;
        } else {
          return []
        }
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
      const response = await sender.sendRequest('GET', CART_COUNT);
      if (response.success) {
        this.count = response.data.count;
        return {success: true, count: this.count};
      } else {
        return {success: false, errors: response.errors};
      }
    },

    async fetchCart() {
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

    async addToCart(id) {
      const response = await sender.sendRequest('POST', `${CART}/${id}`);
      if (response.success) {
        this.chosenIds.add(+id);
        this.count += 1;
        this.total += response.data?.price ?? 0; // assuming response includes price
        return { success: true, message: 'Item added successfully.' };
      } else {
        return { success: false, errors: response.errors };
      }
    },

    async removeFromCart(id) {
      const response = await sender.sendRequest('DELETE', `${CART}/${id}`);
      if (response.success) {
        this.cart = this.cart.filter((dish) => dish.id !== id);
        this.chosenIds.delete(id);
        this.count = Math.max(this.count - 1, 0);
        this.total = response.data?.total ?? this.total;
        return { success: true, message: 'Item removed successfully.' };
      } else {
        return { success: false, errors: response.errors };
      }
    },
  },
});
