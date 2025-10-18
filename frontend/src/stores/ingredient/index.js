import {defineStore} from 'pinia'
import {sender} from '@/api/Sender.js'
import {CATEGORY_SEARCH, INGREDIENT_ALL, INGREDIENT_SEARCH} from '@/constants/urls.js'

export const useIngredientStore = defineStore('ingredient', {
  state: () => ({
    ingredients: null,
    pagination: {},
    loaded: false,
  }),

  getters: {
    getIngredients(state) {
      return state.ingredients || [];
    },

    getPagination(state) {
      return state.pagination;
    }

  },

  actions: {
    async fetchIngredients(currentPage = 1, perPage = 10) {
      const res = await sender.sendRequest('GET', `${INGREDIENT_ALL}?page=${currentPage}&per_page=${perPage}`);

      if (res.success) {
        // Reset state
        this.ingredients = res.data.data;

        // Getting pagination
        this.pagination = res.data.meta

        this.loaded = true

        return { success: true }
      } else {
        return { success: false, message: 'Failed to fetch ingredients' }
      }
    },

    async addIngredient(payload) {
      const res = await sender.sendRequest('POST', INGREDIENT_ALL, payload);
      console.log(res);
      if (res.success) {
        await this.fetchIngredients(1, 10);
        return { success: true, message: 'Ingredient added successfully.' };
      } else {
        return { success: false, errors: res.errors }
      }
    },

    async searchIngredients(pattern)
    {
      const res = await sender.sendRequest('GET', `${INGREDIENT_SEARCH}?query=${pattern}`);
      if (res.success) {
        return { success: true, foundIngredients: res.data.ingredients}
      }
      return { success: false, message: 'Failed to fetch categories' }
    },

    async deleteIngredient(id) {
      const res = await sender.sendRequest('DELETE', `${INGREDIENT_ALL}/${id}`);
      if (res.success) {
        await this.fetchIngredients(1, 10);
        return { success: true, message: 'Category deleted successfully.' };
      } else {
        return { success: false, errors: 'Failed to delete category' }
      }
    }
  },
})
