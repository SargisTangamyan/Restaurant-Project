
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

// STATUS CONFIG
const STATUSES = [
  { label: 'Safe',   class: 'bg-green-500', match: [70, 95] },
  { label: 'Modify', class: 'bg-[#97a899]', match: [40, 69] },
  { label: 'Avoid',  class: 'bg-red-500',   match: [10, 39] }
]

// HELPERS
const randomInt = (min, max) =>
  Math.floor(Math.random() * (max - min + 1)) + min

// RANDOM STATUS (once)
const status = STATUSES[Math.floor(Math.random() * STATUSES.length)]

// RANDOM MATCH BASED ON STATUS
const match = randomInt(status.match[0], status.match[1])

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

      <div class="absolute top-2 left-2 w-fit">
        <div class="text-white w-fit px-3 py-1 rounded-md"
          :class="status.class"
        >
          {{status.label}}
        </div>
      </div>

      <!-- Product Options -->
      <ul
        class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
      >
        <li>
          <router-link :to="{name: 'dish', params: {id: dish.id}}"
            class="w-9 h-9 flex items-center justify-center rounded-full bg-white shadow hover:bg-gray-100 hover:text-cgreen"
            title="View"
          >
            <font-awesome-icon class="block" :icon="['fas', 'eye']" />
          </router-link>
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
      <div class="mb-2 bg-cgreen text-white w-fit text-xs px-3 py-1 rounded-md">
        Match {{match}}%
      </div>

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
        <h6 class="text-xs text-gray-400">Saffron & Smoke</h6>
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
