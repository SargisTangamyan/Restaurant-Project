<script setup>
import { ref, onMounted, defineEmits } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import debounce from 'lodash/debounce'

import {useCategoryStore} from "@/stores/index.js";

const categoryStore = useCategoryStore();

const emit = defineEmits(['wordChosen'])

const route = useRoute()
const router = useRouter()

const query = ref('')
const filteredCategories = ref([])
const message = ref('')


// Load input value from URL on mount
onMounted(() => {
  query.value = route.query.parent || ''
  if (query.value) {
    filterCategories()
  }
})

// Update URL when input changes
const updateQuery = debounce(() => {
  router.replace({
    query: { ...route.query, parent: query.value || undefined } // remove from URL if empty
  })
}, 300)

// Filter categories with debounce
const filterCategories = debounce(async () => {
  if (!query.value) {
    filteredCategories.value = []
    return
  }
  const response = await categoryStore.searchCategories(query.value);
  if (response.success) {
    message.value = '';
    filteredCategories.value = response.foundCategories ?? [];
  } else {
    message.value = response.message;
    filteredCategories.value = [];
  }
}, 300)

// Handle input
function onInput() {
  filterCategories()
  updateQuery()
}

function selectCategory(category, id) {
  query.value = ''
  filteredCategories.value = []
  updateQuery()
  emit('wordChosen', id)
}
</script>

<template>
    <div class="relative">
      <label class="block text-sm text-gray-600 mb-1">Parent Category</label>
      <input
        type="text"
        v-model="query"
        @input="onInput"
        placeholder="e.g. Desserts"
        class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />

      <p v-show="message" class="text-red-500 text-center pt-1">No Parent Found</p>

      <ul
        v-if="filteredCategories.length"
        class="absolute z-10 bg-white border border-gray-300 mt-1 w-full rounded-lg max-h-40 overflow-auto"
      >
        <li
          v-for="category in filteredCategories"
          :key="category.id"
          @click="selectCategory(category.name, category.id)"
          class="p-2 hover:bg-blue-100 cursor-pointer"
        >
          {{ category.name }}
        </li>
      </ul>
    </div>
</template>

<style scoped>

</style>
