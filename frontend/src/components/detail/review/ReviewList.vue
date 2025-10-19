<script setup>

// COMPONENT
import ReviewItem from "@/components/detail/review/ReviewItem.vue";

</script>

<template>
  <div class="space-y-6">
    <review-item v-for="r in 3" :key="r" />
  </div>
</template>

<style scoped>

</style>
