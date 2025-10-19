<script setup>

// VUE
import { ref, onMounted, watch} from 'vue'

// COMPONENTS
import DishBox from "@/components/dish/DishBox.vue";

// STORE
import { useDishStore } from "@/stores/index.js";

// USING STORE
const dishStore = useDishStore();

// REF
const dishes = ref([]);

// WATCH
watch(() => dishStore.getDishes, () => {
  console.log('dishes changed');
  dishes.value = dishStore.getDishes;
})

// MOUNTING
onMounted(async () => {
  const res = await dishStore.fetchDishes()
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
