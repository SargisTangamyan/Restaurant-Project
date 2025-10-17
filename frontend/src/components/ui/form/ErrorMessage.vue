<script setup>

// VUE
import { defineProps } from 'vue'

const props = defineProps({
  message: {
    type: String,
    required: true,
  }
})

</script>

<template>
  <p v-if="message" class="text-red-500 pt-1">- {{ message }}</p>
</template>

<style scoped>

</style>
