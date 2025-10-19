<script setup>

import TrendingItem from "@/components/detail/trending/TrendingItem.vue";

</script>

<template>
  <div class="category-menu bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
    <h3 class="text-xl font-semibold mb-5 border-b pb-2 text-gray-800">Trending Products</h3>

    <ul class="space-y-4">
      <trending-item v-for="n in 4" :key="n" />
    </ul>
  </div>
</template>

<style scoped>

</style>
