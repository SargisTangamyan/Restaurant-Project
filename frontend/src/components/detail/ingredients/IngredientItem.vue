<script setup>

// VUE
import {defineProps} from 'vue'

// PROPS
defineProps({
  ingredient: {
    required: true,
    type: String
  }
})

</script>

<template>
  <div class="flex items-center gap-2 text-sm font-medium">
    <font-awesome-icon class="text-cgreen" :icon="['fas', 'circle']" />
    <span>{{ ingredient }}</span>
  </div>
</template>

<style scoped>

</style>
