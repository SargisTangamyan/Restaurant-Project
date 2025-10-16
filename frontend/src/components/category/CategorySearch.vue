<script setup>
import { ref, onMounted, defineEmits, defineExpose } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import debounce from 'lodash/debounce'
import { useCategoryStore } from '@/stores/index.js'
import ErrorMessage from "@/components/ui/ErrorMessage.vue";

const categoryStore = useCategoryStore()
const emits = defineEmits(['wordChosen', 'incorrectWord'])

const route = useRoute()
const router = useRouter()

const query = ref('')
const filteredCategories = ref([])
const message = ref('')

// Load input value from URL on mount
onMounted(() => {
  query.value = route.query.parent || ''
})

// Update URL instantly when input changes
const updateQuery = () => {
  router.replace({
    query: { ...route.query, parent: query.value || undefined },
  })
}

// Debounced category filter (API call)
const filterCategories = debounce(async () => {
  if (!query.value) {
    filteredCategories.value = []
    message.value = ''
    return
  }

  const response = await categoryStore.searchCategories(query.value)

  if (response.success) {
    message.value = ''
    filteredCategories.value = response.foundCategories ?? []
  } else {
    message.value = response.message || 'No Parent Found'
    filteredCategories.value = []
    emits('incorrectWord')
  }
}, 300)

// Handle input
function onInput() {
  updateQuery()
  filterCategories()
}

// Select category
function selectCategory(category) {
  query.value = category.name
  filteredCategories.value = []
  emits('wordChosen', category.id)
  updateQuery()
}

const clearQuery = function () {
  router.replace({
    query: { ...route.query, parent: undefined },
  })
}

const resetParentCategory = function () {
  clearQuery();
  query.value = '';
}

defineExpose({resetParentCategory})
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
