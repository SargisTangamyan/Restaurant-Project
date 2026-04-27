<script setup>
import ReviewItem from "@/components/detail/review/ReviewItem.vue";

const props = defineProps({
  reviews: {
    type: Array,
    required: true,
  },
  currentUserId: {
    type: Number,
    default: null,
  },
  dishId: {
    type: Number,
    required: true,
  },
});

const emit = defineEmits(['updated', 'deleted']);
</script>

<template>
  <div v-if="reviews.length > 0" class="space-y-6">
    <review-item
      v-for="review in reviews"
      :key="review.id"
      :review="review"
      :current-user-id="currentUserId"
      :dish-id="dishId"
      @updated="emit('updated', $event)"
      @deleted="emit('deleted', $event)"
    />
  </div>
  <p v-else class="text-gray-400 text-sm italic">No reviews yet. Be the first to review!</p>
</template>