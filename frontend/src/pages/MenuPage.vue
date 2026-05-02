<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

// COMPONENTS
import PageName from "@/components/ui/PageName.vue";
import TheBox from "@/components/ui/TheBox.vue";
import FilterSidebar from "@/components/filter/FilterSidebar.vue"
import DishContainer from "@/components/dish/DishContainer.vue"

// Banner image
import bannerjpg from '@/assets/images/restaurant/banner/menuBanner/banner.jpg'

// URLS
import { RESTAURANT_BY_SLUG } from '@/constants/urls.js'

// ROUTE
import { useRoute } from 'vue-router'
const route = useRoute()

// PROPS — slug is passed from router when route is /restaurants/:slug/dishes
const props = defineProps({
  slug: {
    type: String,
    default: null,
  },
})

const restaurant = ref(null)
const isReady = ref(false)
const filterOpen = ref(false)

const getImageUrl = (image) => {
  if (!image) return null
  return image.startsWith('http') ? image : `http://localhost:8000/storage/${image}`
}

const bannerImage = computed(() => {
  return restaurant.value?.image
    ? getImageUrl(restaurant.value.image)
    : bannerjpg
})

const bannerTitle = computed(() => restaurant.value?.name ?? 'All Dishes')
const restaurantId = computed(() => restaurant.value?.id ?? null)

onMounted(async () => {
  const slug = props.slug ?? route.params.slug ?? null
  if (slug) {
    try {
      const res = await axios.get(RESTAURANT_BY_SLUG(slug))
      restaurant.value = res.data.data
    } catch {
      // slug not found — fall back to showing all dishes
    }
  }
  // Only mount DishContainer after restaurantId is resolved,
  // so it fetches with the correct filter on its very first call.
  isReady.value = true
})
</script>

<template>
  <page-name :p-name="bannerTitle" />

  <the-box>
    <div class="container mx-auto py-2 lg:py-4">

      <!-- Mobile filter trigger bar -->
      <div class="flex items-center justify-between mb-4 px-4 py-3 bg-white rounded-xl border border-gray-100 shadow-sm lg:hidden">
        <span class="text-sm font-semibold text-gray-600">Browse &amp; Filter</span>
        <button
          @click="filterOpen = true"
          class="flex items-center gap-2 text-sm font-semibold text-[#0da487] bg-[#0da48714] px-4 py-2 rounded-lg hover:bg-[#0da48722] transition-colors"
        >
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774a1.857 1.857 0 0 1 1.542-1.836Z" clip-rule="evenodd"/>
          </svg>
          Filters
        </button>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <filter-sidebar :is-open="filterOpen" @close="filterOpen = false" />

        <div class="bg-white col-span-full lg:col-start-2 lg:col-span-3 rounded-2xl shadow-md text-gray-400 overflow-hidden">
          <!-- Banner -->
          <div class="relative w-full h-44 sm:h-56 md:h-64 mb-4 bg-gray-200">
            <img
              v-if="bannerImage"
              :src="bannerImage"
              :alt="`${bannerTitle} banner`"
              class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/35 to-transparent" />

            <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6">
              <h2 class="text-white text-xl sm:text-2xl md:text-3xl font-bold leading-tight">
                {{ bannerTitle }}
              </h2>
              <p class="text-white/90 text-sm sm:text-base mt-1">
                Menu
              </p>
            </div>
          </div>

          <!-- Dishes -->
          <div class="p-4">
            <dish-container v-if="isReady" :restaurant-id="restaurantId" />
          </div>
        </div>

      </div>
    </div>
  </the-box>
</template>

<style scoped>
</style>
