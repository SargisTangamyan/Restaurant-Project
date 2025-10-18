<script setup>
// VUE
import {defineEmits, onMounted} from 'vue'
// COMPONENTS
import ErrorMessage from "@/components/ui/form/ErrorMessage.vue";
import FormLabel from "@/components/ui/form/FormLabel.vue";
// COMPOSABLE
import { useSearchStrict } from '@/composables/useSearchStrict.js'
// STORE
import { useIngredientStore } from '@/stores/index.js'

// USING STORE
const ingredientStore = useIngredientStore();

// USING EMITS
const emits = defineEmits(['wordChosen', 'incorrectWord'])

// USING COMPOSABLE
const { query, filteredItems: filteredIngredients, message, onInput, selectItem: selectIngredient, clearQuery, init } = useSearchStrict({
  searchFn: ingredientStore.searchIngredients,
  queryParam: 'ingredient',
  jsonName: 'foundIngredients',
  emitWordChosen: (id, name) => {emits('wordChosen', id, name)},
  emitIncorrectWord: () => {emits('incorrectWord')},
})

// MOUNTING
onMounted(() => {
  init();
})

// EXPOSING FUNCTION
defineExpose({clearQuery})
</script>

<template>
  <div class="relative">
    <form-label label="Ingredients" />

    <input
      type="text"
      v-model="query"
      @input="onInput"
      placeholder="e.g. Desserts"
      class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-600"
    />

    <error-message :message="message" />

    <ul
      v-if="filteredIngredients.length"
      class="absolute z-10 bg-white border border-gray-300 mt-1 w-full rounded-lg max-h-40 overflow-auto"
    >
      <li
        v-for="ingredient in filteredIngredients"
        :key="ingredient.id"
        @click="selectIngredient(ingredient)"
        class="p-2 hover:bg-blue-100 cursor-pointer"
      >
        {{ ingredient.name }}
      </li>
    </ul>
  </div>
</template>
