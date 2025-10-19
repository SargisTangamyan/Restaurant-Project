<script setup>

// COMPONENT
import RatingStars from "@/components/ui/RatingStars.vue";
</script>

<template>
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
    <div class="flex items-center gap-2">
      <rating-stars :stars="4.5" />
      <span class="text-lg font-medium text-gray-700 ml-2">4.5 out of 5</span>
    </div>
    <span class="text-sm text-gray-500 mt-2 md:mt-0">Based on 23 customer reviews</span>
  </div>
</template>

<style scoped>

</style>
