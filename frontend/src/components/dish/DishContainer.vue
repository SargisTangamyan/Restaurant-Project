<script setup>

// COMPONENTS
import DishBox from "@/components/dish/DishBox.vue";
</script>

<template>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6 product-list-section">
    <DishBox v-for="n in 7" :key="n"/>
  </div>
</template>

<style scoped>

</style>
