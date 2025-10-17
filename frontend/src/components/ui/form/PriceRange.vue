<script setup>
// VUE
import {defineProps, ref } from 'vue'

const props = defineProps({
  maxPrice: {
    type: Number,
    required: true,
  }
})

// REFS
const currentPrice = ref(Math.round(props.maxPrice));

</script>

<template>
  <div class="mt-2 relative w-full">
    <!-- floating label -->
    <input v-model="currentPrice" type="range" min="0" :max="props.maxPrice"
           class="w-full accent-[#0DA487]">
    <div>
      Value: <span class="text-cgreen">{{currentPrice}}$</span>
    </div>
  </div>
</template>

<style scoped>

</style>
