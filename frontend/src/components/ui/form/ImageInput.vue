<script setup>
import {ref, defineEmits} from 'vue';

// EMITS
const emit = defineEmits(['fileSelected']);

// 1. Reactive variable to hold the selected file's name
const fileName = ref('Click to select a photo');
const helperText = ref('PNG, JPG, or GIF (Max 10MB)');
const helperTextColor = ref('text-cgreen');

// 2. Function to update the file name when a file is selected
const handleFileUpload = (event) => {
  const fileInput = event.target;

  if (fileInput.files && fileInput.files.length > 0) {
    const file = fileInput.files[0];
    fileName.value = file.name;

    // emit the file
    emit('fileSelected', file);

    // Update helper text for successful selection
    helperText.value = 'File selected successfully!';
    helperTextColor.value = 'text-[#0B8C74]'; // Tailwind class for success color
  } else {
    // Reset if selection is cancelled
    fileName.value = 'Click to select a photo';
    helperText.value = 'PNG, JPG, or GIF (Max 10MB)';
    helperTextColor.value = 'text-cgreen';
  }
};
</script>

<template>
  <div
    class="max-w-md p-4 md:p-6 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">

    <input
      type="file"
      id="image-upload"
      name="image-upload"
      accept="image/*"
      class="hidden"
      @change="handleFileUpload"
    />

    <label
      for="image-upload"
      class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed rounded-lg cursor-pointer
           border-cgreen bg-indigo-50 text-cgreen
           hover:bg-indigo-100 hover:border-[#0B8C74] hover:text-[#0B8C74]
           transition-colors duration-200 ease-in-out"
    >
      <div class="text-center p-4">
        <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 014 4v2a4 4 0 01-4 4h-4a2 2 0 00-2 2v2m-2-4v4m0 0h4m-4 0h-4"></path>
        </svg>

        <p class="mt-2 text-sm font-semibold">
          {{ fileName }}
        </p>

        <p class="text-xs mt-1 transition-colors duration-200" :class="helperTextColor">
          {{ helperText }}
        </p>
      </div>
    </label>
  </div>
</template>

<style scoped>
</style>
