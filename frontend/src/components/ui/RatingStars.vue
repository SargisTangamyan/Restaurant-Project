<script setup>

import { defineProps } from 'vue';

const props = defineProps({
  stars: {
    required: true,
    type: Number,
  }
});


const halfStar = !Number.isInteger(props.stars)

const completeStars = halfStar ? props.stars - 0.5 : props.stars;
const emptyStars = halfStar ? 4 - completeStars : 5 - completeStars;

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
