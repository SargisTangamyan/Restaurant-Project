<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import ToggleFilter from "@/components/filter/ToggleFilter.vue";

const route = useRoute()
const router = useRouter()

const sortOptions = [
  { value: 'created_at', label: 'Newest' },
  { value: 'name', label: 'Name' },
  { value: 'price', label: 'Price' },
]

const sortBy = ref('created_at')
const sortDirection = ref('desc')

const updateSort = (newSortBy) => {
  // If clicking the same sort option, toggle direction
  if (sortBy.value === newSortBy) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
  } else {
    // Default direction based on sort type
    sortBy.value = newSortBy
    sortDirection.value = newSortBy === 'price' ? 'asc' : 'desc'
  }

  applySort()
}

const applySort = () => {
  router.replace({
    query: {
      ...route.query,
      sort_by: sortBy.value,
      sort_direction: sortDirection.value,
    }
  })
}

onMounted(() => {
  if (route.query.sort_by) {
    sortBy.value = route.query.sort_by
  }
  if (route.query.sort_direction) {
    sortDirection.value = route.query.sort_direction
  }
})
</script>

<template>
  <toggle-filter name="Sort By">
    <div class="space-y-2">
      <button
        v-for="option in sortOptions"
        :key="option.value"
        @click="updateSort(option.value)"
        class="w-full flex justify-between items-center px-3 py-2 rounded-lg transition-colors"
        :class="sortBy === option.value
          ? 'bg-cgreen text-white'
          : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
      >
        <span>{{ option.label }}</span>
        <span v-if="sortBy === option.value" class="text-sm">
          {{ sortDirection === 'asc' ? '↑' : '↓' }}
        </span>
      </button>
    </div>
  </toggle-filter>
</template>

<style scoped>
</style>
