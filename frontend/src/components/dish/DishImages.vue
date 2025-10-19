<script setup>

// VUE
defineProps({
  imagePath: {
    required: true,
    type: String,
  }
})

// URL
import { STORAGE } from "@/constants/urls.js";

</script>

<template>
  <div class="aspect-square rounded-xl overflow-hidden">
    <img :src="`${STORAGE}/${imagePath}`" id="img-1"
         class="w-full h-full object-cover" alt="">
  </div>
</template>

<style scoped>

</style>
