<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import AverageRating from "@/components/detail/review/AverageRating.vue";
import ReviewList from "@/components/detail/review/ReviewList.vue";
import { useReviewStore, useAuthStore } from "@/stores/index.js";
import {faCircle, faCircleCheck} from "@fortawesome/free-solid-svg-icons";

const props = defineProps({
  dish: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['rating-updated']);

const reviewStore = useReviewStore();
const authStore = useAuthStore();

const reviews = computed(() => reviewStore.getReviews);
const pagination = computed(() => reviewStore.getPagination);
const isLoading = computed(() => reviewStore.isLoading);

const selectedRating = ref(0);
const hoveredRating = ref(0);
const comment = ref('');
const submitError = ref('');
const submitSuccess = ref(false);
const isSubmitting = ref(false);

const currentUserId = computed(() => authStore.user?.id ?? null);

const getStarFill = (i) => {
  const rating = hoveredRating.value || selectedRating.value;
  if (rating >= i) return '100%';
  if (rating >= i - 0.5) return '50%';
  return '0%';
};

const alreadyReviewed = computed(() =>
  authStore.isAuthenticated && reviews.value.some(r => r.user_id === currentUserId.value)
);

const fetchReviews = async () => {
  await reviewStore.fetchReviews(props.dish.id);
};

const submitReview = async () => {
  if (selectedRating.value === 0) {
    submitError.value = 'Please select a rating.';
    return;
  }

  isSubmitting.value = true;
  submitError.value = '';

  const result = await reviewStore.addReview(props.dish.id, {
    rating: selectedRating.value,
    comment: comment.value.trim() || null,
  });

  isSubmitting.value = false;

  if (result.success) {
    submitSuccess.value = true;
    selectedRating.value = 0;
    comment.value = '';
    emit('rating-updated');
    setTimeout(() => { submitSuccess.value = false; }, 3000);
  } else {
    submitError.value = result.message ?? 'Failed to submit review.';
  }
};

const handleUpdated = async ({ reviewId, rating, comment: updatedComment }) => {
  await reviewStore.updateReview(props.dish.id, reviewId, { rating, comment: updatedComment });
  emit('rating-updated');
};

const handleDeleted = async (reviewId) => {
  await reviewStore.deleteReview(props.dish.id, reviewId);
  emit('rating-updated');
};

const loadPage = async (page) => {
  await reviewStore.fetchReviews(props.dish.id, page);
};

onMounted(fetchReviews);

watch(() => props.dish.id, () => {
  reviewStore.clearReviews();
  fetchReviews();
});
</script>

<template>
  <div class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 col-span-5">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">Customer Reviews</h3>

    <!-- Average Rating Summary -->
    <average-rating
      :average-rating="Number(dish.average_rating) || 0"
      :reviews-count="dish.reviews_count || 0"
    />

    <!-- Loading -->
    <div v-if="isLoading" class="text-sm text-gray-400 py-4">Loading reviews...</div>

    <!-- Review List -->
    <review-list
      v-else
      :reviews="reviews"
      :current-user-id="currentUserId"
      :dish-id="dish.id"
      @updated="handleUpdated"
      @deleted="handleDeleted"
    />

    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="flex justify-center gap-2 mt-6">
      <button
        v-for="page in pagination.last_page"
        :key="page"
        @click="loadPage(page)"
        :class="[
          'px-3 py-1 rounded-lg text-sm font-medium transition',
          page === pagination.current_page
            ? 'bg-cgreen text-white'
            : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
        ]"
      >
        {{ page }}
      </button>
    </div>

    <!-- Add Review Form -->
    <div class="mt-8">
      <h4 class="text-lg font-semibold mb-3 text-gray-800">Add Your Review</h4>

      <!-- Not logged in -->
      <p v-if="!authStore.isAuthenticated" class="text-sm text-gray-500 italic">
        Please <router-link to="/account/login" class="text-cgreen hover:underline font-medium">log in</router-link> to leave a review.
      </p>

      <!-- Already reviewed -->
      <p v-else-if="alreadyReviewed" class="text-sm text-emerald-600 font-medium">
        <font-awesome-icon :icon="faCircleCheck" class="mr-1" />
        You have already reviewed this dish.
      </p>

      <!-- Review form -->
      <form v-else @submit.prevent="submitReview" class="space-y-4">
        <!-- Star selector -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Your Rating</label>
          <div class="flex items-center gap-1" @mouseleave="hoveredRating = 0">
            <div
              v-for="i in 5"
              :key="i"
              class="relative text-2xl w-7 h-7 cursor-pointer select-none"
            >
              <!-- Empty star background -->
              <font-awesome-icon :icon="['fas', 'star']" class="text-gray-300 w-7 h-7" />
              <!-- Filled overlay (full or half) -->
              <div class="absolute inset-0 overflow-hidden" :style="{ width: getStarFill(i) }">
                <font-awesome-icon :icon="['fas', 'star']" class="text-yellow-400 absolute left-0 top-0 w-7 h-7" />
              </div>
              <!-- Left-half hitbox → half star -->
              <div
                class="absolute inset-y-0 left-0 w-1/2"
                @mouseenter="hoveredRating = i - 0.5"
                @click="selectedRating = i - 0.5"
              />
              <!-- Right-half hitbox → full star -->
              <div
                class="absolute inset-y-0 right-0 w-1/2"
                @mouseenter="hoveredRating = i"
                @click="selectedRating = i"
              />
            </div>
            <span v-if="selectedRating > 0" class="ml-2 text-sm text-gray-500">{{ selectedRating }}/5</span>
          </div>
        </div>

        <!-- Comment -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Your Review <span class="text-gray-400 font-normal">(optional)</span></label>
          <textarea
            v-model="comment"
            rows="4"
            placeholder="Write your review..."
            maxlength="1000"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-cgreen focus:outline-none text-sm"
          />
        </div>

        <!-- Error / Success messages -->
        <p v-if="submitError" class="text-sm text-red-500">{{ submitError }}</p>
        <p v-if="submitSuccess" class="text-sm text-emerald-600 font-medium">
          <font-awesome-icon :icon="['fas', 'circle-check']" class="mr-1" />
          Review submitted successfully!
        </p>

        <!-- Submit -->
        <button
          type="submit"
          :disabled="isSubmitting"
          class="bg-cgreen hover:bg-emerald-700 disabled:opacity-60 text-white font-medium rounded-lg px-6 py-3 transition"
        >
          {{ isSubmitting ? 'Submitting...' : 'Submit Review' }}
        </button>
      </form>
    </div>
  </div>
</template>
