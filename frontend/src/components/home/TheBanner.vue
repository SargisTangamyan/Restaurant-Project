<script setup>
// VUE
import {ref, computed, onMounted, onBeforeUnmount} from 'vue';

// COMPONENTS
import TheBox from '@/components/ui/TheBox.vue'
import BannerImage from "@/components/ui/BannerImage.vue";

// STORE
import {useDishStore} from "@/stores/index.js";
const dishStore = useDishStore();

// SWIPER
// Import Swiper Vue.js components
import {Swiper, SwiperSlide} from 'swiper/vue';
import {Autoplay} from "swiper/modules";

// Import Swiper styles
import 'swiper/css';

// REFS
const windowWidth = ref(window.innerWidth);
const latestDishes = ref([]);
const loading = ref(true);

// METHODS
const updateWidth = function () {
  windowWidth.value = window.innerWidth;
}

const fetchLatestDishes = async () => {
  loading.value = true;
  const response = await dishStore.fetchDishes({
    limit: 5,
  });
  if (response.success) {
    latestDishes.value = response.data;
  }
  loading.value = false;
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
  fetchLatestDishes();
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateWidth);
})
</script>

<template>
  <the-box>
    <section class="banner-section py-8">
      <div class="container mx-auto">

        <!-- Hero Header -->
        <section class="hero-header text-gray-700 py-16">
          <div class="container mx-auto text-center px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">
              Our Freshest Products
            </h1>
            <p class="text-lg md:text-2xl text-gray-700 mb-6 drop-shadow-md">
              Discover the freshest dishes made with love and quality ingredients
            </p>
            <router-link :to="{name: 'dishes' }"
              class="px-8 py-4 bg-white text-gray-700 font-semibold rounded-lg shadow-lg hover:bg-gray-100 transition duration-300"
            >
              View Menu
            </router-link>
          </div>
        </section>

        <div v-if="loading" class="flex justify-center items-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
        </div>

        <Swiper
          v-else-if="latestDishes.length > 0"
          :modules="[Autoplay]"
          :slides-per-view="itemsPerPage"
          :space-between="16"
          :loop="true"
          :speed="800"
          :autoplay="{ delay: 2000 }"
          class="w-full"
        >
          <!-- Slide 1 -->
          <SwiperSlide v-for="dish in latestDishes" :key="dish.id">
            <banner-image image-alt="Banner Image" :image-src="dish.thumbnail">
              <div
                class="absolute inset-0 flex flex-col justify-center left-8 text-white space-y-2">
                <h5 class="text-2xl md:text-4xl font-bold">{{dish.name}}</h5>
                <h6 class="text-sm md:text-base">{{dish.description}}</h6>
                <router-link
                  :to="{name: 'dish', params: {id: dish.id}}"
                   class="button-cgreen">
                  Order Now
                </router-link>
              </div>
            </banner-image>
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
