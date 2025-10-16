import { defineStore } from 'pinia'
import { sender } from '@/api/Sender.js'
import { CATEGORY_ALL, CATEGORY_SEARCH } from '@/constants/urls.js'

const paginatedCategories = function (catList, currentPage, perPage) {
  return catList.slice((currentPage - 1) * perPage, currentPage * perPage)
}

export const useCategoryStore = defineStore('category', {
  state: () => ({
    flatCategories: null,
    parentCategories: {},
    pagination: {},
    loaded: false,
  }),

  getters: {
    getCategories(state) {
      return state.flatCategories || [];
    },

    getParentCategories(state) {
      return state.parentCategories || [];
    },

    getPagination(state) {
      return state.pagination;
    }

  },

  actions: {
    async fetchCategories(currentPage = 1, perPage = 10, force = false) {
      this.pagination['current_page'] = currentPage;
      this.pagination['per_page'] = perPage;
      if (this.loaded && !force) {
        return { success: true, categories: paginatedCategories(this.flatCategories, currentPage, perPage) };
      }
      console.log('fetching')

      const res = await sender.sendRequest('GET', `${CATEGORY_ALL}?tree=true`)

      if (res.success) {
        const categories = res.data.categories

        // Reset state
        this.flatCategories = []
        this.parentCategories = {}

        // Recursive function to flatten tree
        const flatten = (catList) => {
          catList.forEach(cat => {
            this.flatCategories.push(cat)           // add to flat list
            this.parentCategories[cat.id] = cat.name // store parent id
            if (cat.children && cat.children.length > 0) {
              flatten(cat.children, cat.id)          // recurse
            }
          })
        }

        flatten(categories)

        // Getting pagination
        const total = this.flatCategories.length;
        this.pagination['total'] = total
        this.pagination['last_page'] = Math.ceil(total / perPage);


        this.loaded = true

        return { success: true, categories: paginatedCategories(this.flatCategories, currentPage, perPage) }
      } else {
        return { success: false, message: 'Failed to fetch categories' }
      }
    },

    async getCategoryById(id) {
      const res = await sender.sendRequest('GET', `${CATEGORY_ALL}/${id}`);
      if (res.success) {
        return { success: true, categories: res.data.category };
      } else {
        return { success: false, error: res.errors }
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
      if (res.success) {
        return { success: true, message: 'Category added successfully.' };
      } else {
        return { success: false, errors: res.errors }
      }
    },

    async deleteCategory(id) {
      const res = await sender.sendRequest('DELETE', `${CATEGORY_ALL}/${id}`);
      if (res.success) {
        return { success: true, message: 'Category deleted successfully.' };
      } else {
        return { success: false, errors: 'Failed to delete category' }
      }
    }
  },
})
