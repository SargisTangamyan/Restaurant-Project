<script setup>
// VUE
import {defineProps, ref, onMounted, watch } from 'vue'

// DEBOUNCE
import debounce from "lodash/debounce";

// ROUTER
import { useRoute, useRouter } from 'vue-router'
const route = useRoute()
const router = useRouter()

// PROPS
const props = defineProps({
  maxPrice: {
    type: Number,
    required: true,
  }
})

// Simple
const initialPrice = Math.round(props.maxPrice)

// REFS
const currentPrice = ref(initialPrice);

// METHODS
const filterPrice = debounce(() => {
  router.replace({
    query: { ...route.query, price: currentPrice.value || undefined }
  });
}, 300);

// WATCH
watch(() => route.query.price, () => {
  if (!route.query.price) {
    currentPrice.value = initialPrice;
  } else {
    currentPrice.value = Number(route.query.price);
  }
});

// MOUNTING
onMounted(() => {
  if (route.query.price) {
    currentPrice.value = Number(route.query.price);
  }
});

</script>

<template>
  <div class="mt-2 relative w-full">
    <!-- floating label -->
    <input v-model="currentPrice" @change="filterPrice" type="range" min="0" :max="props.maxPrice"
           class="w-full accent-[#0DA487]">
    <div>
      Value: <span class="text-cgreen">{{currentPrice}}$</span>
    </div>
  </div>
</template>

<style scoped>

</style>
