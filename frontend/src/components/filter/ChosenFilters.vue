<script setup>

import {defineProps} from 'vue'

const emit = defineEmits(['removeFilter']);

const props = defineProps({
  filters: {
    required: true,
    type: Array,
  }
})

// METHODS
const removeItem = (id, type) => {
  emit('removeFilter', {id, type})
}

</script>

<template>
  <ul class="space-y-2 text-gray-700 flex flex-wrap gap-2">
    <li v-for="{id, name, type} in props.filters" :key="id">
      <button
        @click="removeItem(id, type)"
         class="block bg-gray-100 py-1 px-2 rounded-md text-sm hover:text-red-400 transition">
        <span class="mr-2">{{ name }}</span>
        <font-awesome-icon :icon="['fas', 'xmark']"/>
      </button>
    </li>
  </ul>
</template>

<style scoped>

</style>
