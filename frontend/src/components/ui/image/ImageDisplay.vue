<script setup>

import {STORAGE} from "@/constants/urls.js";

defineProps({
  url: {
    required: true,
    type: String,
  },
  alt: {
    required: true,
    type: String,
  }
})
</script>

<template>
  <img
    :src="`${STORAGE}/${url}`"
    :alt="alt"
    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
  />
</template>

<style scoped>

</style>
