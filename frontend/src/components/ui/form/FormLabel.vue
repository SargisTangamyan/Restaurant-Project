<script setup>

// VUE
import { defineProps } from 'vue';

defineProps({
  label: {
    required: true,
    type: String,
  }
})

</script>

<template>
  <label class="block text-sm text-gray-600 mb-1">{{ label }}</label>
</template>

<style scoped>

</style>
