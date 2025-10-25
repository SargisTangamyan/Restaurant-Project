<script setup>
// VUE
import { ref, watch } from 'vue'

// COMPONENTS
import FilterBox from "@/components/filter/FilterBox.vue";
import UnderlinedText from "@/components/ui/UnderlinedText.vue";
import ChosenFilters from "@/components/filter/ChosenFilters.vue";
import PriceRange from "@/components/ui/form/PriceRange.vue";
import IngredientFilter from "@/components/filter/IngredientFilter.vue";
import CategoryFilter from "@/components/filter/CategoryFilter.vue";
import SortBy from "@/components/filter/SortBy.vue";

// ROUTE AND ROUTER
import {useRoute, useRouter} from 'vue-router'
const route = useRoute();
const router = useRouter();

// STORE
import {useDishStore} from '@/stores/index.js'
const dishStore = useDishStore();

// REF
const filters = ref([]);

// METHODS
const addFilter = (filter) => {
  filters.value.push(filter)
  let query = filter.id;

  if (route.query[filter.type])
  {
    query = route.query[filter.type] + `,${query}`;
  }

  router.replace({
    query: {
      ...route.query,
      [filter.type] : query,
    }
  })
}

const removeFilter = (filter) => {
  filters.value = filters.value.filter(el => el.type !== filter.type || el.id !== filter.id);

  let ending = undefined;

  if(route.query[filter.type].includes(','))
  {
    const nums = route.query[filter.type].split(',');
    ending = nums.reduce((acc, cur) => {
      if (Number(cur) !== Number(filter.id))
      {
        return acc + ',' + cur;
      }
      return acc;
    })
  }

  router.replace({
    query: {
      ...route.query,
      [filter.type] : ending,
    }
  })
}

const clearFilters = function () {
  const search = route.query.search;
  filters.value = [];
  router.replace({
    query: {
      search,
    }
  })
}

// WATCH - Auto-fetch dishes when query changes
watch(() => route.query, async (newQuery, oldQuery) => {
  // Check if filter-related queries have changed (excluding page changes)
  const filterKeys = ['categories', 'ingredients', 'min_price', 'max_price', 'price', 'sort_by', 'sort_direction'];
  const hasFilterChanged = filterKeys.some(key => newQuery[key] !== oldQuery[key]);

  if (hasFilterChanged) {
    await dishStore.fetchDishes(newQuery);
  }
}, { deep: true });

</script>

<template>
  <!-- Sidebar -->
  <aside class="w-full lg:w-auto lg:sticky lg:top-4 self-start flex-none bg-white pr-6 border-r border-gray-200">
    <!-- Filter Header -->
    <filter-box>
      <template #header>
        <underlined-text name="Filters"></underlined-text>
        <button @click="clearFilters" class="text-sm text-cgreen hover:underline">Clear All</button>
      </template>
      <template #default>
        <!-- Filter List -->
        <chosen-filters :filters="filters" @remove-filter="removeFilter"/>
      </template>
    </filter-box>

    <!-- Sort By -->
    <sort-by />

    <category-filter @add-filter="addFilter" @remove-filter="removeFilter" />

    <ingredient-filter @add-filter="addFilter" @remove-filter="removeFilter" />

    <filter-box>
      <template #header>
        <underlined-text name="Price"></underlined-text>
      </template>
      <template #default>
        <price-range :min-price="0" :max-price="100"></price-range>
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
