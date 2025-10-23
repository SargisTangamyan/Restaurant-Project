<script setup>
// VUE
import {ref, onMounted, watch, computed} from 'vue'

// COMPONENTS
import DishBox from "@/components/dish/DishBox.vue";
import ThePagination from "@/components/ui/ThePagination.vue";
import TheLoader from "@/components/ui/TheLoader.vue";

// COMPOSABLES
import { useQueryFunctionality} from "@/composables/useQueryFunctionality.js";
const {writeQuery} = useQueryFunctionality();

// STORES
import {useDishStore, useCartStore} from "@/stores/index.js";

const dishStore = useDishStore();
const cartStore = useCartStore();

// ROUTE
import {useRoute} from "vue-router";

const route = useRoute();

// REF
const dishes = ref([]);
const isLoading = ref(true);

// COMPUTED
// Convert cart chosen IDs into a reactive Set for quick lookups
const cartIdSet = computed(() => new Set(cartStore.getChosenIds));
const pagination = computed(() => dishStore.getPagination)

// WATCH
watch(
  () => dishStore.getDishes,
  (newDishes) => {
    dishes.value = newDishes;
  }
);

// Watch only for page changes (filters are handled in FilterSidebar now)
watch(() => route.query.page, async (newPage, oldPage) => {
  if (newPage && newPage !== oldPage && newPage !== pagination.value.current_page) {
    isLoading.value = true;
    await dishStore.fetchDishes(route.query);
    isLoading.value = false;
    window.scrollTo({
      top: 0,
    });
  }
})

// METHODS
const changePage = (page) => {
  writeQuery('page', page);
}

// MOUNTING
onMounted(async () => {
  // Load dishes
  if (dishStore.getDishes?.length) {
    dishes.value = dishStore.getDishes;
  } else {
    const res = await dishStore.fetchDishes(route.query);
    if (res.success) {
      dishes.value = res.data;
    }
  }

  // Load cart
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

    <!-- No dishes found message -->
    <div v-else class="flex flex-col items-center justify-center py-10 text-gray-500">
      <p class="text-lg font-medium">No dishes found</p>
      <p class="text-sm">Try adjusting your filters or search.</p>
    </div>
  </div>
</template>

<style scoped>
</style>
