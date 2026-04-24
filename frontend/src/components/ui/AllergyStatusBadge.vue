<script setup>
defineProps({
  status: {
    type: String,
    default: null,
    validator: (v) => v === null || ['safe', 'modify', 'avoid'].includes(v),
  },
})

const STATUS_MAP = {
  safe:   { label: 'Safe',   class: 'bg-green-500' },
  modify: { label: 'Modify', class: 'bg-amber-400' },
  avoid:  { label: 'Avoid',  class: 'bg-red-500'   },
}
</script>

<template>
  <div
    v-if="status && STATUS_MAP[status]"
    class="text-white w-fit px-3 py-1 rounded-md"
    :class="STATUS_MAP[status].class"
  >
    {{ STATUS_MAP[status].label }}
  </div>
</template>
