<script setup>

// VUE
import { ref, onMounted, watch} from 'vue'

// COMPONENTS
import DishBox from "@/components/dish/DishBox.vue";

// STORE
import { useDishStore } from "@/stores/index.js";
const dishStore = useDishStore();

// ROUTE
import {useRoute} from "vue-router";
const route = useRoute();

// REF
const dishes = ref([]);

// WATCH
watch(() => dishStore.getDishes, () => {
  dishes.value = dishStore.getDishes;
})

watch(() => route.query, async () => {
  if (Object.keys(route.query).length === 0) {
    await dishStore.fetchDishes();
  }
})

// MOUNTING
onMounted(async () => {
  const res = await dishStore.fetchDishes(route.query);
  if (res.success) {
    dishes.value = res.data
  }
})

</script>

<template>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6 product-list-section">
    <DishBox v-for="dish in dishes"
             :key="dish.id"
             :id="dish.id"
             :name="dish.name"
             :description="dish.description"
             :category="dish.category.name"
             :price="+dish.price"
             :image="dish.thumbnail"

    />
  </div>
</template>

<style scoped>

</style>
