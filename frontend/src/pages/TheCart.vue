<script setup>

// COMPONENTS
import PageName from "@/components/ui/PageName.vue";
import TheCounter from "@/components/ui/TheCounter.vue";
import TheBox from "@/components/ui/TheBox.vue";

</script>

<template>
  <page-name p-name="Cart" />
  <the-box class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
          <div v-for="n in 5" :key="n" class="bg-white rounded-2xl shadow p-4 flex flex-col md:flex-row items-center gap-4">
            <img src="../assets/images/dish/1.jpg" class="w-28 h-28 object-cover rounded-lg" alt="Dish Name">

            <div class="flex-1 flex flex-col gap-2">
              <h3 class="text-lg font-semibold text-gray-800">Creamy Chocolate Cake</h3>
              <div class="flex items-center gap-4 mt-2">
                <h4 class="text-xl font-bold text-cgreen">$49.50</h4>
                <del class="text-gray-400">$58.46</del>
              </div>
            </div>

            <div class="flex items-center gap-2 mt-2 md:mt-0">
              <!-- Quantity -->
              <the-counter></the-counter>
            </div>

            <!-- Remove -->
            <button class="text-gray-500 hover:text-red-500 ml-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <!-- Repeat above block for more cart items -->
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-2xl h-fit shadow p-6 space-y-4">
          <h3 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h3>
          <div class="flex justify-between text-gray-600">
            <span>Subtotal</span>
            <span>$49.50</span>
          </div>
          <div class="flex justify-between text-gray-600">
            <span>Tax</span>
            <span>$4.95</span>
          </div>
          <div class="flex justify-between text-gray-800 font-bold text-lg border-t border-gray-200 pt-2">
            <span>Total</span>
            <span>$54.45</span>
          </div>

          <button class="button-cgreen w-full">
            Proceed to Checkout
          </button>
        </div>
      </div>
    </div>
  </the-box>

</template>

<style scoped>

</style>
