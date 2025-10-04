<script setup>

// VUE
import {ref, computed, onMounted, onBeforeUnmount} from 'vue';

// COMPONENTS
import TheBox from '@/components/ui/TheBox.vue'

// SWIPER
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';
import {Autoplay} from "swiper/modules";

// Import Swiper styles
import 'swiper/css';

// REFS
const windowWidth = ref(window.innerWidth);

// METHODS
const updateWidth = function () {
  windowWidth.value = window.innerWidth;
}

// COMPUTED
const itemsPerPage = computed(() => {
  if (windowWidth.value < 768) {
    return 1;
  } else if (windowWidth.value < 1024) {
    return 2;
  } else {
    return 3;
  }
});

// MOUNTING
onMounted(() => {
  window.addEventListener('resize', updateWidth);
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateWidth);
})

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

  <the-box>
    <!-- Banner Section Start -->
    <section class="banner-section py-8">
      <div class="container mx-auto">
        <Swiper
          :modules="[Autoplay]"
          :slides-per-view="itemsPerPage"
          :space-between="16"
          :loop="true"
          :speed="800"
          :autoplay="{ delay: 2000 }"
          class="w-full"
        >
          <!-- Slide 1 -->
          <SwiperSlide>
            <div class="relative rounded-lg overflow-hidden group">
              <img src="../assets/images/restaurant/banner/3.jpg"
                   class="w-full h-64 md:h-96 object-cover brightness-75 transition-transform duration-500 group-hover:scale-105"
                   alt="Banner 1" />
              <div class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="text-red-500 font-semibold">5% OFF</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Hot Deals on New Items</h5>
                <h6 class="text-sm md:text-base">Daily Essentials Eggs & Dairy</h6>
                <a href="shop-left-sidebar.html"
                   class="mt-4 inline-flex items-center bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg shadow transition">
                  Shop Now <i class="fa-solid fa-right-long ml-2"></i>
                </a>
              </div>
            </div>
          </SwiperSlide>

          <!-- Slide 2 -->
          <SwiperSlide>
            <div class="relative rounded-lg overflow-hidden group">
              <img src="../assets/images/restaurant/banner/3.jpg"
                   class="w-full h-64 md:h-96 object-cover brightness-75 transition-transform duration-500 group-hover:scale-105"
                   alt="Banner 2" />
              <div class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="text-red-500 font-semibold">5% OFF</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Buy More & Save More</h5>
                <h6 class="text-sm md:text-base">Fresh Vegetables</h6>
                <a href="shop-left-sidebar.html"
                   class="mt-4 inline-flex items-center bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg shadow transition">
                  Order Now
                </a>
              </div>
            </div>
          </SwiperSlide>

          <!-- Slide 3 -->
          <SwiperSlide>
            <div class="relative rounded-lg overflow-hidden group">
              <img src="../assets/images/restaurant/banner/3.jpg"
                   class="w-full h-64 md:h-96 object-cover brightness-75 transition-transform duration-500 group-hover:scale-105"
                   alt="Banner 3" />
              <div class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="text-red-500 font-semibold">5% OFF</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Organic Meat Prepared</h5>
                <h6 class="text-sm md:text-base">Delivered to Your Home</h6>
                <a href="shop-left-sidebar.html"
                   class="mt-4 inline-flex items-center bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg shadow transition">
                  Order Now
                </a>
              </div>
            </div>
          </SwiperSlide>

          <!-- Slide 4 -->
          <SwiperSlide>
            <div class="relative rounded-lg overflow-hidden group">
              <img src="../assets/images/restaurant/banner/3.jpg"
                   class="w-full h-64 md:h-96 object-cover brightness-75 transition-transform duration-500 group-hover:scale-105"
                   alt="Banner 4" />
              <div class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="text-red-500 font-semibold">5% OFF</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Eat as much as you want</h5>
                <h6 class="text-sm md:text-base">Nuts & Snacks</h6>
                <a href="shop-left-sidebar.html"
                   class="mt-4 inline-flex items-center bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg shadow transition">
                  Order Now
                </a>
              </div>
            </div>
          </SwiperSlide>

        </Swiper>
      </div>
    </section>
    <!-- Banner Section End -->
  </the-box>
</template>

<style scoped>
.banner-section {
  /* Optional: fade-in animation on scroll */
  animation: fadeInUp 1s ease forwards;
}

@keyframes fadeInUp {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
