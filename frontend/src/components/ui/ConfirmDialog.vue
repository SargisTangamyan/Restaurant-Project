<script setup>
import { defineProps, defineEmits } from 'vue';

// Props
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: 'Confirm Action'
  },
  message: {
    type: String,
    required: true
  },
  confirmText: {
    type: String,
    default: 'Confirm'
  },
  cancelText: {
    type: String,
    default: 'Cancel'
  },
  type: {
    type: String,
    default: 'warning', // 'warning', 'danger', 'info'
    validator: (value) => ['warning', 'danger', 'info'].includes(value)
  },
  loading: {
    type: Boolean,
    default: false
  }
});

// Emits
const emits = defineEmits(['confirm', 'cancel']);

// Methods
const handleConfirm = () => {
  if (!props.loading) {
    emits('confirm');
  }
};

const handleCancel = () => {
  if (!props.loading) {
    emits('cancel');
  }
};

// Color schemes based on type
const getColorClasses = () => {
  const colors = {
    warning: {
      icon: 'text-yellow-600',
      bg: 'bg-yellow-50',
      border: 'border-yellow-200',
      button: 'bg-yellow-600 hover:bg-yellow-700'
    },
    danger: {
      icon: 'text-red-600',
      bg: 'bg-red-50',
      border: 'border-red-200',
      button: 'bg-red-600 hover:bg-red-700'
    },
    info: {
      icon: 'text-blue-600',
      bg: 'bg-blue-50',
      border: 'border-blue-200',
      button: 'bg-blue-600 hover:bg-blue-700'
    }
  };
  return colors[props.type] || colors.warning;
};
</script>

<template>
  <!-- Modal Overlay -->
  <transition name="modal">
    <div
      v-if="show"
      class="fixed inset-0 z-50 flex items-center justify-center bg-gray-200 bg-opacity-50 p-4"
      @click.self="handleCancel"
    >
      <!-- Modal Content -->
      <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-200">
          <div class="flex items-start gap-4">
            <!-- Icon -->
            <div
              class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center"
              :class="[getColorClasses().bg, getColorClasses().border, 'border-2']"
            >
              <svg
                v-if="type === 'danger' || type === 'warning'"
                class="w-6 h-6"
                :class="getColorClasses().icon"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                />
              </svg>
              <svg
                v-else
                class="w-6 h-6"
                :class="getColorClasses().icon"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>

            <!-- Title and Message -->
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-900 mb-2">
                {{ title }}
              </h3>
              <p class="text-sm text-gray-600">
                {{ message }}
              </p>
            </div>
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-6 flex justify-end gap-3 bg-gray-50 rounded-b-xl">
          <button
            type="button"
            @click="handleCancel"
            class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="loading"
          >
            {{ cancelText }}
          </button>
          <button
            type="button"
            @click="handleConfirm"
            class="px-4 py-2 text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            :class="getColorClasses().button"
            :disabled="loading"
          >
            <span v-if="loading" class="flex items-center gap-2">
              <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Processing...
            </span>
            <span v-else>{{ confirmText }}</span>
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
/* Modal transition animations */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active > div,
.modal-leave-active > div {
  transition: transform 0.3s ease;
}

.modal-enter-from > div,
.modal-leave-to > div {
  transform: scale(0.9);
}
</style>
