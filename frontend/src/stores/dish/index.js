import {defineStore} from 'pinia'
import {sender} from '@/api/Sender.js'
import { DISHES } from "@/constants/urls.js";

export const useDishStore = defineStore('dish', {
  state: () => ({
    dishes: null,
  }),

  getters: {},

  actions: {
    async fetchDishes() {
        const response = await sender.sendRequest('GET', DISHES)
        if (response.success) {
          this.dishes = response.data.data
          return {success: true, data: response.data.data}
        }
        return false;
    }
  }
})
