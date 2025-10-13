import { defineStore } from 'pinia'
import { sender } from '@/api/Sender.js'
import { CATEGORY_ALL, CATEGORY_SEARCH } from '@/constants/urls.js'

export const useCategoryStore = defineStore('category', {
  state: () => ({
    flatCategories: null,
    pagination: null,
    loaded: false,
  }),

  getters: {
    getCategories(state) {
      return state.flatCategories || []
    },

    getPagination(state) {
      return state.pagination;
    }
  },

  actions: {
    async fetchCategories(page=1, perPage=10, force = false) {
      if (this.loaded && !force) {
        return { success: true, categories: this.flatCategories }
      }

      const res = await sender.sendRequest('GET', `${CATEGORY_ALL}?page=${page}&per_page=${perPage}`)

      if (res.success) {
        this.flatCategories = res.data.categories
        this.pagination = res.data.pagination
        this.loaded = true
        return { success: true, categories: this.flatCategories }
      } else {
        return { success: false, message: 'Failed to fetch categories' }
      }
    },

    async searchCategories(pattern)
    {
      const res = await sender.sendRequest('GET', `${CATEGORY_SEARCH}?query=${pattern}`);
      if (res.success) {
        return { success: true, foundCategories: res.data.categories}
      }
      return { success: false, message: 'Failed to fetch categories' }
    },

    async addCategory(payload) {
      const res = await sender.sendRequest('POST', CATEGORY_ALL, payload);
      console.log(res);
      if (res.success) {
        return { success: true, message: 'Category added successfully.' };
      } else {
        return { success: false, message: 'Failed to add category' }
      }
    },

    async deleteCategory(id) {
      const res = await sender.sendRequest('DELETE', `${CATEGORY_ALL}/${id}`);
      if (res.success) {
        return { success: true, message: 'Category deleted successfully.' };
      } else {
        return { success: false, message: 'Failed to delete category' }
      }
    }
  },
})
