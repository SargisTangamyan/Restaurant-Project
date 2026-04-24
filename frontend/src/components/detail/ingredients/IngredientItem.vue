<script setup>
import { computed } from 'vue'

const props = defineProps({
  ingredient: {
    required: true,
    type: Object,
  },
  isPersonalAllergy: {
    type: Boolean,
    default: false,
  },
})

// personal allergy  → red
// generally allergic → amber
// safe               → green
const dotClass = computed(() => {
  if (props.isPersonalAllergy) return 'text-red-600'
  if (props.ingredient.is_allergic) return 'text-amber-400'
  return 'text-cgreen'
})

const label = computed(() => {
  if (props.isPersonalAllergy) return { text: 'Your allergy', class: 'text-red-600' }
  if (props.ingredient.is_allergic) return { text: 'May cause allergy', class: 'text-amber-500' }
  return null
})
</script>

<template>
  <div class="group flex items-center gap-2 text-sm font-medium">
    <!-- Dot indicator -->
    <font-awesome-icon :class="dotClass" :icon="['fas', 'circle']" />

    <!-- Ingredient text -->
    <div class="flex items-center gap-1">
      <span>{{ ingredient.name }}</span>
      -
      <span>{{ ingredient.quantity }} {{ ingredient.unit }}</span>

      <!-- Label + Modify button share the same space, no layout shift -->
      <div v-if="label" class="relative ml-1">
        <span :class="[label.class, 'text-xs group-hover:invisible']">
          ({{ label.text }})
        </span>
        <button class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-cgreen text-white text-xs px-2 py-0.5 rounded-sm w-20">
          Modify
        </button>
      </div>
    </div>
  </div>
</template>
