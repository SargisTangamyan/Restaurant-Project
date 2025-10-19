<script setup>
// VUE
import {defineProps, ref, onMounted } from 'vue'

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

// REFS
const currentPrice = ref(Math.round(props.maxPrice));

// METHODS
const filterPrice = debounce(() => {
  router.replace({
    query: { ...route.query, price: currentPrice.value || undefined }
  });
}, 300);

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
