<script setup>

// VUE
import { defineProps } from 'vue';

// USING PROPS
defineProps({
  element: {
    required: false,
    type: [String, Number],
    default: null,
  }
})

</script>

<template>
  <td class="p-3 border-b font-medium">
    {{ element ?? '' }}
    <slot />
  </td>
</template>

<style scoped>

</style>
