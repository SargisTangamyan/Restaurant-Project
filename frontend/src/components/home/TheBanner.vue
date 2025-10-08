<script setup>
// VUE
import {ref, computed, onMounted, onBeforeUnmount} from 'vue';

// COMPONENTS
import TheBox from '@/components/ui/TheBox.vue'
import ImageText from '@/components/ui/ImageText.vue';

// IMPORTING IMAGE TO USE
import bannerImage1 from '@/assets/images/restaurant/banner/1.jpg'
import bannerImage2 from '@/assets/images/restaurant/banner/2.jpg'
import bannerImage3 from '@/assets/images/restaurant/banner/3.jpg'

// SWIPER
// Import Swiper Vue.js components
import {Swiper, SwiperSlide} from 'swiper/vue';
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
  if (windowWidth.value <= 768) {
    return 1;
  } else if (windowWidth.value <= 1024) {
    return 3;
  } else {
    return 4;
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
            <image-text image-alt="Banner Image" :image-src="bannerImage1">
              <div
                class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="discount-box">5% Off</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Hot Deals on New Items</h5>
                <h6 class="text-sm md:text-base">Daily Essentials Eggs & Dairy</h6>
                <button href="#"
                   class="button-cgreen">
                  Order Now
                </button>
              </div>
            </image-text>
          </SwiperSlide>

          <!-- Slide 2 -->
          <SwiperSlide>
            <image-text image-alt="Banner Image 2" :image-src="bannerImage2">
              <div
                class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="discount-box">5% OFF</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Buy More & Save More</h5>
                <h6 class="text-sm md:text-base">Fresh Vegetables</h6>
                <a href="#"
                   class="button-cgreen">
                  Order Now
                </a>
              </div>
            </image-text>
          </SwiperSlide>

          <!-- Slide 3 -->
          <SwiperSlide>
            <image-text image-alt="Banner Image 2" :image-src="bannerImage3">
              <div
                class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="discount-box">5% OFF</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Organic Meat Prepared</h5>
                <h6 class="text-sm md:text-base">Delivered to Your Home</h6>
                <a href="#"
                   class="button-cgreen">
                  Order Now
                </a>
              </div>
            </image-text>
          </SwiperSlide>

          <!-- Slide 4 -->
          <SwiperSlide>
            <image-text image-alt="Banner Image 2" :image-src="bannerImage2">
              <div
                class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="discount-box">5% OFF</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Eat as much as you want</h5>
                <h6 class="text-sm md:text-base">Nuts & Snacks</h6>
                <a href="#"
                   class="button-cgreen">
                  Order Now
                </a>
              </div>
            </image-text>
          </SwiperSlide>

          <!-- Slide 2 -->
          <SwiperSlide>
            <image-text image-alt="Banner Image 2" :image-src="bannerImage3">
              <div
                class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h6 class="discount-box">5% OFF</h6>
                <h5 class="text-2xl md:text-4xl font-bold">Buy as Much as you want</h5>
                <h6 class="text-sm md:text-base">Fresh Vegetables</h6>
                <a href="#"
                   class="button-cgreen">
                  Order Now
                </a>
              </div>
            </image-text>
          </SwiperSlide>

        </Swiper>
      </div>
    </section>
  </the-box>
</template>

<style scoped>
.banner-section {
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
