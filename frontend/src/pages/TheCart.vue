<script setup>
// VUE
import { computed, onMounted } from 'vue'

// COMPONENTS
import PageName from "@/components/ui/PageName.vue";
import TheBox from "@/components/ui/TheBox.vue";
import CartSummary from "@/components/cart/CartSummary.vue";
import CartItem from "@/components/cart/CartItem.vue";

// STORE
import { useCartStore } from "@/stores/cart/index.js"
const cartStore = useCartStore()

// COMPUTED
const cartItems = computed(() => cartStore.getCart)
const total = computed(() => cartStore.getTotal)
const hasItems = computed(() => cartItems.value.length > 0)

onMounted(async () => {
  await cartStore.fetchCart()

})
</script>

<template>
  <page-name p-name="Cart" />

  <the-box class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">

      <div v-if="hasItems" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
          <cart-item
            v-for="item in cartItems"
            :key="item.id"
            :item="item"
          />
        </div>

        <!-- Order Summary -->
        <cart-summary :items="cartItems" :total="total" />
      </div>

      <div v-else class="lg:col-span-2 flex justify-center items-center h-64">
        <div
          class="text-center bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-8 shadow-lg flex flex-col items-center animate-fadeIn"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-12 w-12 mb-4 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M3 7h18M3 12h18M3 17h18"
            />
          </svg>

          <p class="text-gray-500 text-xl font-semibold">No Dishes Chosen</p>
          <p class="text-gray-400 text-sm mt-2">
            Browse our menu and add your favorite dishes to the cart!
          </p>
        </div>
      </div>

    </div>
  </the-box>
</template>
