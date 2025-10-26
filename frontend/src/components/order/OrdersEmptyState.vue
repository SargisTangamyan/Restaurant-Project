<script setup>

defineProps({
  message: {
    type: String,
    default: 'No orders found',
  },
  description: {
    type: String,
    default: 'Orders will appear here once customers place them'
  }
})

</script>

<template>
  <template>
    <div class="flex justify-center items-center py-16">
      <div class="text-center bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-12 shadow-sm max-w-md">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-16 w-16 mx-auto mb-4 text-gray-400"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
          />
        </svg>
        <p class="text-gray-700 text-xl font-semibold mb-2">{{ message }}</p>
        <p class="text-gray-500 text-sm">{{ description }}</p>
      </div>
    </div>
  </template>
</template>

<style scoped>

</style>
