<script setup>

// COMPONENTS
import TheBox from "@/components/ui/TheBox.vue";

</script>

<template>
  <!-- 404 Section Start -->
  <the-box>
    <div class="flex flex-col items-center justify-center h-fit bg-gray-50 text-center p-6">
      <div class="max-w-2xl flex flex-col justify-center items-center">
        <div class="mb-8">
          <img
            src="../assets/images/inner-page/404.png"
            alt="Page Not Found"
            class="mx-auto w-80 max-w-full drop-shadow-lg"
          />
        </div>

        <h1 class="text-4xl font-bold text-gray-800 mb-4">Page Not Found</h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
          The page you are looking for could not be found. The link to this address may be outdated
          or
          we may have moved the page since you last bookmarked it.
        </p>

        <router-link
          :to="{name: 'home'}"
          class="button-cgreen"
        >
          Back To Home
        </router-link>

      </div>
    </div>
  </the-box>
  <!-- 404 Section End -->


</template>

<style scoped>

</style>
