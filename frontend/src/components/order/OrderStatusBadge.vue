<script setup>
// VUE
import { computed } from 'vue';

const props = defineProps({
  status: {
    required: true,
    type: String,
  }
})

const statusConfig = {
  pending: {
    class: 'bg-yellow-100 text-yellow-800 border-yellow-200',
    label: 'Pending'
  },
  confirmed: {
    class: 'bg-blue-100 text-blue-800 border-blue-200',
    label: 'Confirmed'
  },
  preparing: {
    class: 'bg-purple-100 text-purple-800 border-purple-200',
    label: 'Preparing'
  },
  completed: {
    class: 'bg-green-100 text-green-800 border-green-200',
    label: 'Completed'
  },
  delivered: {
    class: 'bg-emerald-100 text-emerald-800 border-emerald-200',
    label: 'Delivered'
  },
  cancelled: {
    class: 'bg-red-100 text-red-800 border-red-200',
    label: 'Cancelled'
  }
};

const config = computed(() => statusConfig[props.status] || statusConfig.pending);

</script>

<template>
  <span
    :class="[
      'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border',
      config.class
    ]"
  >
    {{ config.label }}
  </span>
</template>
