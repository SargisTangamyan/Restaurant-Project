<script setup>

// VUE
import { ref, onMounted} from 'vue'

// COMPONENTS
import DishBox from "@/components/dish/DishBox.vue";

// STORE
import { useDishStore } from "@/stores/index.js";

// USING STORE
const dishStore = useDishStore();

// REF
const dishes = ref([]);

onMounted(async () => {
  const res = await dishStore.fetchDishes()
  if (res.success) {
    dishes.value = res.data
    console.log('data ready')
  }
})

</script>

<template>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6 product-list-section">
    <DishBox v-for="dish in dishes"
             :key="dish.id"
             :name="dish.name"
             :description="dish.description"
             :category="dish.category.name"
             :image="dish.image"
             :price="+dish.price"

    />
  </div>
</template>

<style scoped>

</style>
