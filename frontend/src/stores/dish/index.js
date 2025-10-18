import {defineStore} from 'pinia'
import {sender} from '@/api/Sender.js'
import {DISHES} from "@/constants/urls.js";

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
    },

    async addDish(dish) {
      const formData = new FormData();

      formData.append('name', dish.name);
      formData.append('price', dish.price);
      formData.append('description', dish.description);
      formData.append('category_id', dish.category_id);

      if (dish.image) {
        formData.append('image', dish.image);
      }

      const response = await sender.sendRequest('POST', DISHES, formData,
        {
          'Content-Type': 'multipart/form-data',
        }
      );
      console.log(response);
    }
  }
})
