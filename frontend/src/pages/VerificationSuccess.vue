<script setup>
import TheBox from "@/components/ui/TheBox.vue";
</script>

<template>
    <the-box>
      <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col items-center justify-center text-center">
          <!-- Checkmark Animation -->
          <div class="relative mb-8">
            <div class="flex items-center justify-center">
              <svg
                class="w-32 h-32 text-cgreen overflow-visible"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 120 115"
              >
                <path
                  fill="none"
                  stroke="currentColor"
                  stroke-width="8"
                  d="M107.332 72.938c-1.798 5.557 4.564 15.334 1.21 19.96-3.387 4.674-14.646 1.605-19.298 5.003-4.61 3.368-5.163 15.074-10.695 16.878-5.344 1.743-12.628-7.35-18.545-7.35-5.922 0-13.206 9.088-18.543 7.345-5.538-1.804-6.09-13.515-10.696-16.877-4.657-3.398-15.91-.334-19.297-5.002-3.356-4.627 3.006-14.404 1.208-19.962C10.93 67.576 0 63.442 0 57.5c0-5.943 10.93-10.076 12.668-15.438 1.798-5.557-4.564-15.334-1.21-19.96 3.387-4.674 14.646-1.605 19.298-5.003C35.366 13.73 35.92 2.025 41.45.22c5.344-1.743 12.628 7.35 18.545 7.35 5.922 0 13.206-9.088 18.543-7.345 5.538 1.804 6.09 13.515 10.696 16.877 4.657 3.398 15.91.334 19.297 5.002 3.356 4.627-3.006 14.404-1.208 19.962C109.07 47.424 120 51.562 120 57.5c0 5.943-10.93 10.076-12.668 15.438z"
                />
              </svg>
              <svg
                class="absolute w-12 h-12 text-cgreen overflow-visible"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 48 36"
              >
                <path
                  fill="none"
                  stroke="currentColor"
                  stroke-width="6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M47.248 3.9L43.906.667a2.428 2.428 0 0 0-3.344 0l-23.63 23.09-9.554-9.338a2.432 2.432 0 0 0-3.345 0L.692 17.654a2.236 2.236 0 0 0 .002 3.233l14.567 14.175c.926.894 2.42.894 3.342.01L47.248 7.128c.922-.89.922-2.34 0-3.23"
                />
              </svg>
            </div>
          </div>

          <!-- Text -->
          <div>
            <h3 class="text-2xl sm:text-3xl font-bold text-cgreen">
              Email Verification Successful
            </h3>
            <p class="mt-3 text-gray-600 max-w-md mx-auto">
              Your account has been successfully verified. You can now safely continue to the app.
            </p>
          </div>

          <!-- Button -->
          <div class="mt-8">
            <router-link
              :to="{name: 'login'}"
              class="inline-block bg-cgreen hover:bg-[#0B8C74] text-white font-medium px-6 py-2 rounded-lg shadow transition"
            >
              Go to Login
            </router-link>
          </div>
        </div>
      </div>
    </the-box>

</template>

<style scoped>

</style>
