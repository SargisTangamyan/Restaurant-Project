<script setup>

import { computed } from 'vue';

const props = defineProps({
  stars: {
    required: true,
    type: Number,
  }
});

function roundToHalf(num) {
  return Math.round(num * 2) / 2;
}

const stars = computed(() => roundToHalf(props.stars));

const halfStar = computed(() => !Number.isInteger(stars.value));

const completeStars = computed(() =>
  halfStar.value ? stars.value - 0.5 : stars.value
);

const emptyStars = computed(() =>
  halfStar.value ? 4 - completeStars.value : 5 - completeStars.value
);

</script>

<template>
  <ul class="flex text-yellow-400">
    <font-awesome-icon v-for="n in completeStars" :key="n" class="w-4 h-4" :icon="['fas', 'star']"/>
    <font-awesome-icon v-if="halfStar" class="w-4 h-4" :icon="['fas', 'star-half-stroke']"/>
    <font-awesome-icon v-for="i in emptyStars" :key="completeStars + i" class="w-4 h-4 text-gray-400" :icon="['fas', 'star']"/>
  </ul>
</template>

<style scoped>

</style>
