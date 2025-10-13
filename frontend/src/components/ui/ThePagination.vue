<script setup>

// VUE
import { defineEmits, defineProps } from "vue";

// EMITS
const emit = defineEmits(['moveTo']);

// PROPS
const props = defineProps({
  currentPage: {
    required: true,
    type: Number,
  },

  totalPages: {
    required: true,
    type: Number,
  },
})

// METHODS
const MovePage = function (to) {
  emit('moveTo', to);
}

</script>

<template>
  <!-- Pagination Wrapper -->
  <div class="flex flex-wrap items-center justify-center gap-2 mt-6">

    <!-- Previous Button -->
    <button
      class="px-3 py-1 rounded-lg border cursor-pointer border-gray-300 bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
      :disabled="props.currentPage === 1"
      @click="MovePage(props.currentPage - 1)"
    >
      Prev
    </button>

    <!-- Page Numbers -->
    <button
      v-for="page in props.totalPages"
      :key="page"
      class="px-3 py-1 rounded-lg border border-gray-300 "
      :class="page === currentPage ? 'bg-cgreen text-white border-cgreen' : 'bg-white text-gray-700 hover:bg-gray-100 cursor-pointer'"
      :disabled="props.currentPage === page"
      @click="MovePage(page)"
    >
      {{ page }}
    </button>

    <!-- Next Button -->
    <button
      class="px-3 py-1 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
      :disabled="props.currentPage === props.totalPages"
      @click="MovePage(props.currentPage + 1)"
    >
      Next
    </button>
  </div>

</template>

<style scoped>

</style>
