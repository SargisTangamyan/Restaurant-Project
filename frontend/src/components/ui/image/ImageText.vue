<script setup>

// VUE
import { defineProps } from 'vue';

const props = defineProps({
  imageSrc: {
    required: true,
    type: String,
  },
  imageAlt: {
    required: true,
    type: String,
  }
})

</script>

<template>
  <div class="w-full h-full relative rounded-md overflow-hidden">
    <img :src="props.imageSrc" :alt="props.imageAlt"
         class="h-full w-full object-cover rounded-lg"
    />
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
    <slot />
  </div>
</template>

<style scoped>

</style>
