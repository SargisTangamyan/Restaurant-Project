<script setup>
import { toRef } from 'vue'
import { useCartToggle } from '@/composables/useCartToggle.js'

const props = defineProps({
  dishId: {
    type: [Number, String],
    required: true
  },
  quantity: {
    type: Number,
    default: 1,
    required: false,
  }
})

const dishIdRef = toRef(props, 'dishId')
const quantityRef = toRef(props, 'quantity')
const { isInCart, isLoading, toggleCart } = useCartToggle(dishIdRef, quantityRef)
</script>

<template>
  <button
    @click="toggleCart"
    :disabled="isLoading"
    class="w-full flex items-center justify-between px-2 gap-2 py-2.5 rounded-lg border border-gray-200 font-medium transition-all"
    :class="[
      isInCart
        ? 'bg-emerald-600 text-white hover:bg-emerald-700'
        : 'text-gray-700 hover:bg-emerald-600 hover:text-white',
      isLoading ? 'opacity-50 cursor-not-allowed' : ''
    ]"
  >
    {{ isInCart ? 'Remove from Cart' : 'Add to Cart' }}
    <span
      class="inline-flex rounded-full h-8 w-8 bg-gray-100 text-gray-700 items-center justify-center"
    >
      <!-- Loading Spinner -->
      <svg
        v-if="isLoading"
        class="animate-spin h-5 w-5"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>

      <!-- Icon -->
      <font-awesome-icon
        v-else
        class="block"
        :icon="['fas', isInCart ? 'check' : 'plus']"
      />
    </span>
  </button>
</template>

<style scoped>
</style>
