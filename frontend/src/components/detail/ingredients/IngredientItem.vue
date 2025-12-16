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
  <div class="group flex items-center gap-2 text-sm font-medium">
    <!-- Icon -->
    <font-awesome-icon
      class="text-cgreen"
      :class="{ 'text-red-600': ingredient.is_allergic }"
      :icon="['fas', 'circle']"
    />

    <!-- Ingredient text -->
    <div>
      <span>{{ ingredient.name }}</span>
      -
      <span>{{ ingredient.quantity }} {{ ingredient.unit }}</span>

      <!-- Allergic label (visible by default, hidden on hover) -->
      <span
        v-if="ingredient.is_allergic"
        class="ml-1 text-red-600 group-hover:hidden"
      >
        (Allergic!)
      </span>
    </div>

    <!-- Modify button (hidden by default, shown on hover) -->
    <button
      v-if="ingredient.is_allergic"
      class="hidden group-hover:block bg-cgreen text-white text-xs px-2 py-0.5 rounded-sm"
    >
      Modify
    </button>
  </div>
</template>

<style scoped>

</style>
