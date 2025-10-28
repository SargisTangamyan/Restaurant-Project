<script setup>
import { defineProps } from 'vue'
import ImageDisplay from "@/components/ui/image/ImageDisplay.vue";
import RatingStars from "@/components/ui/RatingStars.vue";
import DishImage from '@/assets/images/dish/1.jpg'

defineProps({
  dish: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <router-link :to="{name: 'dish', params: {id: dish.id}}" >
    <div  class="flex gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer border border-transparent hover:border-gray-200">
      <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden">
          <image-display :alt="dish.name" :image-path="dish.thumbnail" :fallback-image="DishImage" />
      </div>
      <div class="flex flex-col justify-between">
        <h4 class="font-medium text-gray-700 hover:text-cgreen transition-colors">{{ dish.name }}</h4>

        <div class="flex items-center gap-2 mb-2">
          <div class="flex items-center">
          <rating-stars class="text-xs" :stars="4" />
          </div>
          <span class="text-xs text-gray-500">(45)</span>
        </div>

        <div class="flex items-center justify-between">
          <span class="text-cgreen font-bold text-lg">
            ${{ dish.price }}
          </span>

          <span v-if="dish.category" class="text-xs text-gray-500 truncate">
            {{ dish.category.name }}
          </span>
        </div>
      </div>
    </div>
  </router-link>
</template>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.trending-item {
  display: block;
  text-decoration: none;
  color: inherit;
}
</style>
