import { defineStore } from 'pinia'
import { sender } from '@/api/Sender.js'
import { CATEGORY_ALL, CATEGORY_SEARCH } from '@/constants/urls.js'

const paginatedCategories = function (catList, currentPage, perPage) {
  return catList.slice((currentPage - 1) * perPage, currentPage * perPage)
}

export const useCategoryStore = defineStore('category', {
  state: () => ({
    flatCategories: [],
    treeCategories: [],
    parentCategories: {},
    pagination: {
      current_page: 1,
      per_page: 10,
      total: 0,
      last_page: 1
    },
    loaded: false,
    loading: false,
    error: null,
  }),

  getters: {
    getCategories(state) {
      return state.flatCategories || [];
    },

    getTreeCategories(state) {
      return state.treeCategories || [];
    },

    getParentCategories(state) {
      return state.parentCategories || [];
    },

    getPagination(state) {
      return state.pagination;
    },

    isLoading(state) {
      return state.loading;
    },

    hasError(state) {
      return state.error !== null;
    }

  },

  actions: {
    async fetchCategories(currentPage = 1, perPage = 10, force = false) {
      this.pagination.current_page = currentPage;
      this.pagination.per_page = perPage;

      if (this.loaded && !force) {
        return {
          success: true,
          categories: this.getPaginatedCategories(currentPage, perPage) };
      }

      this.loading = true;
      this.error = null;

      try {
        const res = await sender.sendRequest('GET', `${CATEGORY_ALL}?tree=true`)

        if (res.success) {
          const categories = res.data.categories;
          // Reset state
          this.flatCategories = []
          this.parentCategories = {};
          this.treeCategories = categories;

          this.flattenCategories(categories);

          const total = this.flatCategories.length;
          this.pagination.total = total;
          this.pagination.last_page = Math.ceil(total / perPage);

          this.loaded = true

          return {
            success: true,
            categories: this.getPaginatedCategories(currentPage, perPage)
          };
        } else {
          this.error = 'Failed to fetch categories';
          return { success: false, message: this.error };
        }
      } catch (error) {
        this.error = error.message || 'Network error';
        return { success: false, message: this.error };
      } finally {
        this.loading = false;
      }
    },

    flattenCategories(categories, parentName = null) {
      categories.forEach(cat => {
        const categoryData = {
          ...cat,
          parent_name: parentName
        };

        this.flatCategories.push(categoryData);
        this.parentCategories[cat.id] = cat.name;

        if (cat.children && cat.children.length > 0) {
          this.flattenCategories(cat.children, cat.name);
        }
      });
    },

    getPaginatedCategories(currentPage, perPage) {
      const start = (currentPage - 1) * perPage;
      const end = currentPage * perPage;
      return this.flatCategories.slice(start, end);
    },

    async getCategoryById(id) {
      this.loading = true;
      this.error = null;

      try {
        const res = await sender.sendRequest('GET', `${CATEGORY_ALL}/${id}`);

        if (res.success) {
          return { success: true, category: res.data.category };
        } else {
          return { success: false, error: res.errors };
        }
      } catch (error) {
        return { success: false, error: error.message };
      } finally {
        this.loading = false;
      }
    },

    async searchCategories(pattern)
    {
      if (!pattern || pattern.trim() === '') {
        return { success: false, message: 'Search query is empty' };
      }

      try {
        const res = await sender.sendRequest('GET', `${CATEGORY_SEARCH}?query=${encodeURIComponent(pattern)}`);

        if (res.success) {
          return { success: true, foundCategories: res.data.categories };
        }

        return { success: false, message: res.message || 'No categories found' };
      } catch (error) {
        return { success: false, message: error.message || 'Search failed' };
      }
    },

    async addCategory(payload) {
      this.loading = true;
      this.error = null;

      try {
        const res = await sender.sendRequest('POST', CATEGORY_ALL, payload);

        if (res.success) {
          // Invalidate cache to force refresh
          this.loaded = false;
          return { success: true, message: 'Category added successfully.', category: res.data.category };
        } else {
          return { success: false, errors: res.errors };
        }
      } catch (error) {
        return { success: false, errors: { general: [error.message] } };
      } finally {
        this.loading = false;
      }
    },

    async updateCategory(id, payload) {
      this.loading = true;
      this.error = null;

      try {
        const res = await sender.sendRequest('PUT', `${CATEGORY_ALL}/${id}`, payload);

        if (res.success) {
          this.loaded = false; // Force refresh
          return { success: true, message: 'Category updated successfully.', category: res.data.category };
        } else {
          return { success: false, errors: res.errors };
        }
      } catch (error) {
        return { success: false, errors: { general: [error.message] } };
      } finally {
        this.loading = false;
      }
    },

    async deleteCategory(id) {
      this.loading = true;
      this.error = null;

      try {
        const res = await sender.sendRequest('DELETE', `${CATEGORY_ALL}/${id}`);
        if (res.success) {
          this.loaded = false; // Force refresh
          return { success: true, message: 'Category deleted successfully.' };
        } else {
          return { success: false, error: res.errors || 'Failed to delete category' };
        }
      } catch (error) {
        return { success: false, error: error.errors || 'Delete failed' };
      } finally {
        this.loading = false;
      }
    },

    clearState() {
      this.flatCategories = [];
      this.treeCategories = [];
      this.parentCategories = {};
      this.pagination = {
        current_page: 1,
        per_page: 10,
        total: 0,
        last_page: 1
      };
      this.loaded = false;
      this.loading = false;
      this.error = null;
    }
  },
})
