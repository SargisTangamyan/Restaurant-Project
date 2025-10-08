<script setup>

// COMPONENTS
import RatingStars from "@/components/ui/RatingStars.vue";

import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
</script>

<template>
  <!-- from here -->
  <div
    class="group relative flex flex-col bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <!-- Product Image -->
    <div class="relative w-full aspect-square overflow-hidden">
      <a href="#">
        <img
          src="../../assets/images/dish/1.jpg"
          alt="Product"
          class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
        />
      </a>

      <!-- Product Options (hover icons) -->
      <ul
        class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <li>
          <button
            class="w-9 h-9 flex items-center justify-center rounded-full bg-white shadow hover:bg-gray-100 hover:text-cgreen"
            title="View"
          >
            <font-awesome-icon class="block" :icon="['fas', 'eye']"/>
          </button>
        </li>
        <li>
          <button
            class="w-9 h-9 flex items-center justify-center rounded-full bg-white shadow hover:bg-gray-100 hover:text-cgreen"
            title="Wishlist"
          >
            <font-awesome-icon class="block" :icon="['fas', 'heart']"/>
          </button>
        </li>
      </ul>
    </div>

    <!-- Product Info -->
    <div class="flex flex-col flex-grow p-4">
      <span class="text-sm text-gray-400">Vegetable</span>

      <a href="product-left-thumbnail.html" class="mt-1">
        <h3 class="font-semibold text-gray-800 text-lg hover:text-emerald-600 transition-colors">
          Fresh Bread and Pastry Flour 200 g
        </h3>
      </a>

      <p class="text-sm text-gray-500 mt-2 mb-3 line-clamp-3">
        Cheesy feet cheesy grin brie. Mascarpone cheese and wine hard cheese the big cheese everyone
        loves smelly cheese macaroni cheese croque monsieur.
      </p>

      <!-- Rating -->
      <div class="flex items-center gap-2 mt-auto">
        <rating-stars :stars="4.5"></rating-stars>
        <span class="text-sm text-gray-500">(4.5)</span>
      </div>

      <!-- Price -->
      <div class="mt-2">
        <h6 class="text-xs text-gray-400">250 ml</h6>
        <h5 class="text-lg font-semibold">
          <span class="text-emerald-600">$08.02</span>
          <del class="ml-1 text-gray-400 text-sm">$15.15</del>
        </h5>
      </div>

      <!-- Add to cart -->
      <div class="mt-4">
        <button
          class="w-full flex items-center justify-between px-2 gap-2 py-2.5 rounded-lg border border-gray-200
          text-gray-700 font-medium hover:bg-emerald-600 hover:text-white transition-all"
        >
          Add
        <span class="inline-flex rounded-full h-8 w-8 bg-gray-100 text-gray-700 items-center justify-center">
          <font-awesome-icon class="block" :icon="['fas', 'plus']"/>
        </span>
        </button>
      </div>
    </div>
  </div>

  <!-- till here -->
</template>

<style scoped>

</style>
