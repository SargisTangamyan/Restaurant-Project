<script setup>

import {defineProps} from 'vue'

defineProps({
  heading: {
    type: String,
    required: true
  }
})

</script>

<template>
  <main class="flex-1 bg-white rounded-xl shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{heading}}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <slot />

    </div>
  </main>
</template>

<style scoped>

</style>
