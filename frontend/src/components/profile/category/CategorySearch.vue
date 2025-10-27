<script setup>
import { defineEmits, defineProps, onMounted } from 'vue';
import ErrorMessage from '@/components/ui/form/ErrorMessage.vue';
import FormLabel from '@/components/ui/form/FormLabel.vue';
import { useSearchStrict } from '@/composables/useSearchStrict.js';
import { useCategoryStore } from '@/stores/index.js';

// Props
const props = defineProps({
  disabled: {
    type: Boolean,
    default: false
  },
  label: {
    type: String,
    default: 'Parent Category'
  },
  placeholder: {
    type: String,
    default: 'e.g. Desserts'
  }
});

// Emits
const emits = defineEmits(['wordChosen', 'incorrectWord']);

// Store
const categoryStore = useCategoryStore();

// Composable
const {
  query,
  filteredItems: filteredCategories,
  message,
  onInput,
  selectItem: selectCategory,
  clearQuery,
  init
} = useSearchStrict({
  searchFn: categoryStore.searchCategories,
  queryParam: 'parent',
  jsonName: 'foundCategories',
  emitWordChosen: (id, name) => {
    emits('wordChosen', id, name);
  },
  emitIncorrectWord: () => {
    emits('incorrectWord');
  },
});

// Lifecycle
onMounted(() => {
  init();
});

// Expose methods
defineExpose({ clearQuery });
</script>

<template>
  <div class="relative">
    <form-label :label="props.label" />

    <input
      type="text"
      v-model="query"
      @input="onInput"
      :placeholder="props.placeholder"
      :disabled="props.disabled"
      class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-600 disabled:bg-gray-100 disabled:cursor-not-allowed transition-all"
    />

    <error-message v-if="message" :message="message" />

    <!-- Dropdown Results -->
    <ul
      v-if="filteredCategories.length && !props.disabled"
      class="absolute z-10 bg-white border border-gray-300 mt-1 w-full rounded-lg max-h-48 overflow-auto shadow-lg"
    >
      <li
        v-for="category in filteredCategories"
        :key="category.id"
        @click="selectCategory(category)"
        class="p-3 hover:bg-green-50 cursor-pointer transition-colors border-b last:border-b-0"
      >
        <div class="font-medium text-gray-800">{{ category.name }}</div>
        <div v-if="category.parent_name" class="text-xs text-gray-500 mt-1">
          Parent: {{ category.parent_name }}
        </div>
      </li>
    </ul>

    <!-- Clear button -->
    <button
      v-if="query && !props.disabled"
      @click.prevent="clearQuery"
      type="button"
      class="absolute right-2 top-9 text-gray-400 hover:text-gray-600 transition-colors"
      title="Clear selection"
    >
      ✕
    </button>
  </div>
</template>

<style scoped>
/* Custom scrollbar for dropdown */
ul::-webkit-scrollbar {
  width: 8px;
}

ul::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 0 0 8px 0;
}

ul::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 4px;
}

ul::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
