<script setup>

// COMPONENTS
import DishBox from "@/components/dish/DishBox.vue";
import PageName from "@/components/ui/PageName.vue";

</script>

<template>
  <page-name p-name="WishList" />
  <div class="grid grid-cols-4 gap-4 bg-white rounded-2xl shadow-sm p-5 border border-gray-100">

    <dish-box v-for="n in 7" :key="n"/>

    <div v-if="true" class="text-center text-gray-400 mt-4">
      Your wishlist is empty
    </div>
  </div>
</template>

<style scoped>

</style>
