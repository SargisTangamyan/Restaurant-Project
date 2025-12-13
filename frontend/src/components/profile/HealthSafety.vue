<script setup>

</script>

<template>
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Health & Safety</h2>

    <!-- Doctor's Notes Upload -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Doctor's Notes
      </label>

      <!-- Uploaded file preview (static mockup) -->
      <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-2">
          <i class="fas fa-file-medical text-green-600"></i>
          <span class="text-sm text-gray-700">Doctor notes uploaded</span>
        </div>
        <div class="flex gap-2">
          <a
            href="#"
            class="text-sm text-blue-600 hover:underline"
          >
            View
          </a>
          <button class="text-sm text-red-600 hover:underline">
            Remove
          </button>
        </div>
      </div>

      <!-- File upload mockup -->
      <div class="flex items-center gap-3">
        <input
          type="file"
          class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        />
        <button
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
        >
          Upload
        </button>
      </div>
      <p class="text-xs text-gray-500 mt-1">
        Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max 5MB)
      </p>
    </div>

    <form>
      <!-- Allergic Ingredients -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Allergic Ingredients
        </label>
        <textarea
          rows="3"
          placeholder="List ingredients you are allergic to (e.g., peanuts, shellfish, dairy)"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        ></textarea>

        <!-- Error text mock -->
        <span class="text-red-500 text-sm">
        This field is required.
      </span>
      </div>

      <!-- Emergency Number -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Emergency Contact Number
        </label>
        <input
          type="tel"
          placeholder="+1 234 567 8900"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
        />

        <!-- Error text mock -->
        <span class="text-red-500 text-sm">
        Invalid phone number.
      </span>
      </div>

      <div>
        <button
          type="submit"
          class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
        >
          Save Changes
        </button>
      </div>
    </form>
  </div>
</template>

<style scoped>

</style>
