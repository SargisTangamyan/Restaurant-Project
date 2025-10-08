<script setup>

// COMPONENTS
import TheBox from "@/components/ui/TheBox.vue";

</script>

<template>
  <footer class="w-full bg-gray-50 border-t border-gray-200 py-6 mt-8">
    <the-box :mb="false">
      <div
        class="container flex flex-col md:flex-row items-center justify-between">
        <p class="text-gray-600 text-sm">
          &copy; {{ new Date().getFullYear() }} <span class="text-cgreen font-semibold">Restaurant Project</span>.
          Here could have been a very beautiful footer.
        </p>

        <div class="flex items-center justify-center gap-5 mt-4 md:mt-0">
          <p class="text-cgreen">Follow us on</p>
          <a href="#" class="text-gray-500 hover:text-[#0DA487] transition-colors">
            <img src="../../assets/images/inner-page/facebook.png" alt="Facebook" class="w-5 h-5">
          </a>
          <a href="#" class="text-gray-500 hover:text-[#0DA487] transition-colors">
            <img src="../../assets/images/inner-page/google.png" alt="Google" class="w-5 h-5">
          </a>
        </div>
      </div>
    </the-box>
  </footer>
</template>

<style scoped>

</style>
