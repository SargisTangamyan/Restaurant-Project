import {defineStore} from 'pinia'
import {sender} from '@/api/Sender.js'
import {DISHES, DISHES_RELATED, DISHES_SEARCH} from "@/constants/urls.js";

export const useDishStore = defineStore('dish', {
  state: () => ({
    dishes: null,
    pagination: null,
    relatedDishes: [],
  }),

  getters: {
    getDishes(state) {
      return state.dishes
    },
    getPagination: state => state.pagination,
    getRelatedDishes: state => state.relatedDishes,
  },

  actions: {
    async fetchDishes(filters = {}) {
      let query = '';
      if (Object.keys(filters).length > 0)
      {
        query += '?';
        for (const [key, value] of Object.entries(filters)) {
          query += `${key}=${value}&`;
        }
        query = query.slice(0, -1);
      }

      const response = await sender.sendRequest('GET', `${DISHES}${query}`);
      if (response.success) {
        this.dishes = response.data.data;
        this.pagination = response.data.meta;
        return {success: true, data: response.data.data}
      }
      return false;
    },

    async searchDishes(search = '') {
      if (search === '')
      {
        return {success: false, message: 'Name is empty'}
      }

      const response = await sender.sendRequest('GET', `${DISHES_SEARCH}?search=${search}`);
      if (response.success)
      {
        return {success: true, names: response.data.names}
      } else {
        return {success: false, message: 'No dishes found'};
      }
    },

    async fetchDishById(id) {
      const response = await sender.sendRequest('GET', `${DISHES}/${id}`);
      if (response.success) {
        this.dishes = response.data.data
        return {success: true, data: response.data.data}
      }
      return {success: false, message: 'No dish found'};
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
      if (response.success) {
        return {success: true, message: 'Dish Created successfully.'};
      } else {
        return {success: false, errors: response.errors};
      }
    },

    async fetchRelatedDishes(dishId, limit = 5) {
      try {
        const response = await sender.sendRequest('GET', DISHES_RELATED(dishId));

        if (response.success) {
          this.relatedDishes = response.data.dishes || [];
          return {
            success: true,
            dishes: this.relatedDishes,
            count: response.data.count || 0,
          }
        }
        return {success: false, errors: response.errors};
      } catch (error) {
        return {success: false, errors: error.message};
      }
    },

    clearRelatedDishes() {
      this.relatedDishes = [];
    },
  }
})
