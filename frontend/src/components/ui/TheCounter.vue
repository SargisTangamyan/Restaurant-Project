<script setup>

import { ref } from 'vue'

const count = ref(1)

const changeCounterBy = (number) => {
  count.value += number
  if (count.value < 1) {
    count.value = 1;
  }
}

</script>

<template>
  <div class="flex flex-col sm:flex-row gap-3">
    <div class="flex items-center border rounded-lg overflow-hidden w-fit">
      <button @click="changeCounterBy(-1)" class="px-3 py-2 cursor-pointer"><font-awesome-icon :icon="['fas', 'minus']"/></button>
      <input type="text" :value="count" class="w-12 text-center border-x border-gray-200">
      <button @click="changeCounterBy(1)" class="px-3 py-2 cursor-pointer"><font-awesome-icon :icon="['fas', 'plus']"/></button>
    </div>
  </div>
</template>

<style scoped>

</style>
