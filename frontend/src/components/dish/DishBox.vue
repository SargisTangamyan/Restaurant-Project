
<script setup>
// COMPONENTS
import RatingStars from "@/components/ui/RatingStars.vue";
import AddToCartButton from "@/components/cart/AddToCartButton.vue";

// URLS
import { STORAGE } from '@/constants/urls.js'

// PROPS
defineProps({
  dish: {
    required: true,
    type: Object,
  }
})
</script>

<template>
  <div
    class="group relative flex flex-col bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300"
  >
    <!-- Product Image -->
    <div class="relative w-full aspect-square overflow-hidden">
      <router-link :to="{ name: 'dish', params: { id: dish.id } }">
        <img
          :src="`${STORAGE}/${dish.thumbnail}`"
          alt="Product"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
        />
      </router-link>

      <!-- Product Options -->
      <ul
        class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
      >
        <li>
          <button
            class="w-9 h-9 flex items-center justify-center rounded-full bg-white shadow hover:bg-gray-100 hover:text-cgreen"
            title="View"
          >
            <font-awesome-icon class="block" :icon="['fas', 'eye']" />
          </button>
        </li>
        <li>
          <button
            class="w-9 h-9 flex items-center justify-center rounded-full bg-white shadow hover:bg-gray-100 hover:text-cgreen"
            title="Wishlist"
          >
            <font-awesome-icon class="block" :icon="['fas', 'heart']" />
          </button>
        </li>
      </ul>
    </div>

    <!-- Product Info -->
    <div class="flex flex-col flex-grow p-4">
      <span class="text-sm text-gray-400">{{ dish.category.name }}</span>

      <router-link :to="{ name: 'dish', params: { id: dish.id } }" class="mt-1">
        <h3 class="font-semibold text-gray-800 text-lg hover:text-emerald-600 transition-colors">
          {{ dish.name }}
        </h3>
      </router-link>

      <p class="text-sm text-gray-500 mt-2 mb-3 line-clamp-3">
        {{ dish.description }}
      </p>

      <!-- Rating -->
      <div class="flex items-center gap-2 mt-auto">
        <rating-stars :stars="4.5" />
        <span class="text-sm text-gray-500">(4.5)</span>
      </div>

      <!-- Price -->
      <div class="mt-2">
        <h6 class="text-xs text-gray-400">250 ml</h6>
        <h5 class="text-lg font-semibold">
          <span class="text-emerald-600">${{ dish.price }}</span>
        </h5>
      </div>

      <!-- Add / Remove Cart -->
      <div class="mt-4">
        <add-to-cart-button :dish-id="dish.id" />
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
