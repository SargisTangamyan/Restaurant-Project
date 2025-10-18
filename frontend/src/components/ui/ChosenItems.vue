<script setup>

import {defineProps, defineEmits} from 'vue'

// EMITS
const emit = defineEmits(['removeItem'])

const props = defineProps({
  items: {
    required: true,
    type: Object,
  }
})

// METHODS
const removeItem = (id) => {
  emit('removeItem', id)
}

</script>

<template>
  <ul class="space-y-2 text-gray-700 flex flex-wrap gap-2 mt-2">
    <li v-for="[id, name] in Object.entries(props.items)" :key="id">
      <button
        @click="removeItem(id)"
         class="block bg-gray-100 py-1 px-2 rounded-md text-sm hover:text-red-400 transition">
        <span class="mr-2">{{ name }}</span>
        <font-awesome-icon :icon="['fas', 'xmark']"/>
      </button>
    </li>
  </ul>
</template>

<style scoped>

</style>
