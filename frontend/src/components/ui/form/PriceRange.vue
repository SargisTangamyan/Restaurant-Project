
<script setup>
// VUE
import { defineProps, ref, onMounted, watch } from 'vue'

// DEBOUNCE
import debounce from "lodash/debounce";

// ROUTER
import { useRoute, useRouter } from 'vue-router'
const route = useRoute()
const router = useRouter()

// PROPS
const props = defineProps({
  minPrice: {
    type: Number,
    default: 0,
  },
  maxPrice: {
    type: Number,
    required: true,
  }
})

// REFS
const currentMinPrice = ref(props.minPrice);
const currentMaxPrice = ref(props.maxPrice);

// METHODS
const filterPrice = debounce(() => {
  router.replace({
    query: {
      ...route.query,
      min_price: currentMinPrice.value > props.minPrice ? currentMinPrice.value : undefined,
      max_price: currentMaxPrice.value < props.maxPrice ? currentMaxPrice.value : undefined,
      // Remove old 'price' param if exists
      price: undefined,
    }
  });
}, 300);

// WATCH
watch(() => [route.query.min_price, route.query.max_price], () => {
  if (!route.query.min_price) {
    currentMinPrice.value = props.minPrice;
  } else {
    currentMinPrice.value = Number(route.query.min_price);
  }

  if (!route.query.max_price) {
    currentMaxPrice.value = props.maxPrice;
  } else {
    currentMaxPrice.value = Number(route.query.max_price);
  }
});

// MOUNTING
onMounted(() => {
  if (route.query.min_price) {
    currentMinPrice.value = Number(route.query.min_price);
  }
  if (route.query.max_price) {
    currentMaxPrice.value = Number(route.query.max_price);
  }
});

</script>

<template>
  <div class="mt-2 space-y-3">
    <!-- Min Price -->
    <div>
      <label class="text-sm text-gray-600 mb-1 block">Min Price</label>
      <input
        v-model="currentMinPrice"
        @input="filterPrice"
        type="range"
        :min="props.minPrice"
        :max="currentMaxPrice"
        class="w-full accent-[#0DA487]"
      >
      <div class="text-sm">
        <span class="text-cgreen font-semibold">{{ currentMinPrice }}$</span>
      </div>
    </div>

    <!-- Max Price -->
    <div>
      <label class="text-sm text-gray-600 mb-1 block">Max Price</label>
      <input
        v-model="currentMaxPrice"
        @input="filterPrice"
        type="range"
        :min="currentMinPrice"
        :max="props.maxPrice"
        class="w-full accent-[#0DA487]"
      >
      <div class="text-sm">
        <span class="text-cgreen font-semibold">{{ currentMaxPrice }}$</span>
      </div>
    </div>

    <!-- Range Display -->
    <div class="pt-2 text-center text-sm font-medium text-gray-700">
      Range: <span class="text-cgreen">{{ currentMinPrice }}$ - {{ currentMaxPrice }}$</span>
    </div>
  </div>
</template>

<style scoped>
</style>
