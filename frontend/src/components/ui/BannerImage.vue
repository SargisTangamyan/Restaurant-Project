<script setup>

// VUE
import { defineProps } from 'vue';
import ImageDisplay from "@/components/ui/image/ImageDisplay.vue";

const props = defineProps({
  imageSrc: {
    required: true,
    type: [String, null],
  },
  imageAlt: {
    required: true,
    type: String,
  }
})

</script>

<template>
  <div class="w-full h-full relative rounded-md overflow-hidden">
    <image-display class="rounded-lg" :image-path="props.imageSrc" :alt="props.imageAlt" />
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
    <slot />
  </div>
</template>

<style scoped>

</style>
