<script setup>

// PROPS
defineProps({
  items: {
    required: true,
    type: Array,
  },
  total: {
    required: true,
    type: Number,
  }
})

</script>

<template>
  <div class="bg-white rounded-2xl h-fit shadow p-6 space-y-4">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h3>
    <div v-for="item in items" :key="item.id" class="flex justify-between text-gray-600">
      <div>
        <span>{{item.name}}</span>
      </div>
      <div>
        <span>{{item.quantity}}</span> <font-awesome-icon class="text-sm" :icon="['fas', 'xmark']" /> <span>${{item.price}}</span>
      </div>
    </div>
    <div class="flex justify-between text-gray-800 font-bold text-lg border-t border-gray-200 pt-2">
      <span>Total</span>
      <span>${{ total.toFixed(2) }}</span>
    </div>

    <button class="button-cgreen w-full">
      Proceed to Checkout
    </button>
  </div>
</template>

<style scoped>

</style>
