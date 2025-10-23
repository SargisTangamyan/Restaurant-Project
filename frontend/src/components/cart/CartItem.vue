<script setup>
import { ref } from 'vue'
import TheCounter from "@/components/ui/TheCounter.vue";
import { STORAGE } from "@/constants/urls.js";
import { useCartStore } from "@/stores/cart/index.js";
import debounce from "lodash/debounce";

const props = defineProps({
  item: {
    required: true,
    type: Object,
  }
});

const cartStore = useCartStore();
const isRemoving = ref(false);

// METHODS
const updateItem = debounce(async (count) => {
  const response = await cartStore.updateQuantity(props.item.id, count);
  if (!response.success) {
    console.error('Failed to update quantity:', response.errors);
  }
}, 300);

const removeItem = async () => {
  isRemoving.value = true;

  setTimeout(async () => {
    const response = await cartStore.removeFromCart(props.item.id);
    if (!response.success) {
      console.error('Failed to remove item:', response.errors);
      isRemoving.value = false;
    }
  }, 300);
};
</script>

<template>
  <transition name="slide-fade">
    <div
      v-if="!isRemoving"
      class="bg-white rounded-2xl shadow p-4 flex flex-col md:flex-row items-center gap-4 transition-all duration-300"
    >
      <img :src="`${STORAGE}/${item.thumbnail}`" class="w-28 h-28 object-cover rounded-lg" alt="Dish Name">

      <div class="flex-1 flex flex-col gap-2">
        <h3 class="text-lg font-semibold text-gray-800">{{ item.name }}</h3>
        <div class="flex items-center gap-4 mt-2">
          <h4 class="text-xl font-bold text-cgreen">${{ item.price }}</h4>
          <del class="text-gray-400">$58.46</del>
        </div>
      </div>

      <div class="flex items-center gap-2 mt-2 md:mt-0">
        <!-- Quantity -->
        <the-counter :counter="item.quantity" @counter-change="updateItem"></the-counter>
      </div>

      <!-- Remove -->
      <button
        class="text-gray-500 hover:text-red-500 ml-auto transition-colors duration-200"
        @click="removeItem"
        title="Remove from cart"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
  </transition>
</template>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from {
  transform: translateX(-20px);
  opacity: 0;
}

.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
