<script setup>
import { useCategoryStore } from '@/stores';
import { useFilterLoader } from '@/composables/useFilterLoader.js';
import ToggleFilter from '@/components/filter/ToggleFilter.vue';
import FilterSearch from '@/components/search/FilterSearch.vue';
import FilterList from '@/components/filter/FilterList.vue';

const emits = defineEmits(['addFilter', 'removeFilter']);
const store = useCategoryStore();
const type = 'categories';

const { items: categories, loadNext, addItem, removeItem } = useFilterLoader(
  store,
  store.fetchCategories,
  () => store.getCategories,
  () => store.getPagination,
  emits,
  type
);
</script>

<template>
  <toggle-filter name="Categories">
    <filter-search />
    <filter-list
      :type="type"
      :filters="categories"
      @reached-end="loadNext"
      @add-filter="addItem"
      @remove-filter="removeItem"
    />
  </toggle-filter>
</template>
