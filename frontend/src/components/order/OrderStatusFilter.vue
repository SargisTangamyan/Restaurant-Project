<script setup>

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
  modelValue: {
    type: String,
    default: null
  }
});

const statuses = [
  { value: null, label: 'All Orders' },
  { value: 'pending', label: 'Pending' },
  { value: 'confirmed', label: 'Confirmed' },
  { value: 'preparing', label: 'Preparing' },
  { value: 'completed', label: 'Completed' },
  { value: 'delivered', label: 'Delivered' },
  { value: 'cancelled', label: 'Cancelled' }
];

const selectStatus = (value) => {
  emit('update:modelValue', value);
}

</script>

<template>
  <div class="flex flex-wrap gap-2">
    <button
    v-for="status in statuses"
    :key="status.value || 'all'"
    @click="selectStatus(status.value)"
    :class="[
      'px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200',
      modelValue === status.value ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'
    ]"
    >
      {{ status.label }}
    </button>
  </div>
</template>

<style scoped>

</style>
