<script setup>

import { defineProps } from 'vue';

defineProps({
  mb: {
    required: false,
    default: true,
  }
});

</script>

<template>
  <div class="w-full px-4 md:px-6 lg:px-8 box-border xl:px-16" :class="{'my-8': mb}">
    <slot></slot>
  </div>
</template>

<style scoped>

</style>
