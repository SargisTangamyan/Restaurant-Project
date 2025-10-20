<script setup>
import { useIngredientStore } from '@/stores';
import { useFilterLoader } from '@/composables/useFilterLoader.js';
import ToggleFilter from '@/components/filter/ToggleFilter.vue';
import FilterSearch from '@/components/search/FilterSearch.vue';
import FilterList from '@/components/filter/FilterList.vue';

const emits = defineEmits(['addFilter', 'removeFilter']);
const store = useIngredientStore();

const type= 'ingredients';

const { items: ingredients, loadNext, addItem, removeItem } = useFilterLoader(
  store,
  store.fetchIngredients,
  () => store.getIngredients,
  () => store.getPagination,
  emits,
  type
);
</script>

<template>
  <toggle-filter name="Ingredients">
    <filter-search />
    <filter-list
      :type="type"
      :filters="ingredients"
      @reached-end="loadNext"
      @add-filter="addItem"
      @remove-filter="removeItem"
    />
  </toggle-filter>
</template>
