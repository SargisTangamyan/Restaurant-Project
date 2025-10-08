<script setup>
// COMPONENTS
import TheBox from "@/components/ui/TheBox.vue";
import TheBanner from "@/components/home/TheBanner.vue";
import ImageText from "@/components/ui/ImageText.vue";

// IMAGES TO PASS TO THE COMPONENT
import homeImage1 from '@/assets/images/restaurant/banner/1.jpg'
import homeImage2 from '@/assets/images/restaurant/banner/2.jpg'
import homeImage3 from '@/assets/images/restaurant/banner/3.jpg'

</script>

<template>
  <the-box>
    <div class="grid grid-cols-1 auto-rows-max xl:grid-cols-3 xl:grid-rows-1 gap-4">

      <!-- Left Banner -->
      <div class="xl:col-span-2 relative w-full rounded-md overflow-hidden">
        <image-text image-alt="Home Image" :image-src="homeImage1" >
          <div class="absolute left-8 top-1/2 -translate-y-1/2 w-3/4 text-white space-y-3">
            <h6 class="text-lg font-medium">Exclusive offer <span class="text-[#FF7272] bg-red-50 px-3 py-2 text-sm rounded-3xl">30% Off</span></h6>
            <h1 class="text-3xl md:text-5xl font-extrabold uppercase leading-snug">
              Stay home & delivered your <span class="text-[#0DA487] ">Daily Needs</span>
            </h1>
            <p class="hidden sm:block w-3/4 text-gray-100">
              Vegetables contain many vitamins and minerals that are good for your health.
            </p>
            <button class="button-cgreen">
              Order Now
            </button>
          </div>
        </image-text>
      </div>

      <!-- Right Banners -->
      <div class="grid md:grid-cols-2 xl:grid-cols-1 gap-4 xl:col-start-3 xl:row-start-1">
        <!-- First Small Banner -->
        <image-text image-alt="Home Image 2" :image-src="homeImage2" >
          <div class="absolute left-6 top-1/2 -translate-y-1/2 w-3/4 text-white space-y-2">
            <h2 class="discount-box">45% Off</h2>
            <h3 class="text-white text-xl font-semibold">Nut Collection</h3>
            <p class="text-sm text-gray-100">We deliver organic vegetables & fruits</p>
            <a href="#"
               class="button-cgreen block w-fit">
              Order Now
            </a>
          </div>
        </image-text>

        <!-- Second Small Banner -->
        <image-text image-alt="Home Image 3" :image-src="homeImage3">
          <div class="absolute left-6 top-1/2 -translate-y-1/2 w-3/4 text-white space-y-2">
            <h3 class="text-white text-xl font-bold">Healthy Food</h3>
            <p class="text-sm">Start your daily shopping with some Organic food</p>
            <a href="#"
               class="button-cgreen block w-fit">
              Order Now
            </a>
          </div>
        </image-text>
      </div>
    </div>
  </the-box>
  <the-banner />
</template>

<style scoped>
</style>
