<script setup>
// VUE
import { defineProps } from 'vue';

const props = defineProps({
  name: {
    required: true,
    type: String,
  }
})

</script>

<template>
  <h2 class="text-xl font-bold text-gray-800 relative">
    <span>{{ props.name }}</span>
    <span class="absolute bottom-0 left-0 w-full border-b border-cgreen"></span>
  </h2>
</template>

<style scoped>

</style>
