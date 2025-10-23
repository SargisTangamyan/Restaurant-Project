<script setup>

import TheCounter from "@/components/ui/TheCounter.vue";
import {STORAGE} from "@/constants/urls.js";
import debounce from "lodash/debounce";

defineProps({
  item: {
    required: true,
    type: Object,
  }
});

// COMPOSABLE
import {useCartFunctionality} from "@/composables/useCartFunctionality.js";
const {removeFromCart} = useCartFunctionality()

// METHODS
const updateItem = debounce(async(count) => {
  console.log(count)
}, 300);

</script>

<template>
  <div class="bg-white rounded-2xl shadow p-4 flex flex-col md:flex-row items-center gap-4">
    <img :src="`${STORAGE}/${item.thumbnail}`" class="w-28 h-28 object-cover rounded-lg" alt="Dish Name">

    <div class="flex-1 flex flex-col gap-2">
      <h3 class="text-lg font-semibold text-gray-800">{{item.name}}</h3>
      <div class="flex items-center gap-4 mt-2">
        <h4 class="text-xl font-bold text-cgreen">${{item.price}}</h4>
        <del class="text-gray-400">$58.46</del>
      </div>
    </div>

    <div class="flex items-center gap-2 mt-2 md:mt-0">
      <!-- Quantity -->
      <the-counter :counter="item.quantity" @counter-change="updateItem"></the-counter>
    </div>

    <!-- Remove -->
    <button class="text-gray-500 hover:text-red-500 ml-auto"
            @click="removeFromCart(item.id)"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
  </div>
</template>

<style scoped>

</style>
