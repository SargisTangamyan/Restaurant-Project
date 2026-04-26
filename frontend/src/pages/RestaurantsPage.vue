<script setup>
import {ref, onMounted} from "vue";
import axios from "axios";

import PageName from "@/components/ui/PageName.vue";
import TheBox from "@/components/ui/TheBox.vue";
import RatingStars from "@/components/ui/RatingStars.vue";

import {useLoadingStore} from "@/stores/index.js";

const restaurants = ref([]);
const error = ref("");

const loadingStore = useLoadingStore();

const getImageUrl = (image) => {
  if (!image) return "";
  return image.startsWith("http") ? image : `http://localhost:8000/storage/${image}`;
}

const fetchRestaurants = async () => {
  loadingStore.startLoading();
  error.value = "";

  try {
    const response = await axios.get("http://localhost:8000/api/restaurants");
    restaurants.value = response.data.data.map((restaurant) => ({
      ...restaurant,
      rating: parseFloat(restaurant.rating), // temporary until you store rating in DB
      tags: ["French", "Healthy", "Popular"],   // temporary until you store tags in DB
      image: getImageUrl(restaurant.image),
    }));
  } catch (err) {
    error.value = "Failed to load restaurants.";
    console.error(err);
  } finally {
    loadingStore.stopLoading();
  }
};

onMounted(fetchRestaurants);
</script>

<template>
  <page-name p-name="Restaurants"></page-name>

  <the-box>
    <div class="container mx-auto px-4 py-6">
      <div class="rounded-3xl bg-white shadow-lg ring-1 ring-gray-100 overflow-hidden">
        <div class="relative bg-gradient-to-r from-emerald-50 via-white to-teal-50 px-6 py-8 sm:px-8 border-b border-gray-100">
          <div class="max-w-3xl">
            <p class="text-sm font-medium tracking-wide text-emerald-600 uppercase">
              Explore our restaurant collection
            </p>
            <h3 class="mt-2 text-2xl sm:text-3xl font-bold text-gray-900">
              Browse Restaurants
            </h3>
            <p class="mt-3 text-sm sm:text-base text-gray-600 leading-7">
              Find the restaurant that best suits your taste, mood, and budget.
            </p>
          </div>
        </div>

        <div class="px-4 py-6 sm:px-6 sm:py-8">
          <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            <article
              v-for="r in restaurants"
              :key="r.id"
              class="group overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
            >
              <div class="relative h-56 overflow-hidden bg-gray-100">
                <img
                  :src="r.image"
                  alt="Restaurant image"
                  class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                />

                <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/10 to-transparent"></div>

                <div class="absolute left-4 top-4">
                  <span class="inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-gray-800 shadow-sm backdrop-blur">
                    #{{ r.id }}
                  </span>
                </div>
              </div>

              <div class="p-5">
                <div class="flex items-start justify-between gap-4">
                  <div class="min-w-0">
                    <router-link :to="{ name: 'restaurant_dishes', params: { slug: r.slug } }" class="block">
                      <h4 class="truncate text-lg font-bold text-gray-900 transition-colors group-hover:text-emerald-600">
                        {{ r.name }}
                      </h4>
                    </router-link>

                    <div class="mt-2 flex items-center gap-2">
                      <rating-stars :stars="r.rating" />
                      <span class="text-sm font-medium text-gray-600">
                        {{ r.rating.toFixed(1) }}
                      </span>
                    </div>
                  </div>
                </div>

                <p class="mt-4 text-sm leading-6 text-gray-600">
                  {{ r.description }}
                </p>

                <div class="mt-5 flex flex-wrap gap-2">
                  <span
                    v-for="tag in r.tags"
                    :key="tag"
                    class="inline-flex items-center rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700"
                  >
                    {{ tag }}
                  </span>
                </div>

                <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                  <div class="text-xs text-gray-500">
                    Restaurant #{{ r.id }}
                  </div>

                  <router-link
                    :to="{ name: 'restaurant_dishes', params: { slug: r.slug } }"
                    class="inline-flex items-center rounded-full bg-gray-900 px-4 py-2 text-xs font-semibold text-white transition-colors hover:bg-emerald-600"
                  >
                    View dishes
                  </router-link>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  </the-box>
</template>

<style scoped>
/* kept minimal on purpose */
</style>~
