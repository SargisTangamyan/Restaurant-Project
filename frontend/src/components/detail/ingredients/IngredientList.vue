<script setup>

// VUE
import {defineProps} from 'vue'

// COMPONENT
import IngredientItem from "@/components/detail/ingredients/IngredientItem.vue";

defineProps({
  ingredients: {
    required: true,
    type: Array,
  }
})

</script>

<template>
  <div v-if="ingredients.length > 0">
    <h4 class="font-semibold mb-3 text-gray-800 text-xl border-b pb-2">The Ingredients of Our Dish</h4>

    <p class="text-gray-600 mb-4 text-sm">
      Crafted with passion using only the freshest, high-quality ingredients. Experience the difference in every bite!
    </p>

    <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-gray-700">
        <ingredient-item v-for="(ingredient, index) in ingredients" :key="index" :ingredient="ingredient" />
    </div>
  </div>
</template>

<style scoped>

</style>
