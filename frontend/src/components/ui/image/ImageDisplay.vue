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
  },
  inner: {
    required: false,
    type: Boolean,
    default: false,
  }
})
</script>

<template>
  <img
    :src="inner ? url : `${STORAGE}/${url}`"
    :alt="alt"
    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
  />
</template>

<style scoped>

</style>
