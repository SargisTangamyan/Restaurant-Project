<script setup>
import RatingStars from "@/components/ui/RatingStars.vue";

const props = defineProps({
  averageRating: {
    type: Number,
    default: 0,
  },
  reviewsCount: {
    type: Number,
    default: 0,
  },
});
</script>

<template>
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
    <div class="flex items-center gap-2">
      <rating-stars :stars="averageRating" />
      <span class="text-lg font-medium text-gray-700 ml-2">
        {{ averageRating > 0 ? averageRating.toFixed(1) : '0.0' }} out of 5
      </span>
    </div>
    <span class="text-sm text-gray-500 mt-2 md:mt-0">
      Based on {{ reviewsCount }} customer {{ reviewsCount === 1 ? 'review' : 'reviews' }}
    </span>
  </div>
</template>