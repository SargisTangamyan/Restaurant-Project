<script setup>
import PageName from "@/components/ui/PageName.vue";
import TheBox from "@/components/ui/TheBox.vue";
import RatingStars from "@/components/ui/RatingStars.vue";

// Importing images
import image1 from "@/assets/images/restaurant/1.jpg"
import image2 from "@/assets/images/restaurant/2.jpg"
import image3 from "@/assets/images/restaurant/3.jpg"
import image4 from "@/assets/images/restaurant/4.jpg"
import image5 from "@/assets/images/restaurant/5.jpg"
import image6 from "@/assets/images/restaurant/6.jpg"

const restaurants = [
  {
    id: 1,
    name: "Saffron & Smoke",
    image: image1,
    description: "Modern grill house with slow-smoked specials, bright herbs, and a cozy late-night vibe.",
    stars: 4.5,
    tags: ["Grill", "Smoked", "Late-night"],
  },
  {
    id: 2,
    name: "Olive Alley Kitchen",
    image: image2,
    description: "Mediterranean comfort plates, lemony dressings, and warm flatbreads baked throughout the day.",
    stars: 4,
    tags: ["Mediterranean", "Fresh", "Family"],
  },
  {
    id: 3,
    image: image3,
    name: "Copper Spoon Noodle Bar",
    description: "Brothy bowls, quick bites, and house chili oil that somehow makes everything better.",
    stars: 4.5,
    tags: ["Noodles", "Asian", "Casual"],
  },
  {
    id: 4,
    name: "The Green Lantern Bistro",
    image: image4,
    description: "Seasonal bistro with lighter plates, crisp salads, and surprisingly good desserts.",
    stars: 3.5,
    tags: ["Bistro", "Seasonal", "Dessert"],
  },
  {
    id: 5,
    name: "Basil & Brick Oven",
    image: image5,
    description: "Brick-oven classics with charred crusts, rich sauces, and a simple, punchy menu.",
    stars: 5,
    tags: ["Pizza", "Italian", "Oven"],
  },
  {
    id: 6,
    name: "Riverstone Tap & Table",
    image: image6,
    description: "Relaxed spot for shareable plates, hearty mains, and a rotating selection of local drinks.",
    stars: 4,
    tags: ["Pub", "Sharing", "Drinks"],
  },
];
</script>

<template>
  <page-name p-name="Restaurants"></page-name>

  <the-box>
    <div class="container mx-auto py-4">
      <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="p-4 sm:p-6 border-b">
          <h3 class="text-lg sm:text-xl font-semibold text-gray-900">Browse Restaurants</h3>
          <p class="text-sm text-gray-500 mt-1">
            Find the Restaurant that best suits your taste and budget.
          </p>
        </div>

        <div class="p-4 sm:p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            <article
              v-for="r in restaurants"
              :key="r.id"
              class="border rounded-xl p-4 hover:shadow-sm transition-shadow bg-white flex flex-row justify-between gap-2"
            >
              <div>
                <img
                  :src="r.image"
                  alt="Restaurant image"
                  class="h-full w-75 object-cover transition-transform duration-300 hover:scale-105"
                />
              </div>
              <div>
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <router-link to="dishes" >
                      <h4 class="text-base font-semibold text-gray-900 leading-snug">
                        {{ r.name }}
                      </h4>
                    </router-link>

                    <div class="flex items-center gap-2 mt-2">
                      <rating-stars :stars="r.stars" />
                      <span class="text-sm text-gray-600">{{ r.stars.toFixed(1) }}</span>
                    </div>
                  </div>

                  <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                    #{{ r.id }}
                  </span>
                </div>

                <p class="text-sm text-gray-600 mt-3 leading-relaxed">
                  {{ r.description }}
                </p>

                <div class="flex flex-wrap gap-2 mt-4">
                <span
                  v-for="tag in r.tags"
                  :key="tag"
                  class="text-xs px-2 py-1 rounded-full bg-green-50 text-green-700 border border-green-100"
                >
                  {{ tag }}
                </span>
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
