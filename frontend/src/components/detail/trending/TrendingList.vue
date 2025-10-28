<script setup>
import { ref, onMounted, defineProps, watch } from 'vue'
import { useDishStore } from '@/stores/dish'
import TrendingItem from './TrendingItem.vue'

const props = defineProps({
  dishId: {
    type: [Number, String],
    required: true
  },
  limit: {
    type: Number,
    default: 5
  }
})

const dishStore = useDishStore()
const relatedDishes = ref([])
const isLoading = ref(false)

const fetchRelatedDishes = async () => {
  if (!props.dishId) return

  isLoading.value = true

  try {
    const response = await dishStore.fetchRelatedDishes(props.dishId, props.limit)

    if (response.success) {
      relatedDishes.value = response.dishes
    } else {
      relatedDishes.value = []
    }
  } catch (error) {
    console.error('Error loading related dishes:', error)
    relatedDishes.value = []
  } finally {
    isLoading.value = false
  }
}

// Watch for dishId changes
watch(() => props.dishId, () => {
  fetchRelatedDishes()
}, { immediate: true })

onMounted(() => {
  fetchRelatedDishes()
})
</script>

<template>
  <div class="category-menu bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
    <h3 class="text-xl font-semibold mb-5 border-b pb-2 text-gray-800">Trending Products</h3>

    <!-- Loading State -->
    <div v-if="isLoading" class="space-y-4">
      <div v-for="i in 3" :key="i" class="animate-pulse">
        <div class="h-20 bg-gray-200 rounded-lg"></div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else-if="!relatedDishes.length" class="text-center py-8">
      <font-awesome-icon :icon="['fas', 'utensils']" class="text-gray-300 text-4xl mb-2" />
      <p class="text-gray-500 text-sm">No similar dishes found</p>
    </div>

    <div v-else class="space-y-4">
      <trending-item v-for="dish in relatedDishes" :key="dish.id" :dish="dish" />
    </div>
  </div>
</template>

<style scoped>

</style>
