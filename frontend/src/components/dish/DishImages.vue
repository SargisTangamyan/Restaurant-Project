<script setup>

</script>

<template>
  <div>
    <div class="aspect-square">
      <img src="../../assets/images/dish/1.jpg" id="img-1"
           data-zoom-image="../assets/images/product/category/1.jpg"
           class="w-full h-full object-cover" alt="">
    </div>
  </div>

  <div class="flex gap-1">
    <div v-for="n in 5" :key="n">
      <div class="aspect-square">
        <img src="../../assets/images/dish/1.jpg"
             data-zoom-image="../assets/images/product/category/2.jpg"
             class="w-full h-full object-cover" alt="">
      </div>
    </div>

  </div>
</template>

<style scoped>

</style>
