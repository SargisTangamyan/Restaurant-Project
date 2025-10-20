<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useDishStore } from '@/stores/index.js'
import { useQueryWriter } from '@/composables/useQueryWriter.js'

import debounce from 'lodash/debounce'

const route = useRoute()
const dishStore = useDishStore()

// Use composable for managing search query in the route
const { query:search, writeQuery, clearAllExceptCurrent } = useQueryWriter({ queryParam: 'search' })

// Refs
const results = ref([])
const showDropdown = ref(false)
const loading = ref(false)

// --- Keep search in sync with route changes
watch(
  () => route.query.search,
  (newSearch) => {
    if (newSearch !== search.value) {
      search.value = newSearch || ''
    }
  }
)

// --- Function to search dishes (UNCHANGED)
const searchDishes = debounce(async () => {
  const queryValue = search.value.trim()
  if (!queryValue) {
    results.value = []
    showDropdown.value = false
    return
  }

  loading.value = true
  const response = await dishStore.searchDishes(queryValue)
  if (response?.success) {
    results.value = response.names
    showDropdown.value = results.value.length > 0
  } else {
    results.value = []
  }
  loading.value = false
}, 300);

// --- Fetch dishes (triggered by Enter or Search button)
const fetchDishes = async (clearOtherParams = false) => {
  const queryValue = search.value.trim()
  if (!queryValue) {
    results.value = []
    showDropdown.value = false
    writeQuery('') // update route
    return
  }

  if (clearOtherParams) {
    await clearAllExceptCurrent()
  }

  await dishStore.fetchDishes({ search: queryValue })
}

// --- Clear search input and dropdown (without touching route)
const clearSearch = () => {
  search.value = ''
  results.value = []
  showDropdown.value = false
}

// --- Handle Enter key
const handleEnter = (event) => {
  event.preventDefault()
  fetchDishes(true)
  clearSearch();
}

// --- Hide dropdown after blur
const hideDropdown = () => {
  setTimeout(() => (showDropdown.value = false), 200)
}

// --- Select a dish from dropdown
const selectDish = (dishName) => {
  search.value = dishName
  fetchDishes(true) // keeps search query in route
  clearSearch()
}
</script>



<template>
  <div class="relative w-full">
    <div class="flex w-full border border-gray-200 rounded-lg overflow-hidden">
      <input
        type="search"
        v-model="search"
        @input="searchDishes"
        @focus="showDropdown = !!search"
        @blur="hideDropdown"
        @keyup.enter="handleEnter"
        placeholder="I'm searching for..."
        class="flex-1 border-none py-3 px-4 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500"
      >
      <button
        class="w-16 bg-orange-400 flex items-center justify-center cursor-pointer hover:bg-orange-600 transition duration-150"
        type="button"
        @click="fetchDishes(true)"
      >
        <svg class="h-6 w-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
          <path d="M448 272C448 174.8 369.2 96 272 96C174.8 96 96 174.8 96 272C96 369.2 174.8 448 272 448C369.2 448 448 369.2 448 272zM407.3 430C371 461.2 323.7 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272C480 323.7 461.2 371 430 407.3L571.3 548.7C577.5 554.9 577.5 565.1 571.3 571.3C565.1 577.5 554.9 577.5 548.7 571.3L407.3 430z"/>
        </svg>
      </button>
    </div>

    <!-- Dropdown -->
    <ul
      v-if="showDropdown"
      class="absolute z-10 w-full bg-white border border-gray-200 rounded mt-1 max-h-60 overflow-auto shadow-lg"
    >
      <li
        v-for="(dishName, index) in results"
        :key="index"
        @click="selectDish(dishName)"
        class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
      >
        {{ dishName }}
      </li>
      <li v-if="loading" class="px-4 py-2 text-gray-500">Loading...</li>
      <li v-if="!loading && !results.length" class="px-4 py-2 text-gray-500">No matches found</li>
    </ul>
  </div>
</template>
