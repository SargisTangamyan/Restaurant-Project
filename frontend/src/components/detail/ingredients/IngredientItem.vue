<script setup>

// VUE
import {defineProps} from 'vue'

// PROPS
defineProps({
  ingredient: {
    required: true,
    type: Object
  }
})

</script>

<template>
  <div class="flex items-center gap-2 text-sm font-medium">
    <font-awesome-icon class="text-cgreen"
                       :class="{ 'text-red-600': ingredient.is_allergic }"
                       :icon="['fas', 'circle']" />
    <div>
      <span>{{ ingredient.name }}</span> - <span>{{ingredient.quantity}} {{ingredient.unit}}</span><span v-if="ingredient.is_allergic" class="text-red-600"> (Allergic!)</span>
    </div>
  </div>
</template>

<style scoped>

</style>
