<script setup>
// VUE
import {defineEmits, onMounted} from 'vue'
// COMPONENTS
import ErrorMessage from "@/components/ui/ErrorMessage.vue";
// COMPOSABLE
import { useSearchStrict } from '@/composables/useSearchStrict.js'
// STORE
import { useCategoryStore } from '@/stores/index.js'

// USING STORE
const categoryStore = useCategoryStore();

// USING EMITS
const emits = defineEmits(['wordChosen', 'incorrectWord'])

// USING COMPOSABLE
const { query, filteredItems: filteredCategories, message, onInput, selectItem: selectCategory, clearQuery, init } = useSearchStrict({
  searchFn: categoryStore.searchCategories,
  queryParam: 'parent',
  jsonName: 'foundCategories',
  emitWordChosen: (id) => {emits('wordChosen', id)},
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
    <label class="block text-sm text-gray-600 mb-1">Parent Category</label>

    <input
      type="text"
      v-model="query"
      @input="onInput"
      placeholder="e.g. Desserts"
      class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-600"
    />

    <error-message :message="message" />

    <ul
      v-if="filteredCategories.length"
      class="absolute z-10 bg-white border border-gray-300 mt-1 w-full rounded-lg max-h-40 overflow-auto"
    >
      <li
        v-for="category in filteredCategories"
        :key="category.id"
        @click="selectCategory(category)"
        class="p-2 hover:bg-blue-100 cursor-pointer"
      >
        {{ category.name }}
      </li>
    </ul>
  </div>
</template>
