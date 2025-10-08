<script setup>
// COMPONENTS
import TheBox from "@/components/ui/TheBox.vue";
import TheBanner from "@/components/home/TheBanner.vue";

</script>

<template>
  <the-box>
    <div class="grid grid-cols-1 auto-rows-max xl:grid-cols-3 xl:grid-rows-1 gap-4">

      <!-- Left Banner -->
      <div class="xl:col-span-2 relative w-full">
        <div class="w-full h-full relative">
          <img src="../assets/images/restaurant/banner/1.jpg"
               alt="Banner"
               class="h-full w-full object-cover rounded-lg" />
          <div class="absolute left-8 top-1/2 -translate-y-1/2 w-3/4 text-black space-y-3">
            <h6 class="text-lg font-medium">Exclusive offer <span class="text-[#FF7272] bg-red-50 px-3 py-2 text-sm rounded-3xl">30% Off</span></h6>
            <h1 class="text-3xl md:text-5xl font-extrabold uppercase leading-snug">
              Stay home & delivered your <span class="text-[#0DA487] ">Daily Needs</span>
            </h1>
            <p class="hidden sm:block w-3/4 text-gray-100">
              Vegetables contain many vitamins and minerals that are good for your health.
            </p>
            <button class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition mt-4">
              Order Now
            </button>
          </div>
        </div>
      </div>

      <!-- Right Banners -->
      <div class="grid md:grid-cols-2 xl:grid-cols-1 gap-4 xl:col-start-3 xl:row-start-1">
        <!-- First Small Banner -->
        <div class="relative rounded-lg overflow-hidden md:aspect-auto xl:aspect-[3/2]">
          <img src="../assets/images/restaurant/banner/2.jpg" class="w-full h-full object-cover" />
          <div class="absolute left-6 top-1/2 -translate-y-1/2 w-3/4 text-white space-y-2">
            <h2 class="text-3xl font-bold text-red-500">45% <span class="text-white">OFF</span></h2>
            <h3 class="text-green-400 text-xl font-semibold">Nut Collection</h3>
            <p class="text-sm text-gray-100">We deliver organic vegetables & fruits</p>
            <a href="#"
               class="inline-flex items-center text-sm font-medium text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition">
              Order Now
            </a>
          </div>
        </div>

        <!-- Second Small Banner -->
        <div class="relative rounded-lg overflow-hidden md:aspect-auto xl:aspect-[3/2]">
          <img src="../assets/images/restaurant/banner/3.jpg" class="w-full h-full object-cover" />
          <div class="absolute left-6 top-1/2 -translate-y-1/2 w-3/4 text-white space-y-2">
            <h3 class="text-green-400 text-xl font-bold">Healthy Food</h3>
            <h4 class="text-red-500 text-lg font-semibold">Organic Market</h4>
            <p class="text-sm">Start your daily shopping with some Organic food</p>
            <a href="#"
               class="inline-flex items-center text-sm font-medium text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg transition">
              Order Now
            </a>
          </div>
        </div>
      </div>
    </div>
  </the-box>
  <the-banner />
</template>

<style scoped>
</style>
