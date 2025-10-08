<script setup>

import {defineProps} from 'vue'

const props = defineProps({
  filters: {
    required: true,
    type: Array,
  }
})

</script>

<template>
  <ul class="space-y-2 text-gray-700 flex flex-wrap gap-2">
    <li v-for="(filter, id) in props.filters" :key="id">
      <a href="#"
         class="block bg-gray-100 py-1 px-2 rounded-md text-sm hover:text-red-400 transition">
        <span class="mr-2">{{ filter }}</span>
        <font-awesome-icon :icon="['fas', 'xmark']"/>
      </a>
    </li>
  </ul>
</template>

<style scoped>

</style>
