<script setup>
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
import { useRoute, useRouter } from 'vue-router'
const route = useRoute();
const router = useRouter();

// STORE
import { useDishStore } from '@/stores/index.js'
const dishStore = useDishStore();

// PROPS / EMITS
const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  }
})
const emit = defineEmits(['close'])

// Lock body scroll when drawer is open
watch(() => props.isOpen, (val) => {
  document.body.style.overflow = val ? 'hidden' : ''
})

// FILTER STATE
const filters = ref([]);

const addFilter = (filter) => {
  filters.value.push(filter)
  let query = filter.id;

  if (route.query[filter.type]) {
    query = route.query[filter.type] + `,${query}`;
  }

  router.replace({
    query: {
      ...route.query,
      [filter.type]: query,
    }
  })
}

const removeFilter = (filter) => {
  filters.value = filters.value.filter(el => el.type !== filter.type || el.id !== filter.id);

  let ending = undefined;

  if (route.query[filter.type]?.includes(',')) {
    const nums = route.query[filter.type].split(',');
    ending = nums.reduce((acc, cur) => {
      if (Number(cur) !== Number(filter.id)) {
        return acc + ',' + cur;
      }
      return acc;
    })
  }

  router.replace({
    query: {
      ...route.query,
      [filter.type]: ending,
    }
  })
}

const clearFilters = () => {
  const search = route.query.search;
  filters.value = [];
  router.replace({ query: { search } })
}

// WATCH - Auto-fetch when query changes
watch(() => route.query, async (newQuery, oldQuery) => {
  const filterKeys = ['categories', 'ingredients', 'min_price', 'max_price', 'price', 'sort_by', 'sort_direction'];
  const hasFilterChanged = filterKeys.some(key => newQuery[key] !== oldQuery[key]);
  if (hasFilterChanged) {
    await dishStore.fetchDishes(newQuery);
  }
}, { deep: true });
</script>

<template>
  <!-- Backdrop (teleported — mobile only, sits behind the drawer) -->
  <teleport to="body">
    <transition name="fade">
      <div
        v-if="props.isOpen"
        class="fixed inset-0 z-40 bg-black/50"
        @click="emit('close')"
      />
    </transition>
  </teleport>

  <!-- Sidebar / Drawer -->
  <aside class="filter-sidebar" :class="{ 'drawer-open': props.isOpen }">

    <!-- Drawer header: close button, visible only on mobile -->
    <div class="drawer-header">
      <span class="font-bold text-lg text-gray-800">Filters</span>
      <button
        @click="emit('close')"
        class="p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors"
        aria-label="Close filters"
      >
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
        </svg>
      </button>
    </div>

    <!-- Scrollable filter content -->
    <div class="sidebar-body">

      <filter-box>
        <template #header>
          <underlined-text name="Filters"></underlined-text>
          <button @click="clearFilters" class="text-sm text-cgreen hover:underline">Clear All</button>
        </template>
        <template #default>
          <chosen-filters :filters="filters" @remove-filter="removeFilter" />
        </template>
      </filter-box>

      <sort-by />

      <category-filter @add-filter="addFilter" @remove-filter="removeFilter" />

      <ingredient-filter @add-filter="addFilter" @remove-filter="removeFilter" />

      <filter-box>
        <template #header>
          <underlined-text name="Price"></underlined-text>
        </template>
        <template #default>
          <price-range :min-price="0" :max-price="100" />
        </template>
      </filter-box>

      <div class="py-4">
        <button class="w-full flex justify-between items-center text-left font-semibold text-gray-800">
          <span>Rating</span>
          <i class="fa-solid fa-chevron-down text-sm"></i>
        </button>
        <div class="mt-3 space-y-3">
          <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" class="rounded text-green-600 focus:ring-green-500">
            <span class="text-yellow-500">★★★★★</span>
          </label>
          <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" class="rounded text-green-600 focus:ring-green-500">
            <span class="text-yellow-500">★★★★☆</span>
          </label>
          <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" class="rounded text-green-600 focus:ring-green-500">
            <span class="text-yellow-500">★★★☆☆</span>
          </label>
        </div>
      </div>

    </div>
  </aside>
</template>

<style scoped>

/* ── Desktop: sticky sidebar in grid column 1 ──────── */
.filter-sidebar {
  background: #fff;
  align-self: flex-start;
  position: sticky;
  top: 1rem;
  padding-right: 1.5rem;
  border-right: 1px solid #e5e7eb;
}

.drawer-header {
  display: none;
}

.sidebar-body {
  /* no special styles needed on desktop */
}

/* ── Mobile: slide-in drawer ───────────────────────── */
@media (max-width: 1023px) {
  .filter-sidebar {
    position: fixed;
    inset: 0 auto 0 0;       /* top:0 right:auto bottom:0 left:0 */
    width: 300px;
    max-width: 85vw;
    z-index: 50;
    padding: 0;
    border-right: none;
    box-shadow: 6px 0 28px rgba(0, 0, 0, 0.18);
    transform: translateX(-100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  .filter-sidebar.drawer-open {
    transform: translateX(0);
  }

  .drawer-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e5e7eb;
    background: #fff;
    flex-shrink: 0;
  }

  .sidebar-body {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 1.25rem;
  }
}

/* ── Backdrop transition ───────────────────────────── */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

</style>