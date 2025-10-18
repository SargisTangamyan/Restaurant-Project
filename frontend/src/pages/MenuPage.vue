<script setup>

// COMPONENTS
import PageName from "@/components/ui/PageName.vue";
import TheBox from "@/components/ui/TheBox.vue";
import FilterSidebar from "@/components/filter/FilterSidebar.vue"
import DishContainer from "@/components/dish/DishContainer.vue"
import ImageBanner from "@/components/ui/image/ImageBanner.vue";

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
          <image-banner />
          <dish-container />
        </div>

      </div>
    </div>
  </the-box>

</template>

<style scoped>

</style>
