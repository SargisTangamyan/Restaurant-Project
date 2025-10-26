<script setup>

// VUE
import {computed} from 'vue'

// EMIT
const emit = defineEmits(['update-status']);

// PROPS
const props = defineProps({
  orderId: {
    type: Number,
    required: true,
  },
  currentStatus: {
    type: String,
    required: true,
  },
  loading: {
    type: Boolean,
    default: false
  }
});

// CONSTANT DATA
const statusFlow = {
  pending: [
    { value: 'confirmed', label: 'Confirm Order', class: 'bg-blue-600 hover:bg-blue-700' },
    { value: 'cancelled', label: 'Cancel', class: 'bg-red-600 hover:bg-red-700' }
  ],
  confirmed: [
    { value: 'preparing', label: 'Start Preparing', class: 'bg-purple-600 hover:bg-purple-700' },
    { value: 'cancelled', label: 'Cancel', class: 'bg-red-600 hover:bg-red-700' }
  ],
  preparing: [
    { value: 'completed', label: 'Mark Completed', class: 'bg-green-600 hover:bg-green-700' },
    { value: 'cancelled', label: 'Cancel', class: 'bg-red-600 hover:bg-red-700' }
  ],
  completed: [
    { value: 'delivered', label: 'Mark Delivered', class: 'bg-emerald-600 hover:bg-emerald-700' }
  ],
  delivered: [],
  cancelled: []
};

// COMPUTED
const availableActions = computed(() => statusFlow[props.currentStatus] || []);

// METHODS
const handleStatusChange = (newStatus) => {
  emit('update-status', newStatus);
}

</script>

<template>
  <div v-if="availableActions.length > 0" class="flex flex-wrap gap-2">
    <button
    v-for="action in availableActions"
    :key="action.value"
    @click="handleStatusChange(action.value)"
    :disabled="loading"
    :class="[
      'px-4 py-2 rounded-lg text-sm font-medium text-white transition-all duration-200',
      action.class,
      loading ? 'opacity-50 cursor-not-allowed': ''
    ]"
    >
      {{ loading ? 'Updating...' : action.label }}
    </button>
  </div>
  <p v-else class="text-sm text-gray-500 italic">No actions available for this status</p>
</template>
