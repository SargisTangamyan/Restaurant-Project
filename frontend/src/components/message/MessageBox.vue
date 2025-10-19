<template>
  <transition name="modal-fade">
    <div
      v-if="visible"
      class="fixed inset-0 z-50 flex items-center justify-center bg-gray-200 bg-opacity-50 backdrop-blur-sm"
    >
      <div
        class="bg-white rounded-lg shadow-2xl p-6 w-11/12 max-w-md transform transition-all"
      >
        <div class="flex justify-between items-start mb-4">
          <h3 class="text-lg font-bold" :class="{'text-green-600': type === 'success', 'text-red-600': type === 'error', 'text-yellow-600': type === 'warning', 'text-blue-600': type === 'info'}">
            {{ getTitle(type) }}
          </h3>

          <button @click="closeMessage" class="text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <p class="text-gray-700 mb-6">
          {{ message }}
        </p>

        <div class="flex justify-end">
          <button
            @click="closeMessage"
            class="px-4 py-2 text-sm font-medium rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2"
            :class="{
              'bg-green-500 hover:bg-green-600 focus:ring-green-500': type === 'success',
              'bg-red-500 hover:bg-red-600 focus:ring-red-500': type === 'error',
              'bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-500': type === 'warning',
              'bg-blue-500 hover:bg-blue-600 focus:ring-blue-500': type === 'info',
            }"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { storeToRefs } from 'pinia';
import { useMessageStore } from '@/stores/message/index.js';

const messageStore = useMessageStore();
const { message, type, visible } = storeToRefs(messageStore);

// Function to close the message box by updating the store
const closeMessage = () => {
  messageStore.hideMessage();
};

// Helper function to provide a title based on the type
const getTitle = (type) => {
  switch (type) {
    case 'success':
      return 'Success!';
    case 'error':
      return 'Error!';
    case 'warning':
      return 'Warning';
    case 'info':
      return 'Information';
    default:
      return 'Notification';
  }
};

// To ensure the store has the necessary hideMessage function,
// make sure to add it to your useMessageStore (see notes below).
</script>

<style scoped>
/*
 * Transition styles for the modal box (optional, but makes it look professional)
 */

/* Entry and Exit for the entire backdrop/overlay */
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

/* You can add another transition for the modal content itself (scale/slide)
   by targeting the inner div, but the opacity transition is usually sufficient. */
</style>
