<script setup>

defineProps({
  items: {
    type: Array,
    required: true,
  }
});

</script>

<template>
  <div class="space-y-2">
    <h4 class="text-sm font-semibold text-gray-700 mb-3">OrderItems:</h4>
    <div
    v-for="item in items"
    :key="item.id"
    class="flex justify-between items-center text-sm py-2 border-b border-gray-100 last:border-0"
    >
      <div class="flex-1">
        <p class="text-gray-800 font-medium">{{ item.dish?.name || 'N/A' }}</p>
        <p class="text-gray-500 text-xs">Quantity: {{ item.quantity }}</p>
      </div>
      <p class="texst-gray-900 font-semibold">${{ (item.price * item.quantity).toFixed(2) }}</p>
    </div>
  </div>
</template>

<style scoped>

</style>
