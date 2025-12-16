<script setup>

// COMPONENTS
import PageName from "@/components/ui/PageName.vue";
import TheBox from "@/components/ui/TheBox.vue";
import FilterSidebar from "@/components/filter/FilterSidebar.vue"
import DishContainer from "@/components/dish/DishContainer.vue"

import restaurantBannerImage from "@/assets/images/restaurant/1.jpg"

const restaurantName = 'Saffron and Smoke'
</script>

<template>
  <page-name p-name="Menu"></page-name>
  <!-- Shop Section -->
  <the-box>
    <div class="container mx-auto py-2 lg:py-4">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <filter-sidebar />

        <!-- Main Content Placeholder -->
        <div class="bg-white col-start-2 col-span-3 rounded-2xl shadow-md text-gray-400 overflow-hidden">
          <!-- Restaurant Banner -->
          <div class="relative w-full h-44 sm:h-56 md:h-64 mb-4">
            <img
              :src="restaurantBannerImage"
              :alt="`${restaurantName} banner`"
              class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/35 to-transparent"></div>

            <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-6">
              <h2 class="text-white text-xl sm:text-2xl md:text-3xl font-bold leading-tight">
                {{ restaurantName }}
              </h2>
              <p class="text-white/90 text-sm sm:text-base mt-1">
                Menu
              </p>
            </div>
          </div>

          <!-- Main Content Placeholder -->
          <div class="bg-white col-start-2 col-span-3 rounded-2xl shadow-md text-gray-400 overflow-hidden">
            <dish-container />
          </div>
        </div>

      </div>
    </div>
  </the-box>

</template>

<style scoped>

</style>
