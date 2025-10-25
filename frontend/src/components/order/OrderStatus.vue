<script setup>

defineProps({
  status: {
    required: true,
    type: String,
  }
})

const getStatusClass = (status) => {
  const statusClasses = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    shipped: 'bg-purple-100 text-purple-800',
    delivered: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
  }
  return statusClasses[status?.toLowerCase()] || 'bg-gray-100 text-gray-800'
}

</script>

<template>
  <span
    :class="getStatusClass(status)"
    class="px-3 py-1 rounded-full text-xs font-medium"
  >
    {{ status }}
  </span>
</template>

<style scoped>

</style>
