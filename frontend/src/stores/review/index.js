import { defineStore } from 'pinia'
import { sender } from '@/api/Sender.js'
import { DISH_REVIEWS, DISH_REVIEW } from '@/constants/urls.js'

export const useReviewStore = defineStore('review', {
  state: () => ({
    reviews: [],
    pagination: null,
    isLoading: false,
  }),

  getters: {
    getReviews: state => state.reviews,
    getPagination: state => state.pagination,
  },

  actions: {
    async fetchReviews(dishId, page = 1) {
      this.isLoading = true;
      const response = await sender.sendRequest('GET', `${DISH_REVIEWS(dishId)}?page=${page}`);
      this.isLoading = false;

      if (response.success) {
        this.reviews = response.data.reviews.data ?? response.data.reviews;
        this.pagination = response.data.meta;
        return { success: true };
      }
      return { success: false };
    },

    async addReview(dishId, data) {
      const response = await sender.sendRequest('POST', DISH_REVIEWS(dishId), data);
      if (response.success) {
        this.reviews.unshift(response.data.review);
        return { success: true, review: response.data.review };
      }
      return { success: false, message: response.errors?.[0] ?? 'Failed to submit review' };
    },

    async updateReview(dishId, reviewId, data) {
      const response = await sender.sendRequest('PUT', DISH_REVIEW(dishId, reviewId), data);
      if (response.success) {
        const idx = this.reviews.findIndex(r => r.id === reviewId);
        if (idx !== -1) this.reviews[idx] = response.data.review;
        return { success: true };
      }
      return { success: false };
    },

    async deleteReview(dishId, reviewId) {
      const response = await sender.sendRequest('DELETE', DISH_REVIEW(dishId, reviewId));
      if (response.success) {
        this.reviews = this.reviews.filter(r => r.id !== reviewId);
        return { success: true };
      }
      return { success: false };
    },

    clearReviews() {
      this.reviews = [];
      this.pagination = null;
    },
  }
});