<template>
  <img
    :src="computedImagePath"
    :alt="alt"
    @error="handleError"
    v-bind="$attrs"
    class="w-full h-full object-cover"
  />
</template>

<script setup>
import {computed, ref, defineProps, defineEmits, watch} from 'vue'
import {STORAGE} from "@/constants/urls.js";

const props = defineProps({
  imagePath: {
    type: [String, null],
    default: null,
    required: true
  },
  alt: {
    type: String,
    default: ''
  },
  fallbackImage: {
    type: String,
    default: '/images/placeholder.jpg'
  }
})

watch(() => props.imagePath, () => {
  hasError.value = false
})


const emits = defineEmits(['error', 'load'])

const hasError = ref(false)

const computedImagePath = computed(() => {
  if (hasError.value) {
    return props.fallbackImage
  }
  return `${STORAGE}/${props.imagePath}`
})

const handleError = (event) => {
  if (!hasError.value) {
    hasError.value = true
    emits('error', {
      originalPath: props.imagePath,
      fallbackPath: props.fallbackImage,
      event
    })
  }
}

const handleLoad = (event) => {
  emits('load', event)
}
</script>
