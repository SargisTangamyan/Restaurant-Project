<script setup>

import ToggleFilter from "@/components/ui/ToggleFilter.vue";
import FilterBox from "@/components/filter/FilterBox.vue";
import UnderlinedText from "@/components/ui/UnderlinedText.vue";
import ChosenFilters from "@/components/filter/ChosenFilters.vue";
import PriceRange from "@/components/ui/form/PriceRange.vue";
</script>

<template>
  <!-- Sidebar -->
  <aside class="sticky top-4 bg-white pr-6 border-r lg:col-span-1 border-gray-200">
    <!-- Filter Header -->
    <filter-box>
      <template #header>
        <underlined-text name="Filters"></underlined-text>
        <button class="text-sm text-cgreen hover:underline">Clear All</button>
      </template>
      <template #default>
        <!-- Filter List -->
        <chosen-filters :filters="['vegetables', 'Fruits', 'Milk', 'Meat']"/>
      </template>
    </filter-box>

    <toggle-filter
      name="Category"
      :filters="[
              {name: 'Fruits & Vegetables', count: 15},
              {name: 'Fruits & Vegetables', count: 15},
              {name: 'Fruits & Vegetables', count: 15},
            ]"
    ></toggle-filter>

    <toggle-filter
      name="Ingredients"
      :filters="[
              {name: 'Fish', count: 15},
              {name: 'Meat', count: 15},
              {name: 'Orange', count: 15},
              {name: 'Apple', count: 15},
            ]"
    ></toggle-filter>

    <filter-box>
      <template #header>
        <underlined-text name="Price"></underlined-text>
      </template>
      <template #default>
        <price-range :max-price="100"></price-range>
      </template>
    </filter-box>

    <!-- Rating -->
    <div class="py-4">
      <button
        class="w-full flex justify-between items-center text-left font-semibold text-gray-800">
        <span>Rating</span>
        <i class="fa-solid fa-chevron-down text-sm"></i>
      </button>
      <div class="mt-3 space-y-3">
        <label class="flex items-center space-x-2">
          <input type="checkbox" class="rounded text-green-600 focus:ring-green-500">
          <span class="text-yellow-500">★★★★★</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="checkbox" class="rounded text-green-600 focus:ring-green-500">
          <span class="text-yellow-500">★★★★☆</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="checkbox" class="rounded text-green-600 focus:ring-green-500">
          <span class="text-yellow-500">★★★☆☆</span>
        </label>
      </div>
    </div>

  </aside>
</template>

<style scoped>

</style>
