<script setup>
// VUE
import { ref, onMounted, watch, computed } from 'vue'

// COMPONENTS
import DishBox from "@/components/dish/DishBox.vue";
import ThePagination from "@/components/ui/ThePagination.vue";
import TheLoader from "@/components/ui/TheLoader.vue";

// COMPOSABLES
import { useQueryFunctionality } from "@/composables/useQueryFunctionality.js";
const { writeQuery } = useQueryFunctionality();

// STORES
import { useDishStore, useCartStore } from "@/stores/index.js";

const dishStore = useDishStore();
const cartStore = useCartStore();

// ROUTE
import { useRoute } from "vue-router";
const route = useRoute();

// PROPS
const props = defineProps({
  restaurantId: {
    type: [Number, String],
    default: null,
  },
});

// REF
const dishes = ref([]);
const isLoading = ref(true);

// COMPUTED
const cartIdSet = computed(() => new Set(cartStore.getChosenIds));
const pagination = computed(() => dishStore.getPagination);

const buildFilters = () => {
  const filters = { ...route.query };
  if (props.restaurantId) {
    filters.restaurant_id = props.restaurantId;
  }
  return filters;
};

// WATCH
watch(
  () => dishStore.getDishes,
  (newDishes) => {
    dishes.value = newDishes;
  }
);

watch(
  () => [route.query, props.restaurantId],
  async () => {
    isLoading.value = true;
    await dishStore.fetchDishes(buildFilters());
    isLoading.value = false;
    window.scrollTo({ top: 0 });
  }
);

// METHODS
const changePage = (page) => {
  writeQuery('page', page);
};

// MOUNTING
onMounted(async () => {
  const res = await dishStore.fetchDishes(buildFilters());
  if (res.success) {
    dishes.value = res.data;
  }

  if (!cartStore.getIsLoaded) {
    await cartStore.fetchCart();
  }

  isLoading.value = false;
});
</script>

<template>
  <the-loader v-if="isLoading" />

  <div v-else>
    <div v-if="dishes.length > 0">
      <div
        class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-6"
      >
        <DishBox
          v-for="dish in dishes"
          :key="dish.id"
          :dish="dish"
          :isInCart="cartIdSet.has(+dish.id)"
          @toggle-cart="cartStore.addToCart(dish.id)"
        />
      </div>

      <div class="pb-4">
        <the-pagination
          v-show="pagination.total !== 0"
          :total-pages="pagination.last_page"
          :current-page="pagination.current_page"
          @move-to="changePage"
        />
      </div>
    </div>

    <div v-else class="flex flex-col items-center justify-center py-10 text-gray-500">
      <p class="text-lg font-medium">No dishes found</p>
      <p class="text-sm">Try adjusting your filters or search.</p>
    </div>
  </div>
</template>

<style scoped>
</style>