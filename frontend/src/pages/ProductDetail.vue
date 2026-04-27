<script setup>

// COMPONENTS
import PageName from '@/components/ui/PageName.vue'
import TheBox from '@/components/ui/TheBox.vue'
import DishImages from "@/components/dish/DishImages.vue";
import RatingStars from "@/components/ui/RatingStars.vue";
import TheCounter from "@/components/ui/TheCounter.vue";
import IngredientList from "@/components/detail/ingredients/IngredientList.vue";
import TrendingList from "@/components/detail/trending/TrendingList.vue";
import ReviewContainer from "@/components/detail/review/ReviewContainer.vue";
import TheLoader from "@/components/ui/TheLoader.vue";
import AddToCartButton from "@/components/cart/AddToCartButton.vue";
import AllergyStatusBadge from "@/components/ui/AllergyStatusBadge.vue";

// VUE
import {ref, defineProps, onMounted, computed, watch} from 'vue';

// ROUTER
import {useRouter} from "vue-router";

const router = useRouter();

// STORE
import {useDishStore, useAuthStore} from "@/stores/index.js";
import {useCartStore} from "@/stores/index.js";

const cartStore = useCartStore();
const dishStore = useDishStore();
const authStore = useAuthStore();

// API
import { sender } from '@/api/Sender.js';
import { ALLERGIES } from '@/constants/urls.js';

// REF
const isLoading = ref(true);
const dish = ref(null);
const count = ref(1);
const fetchError = ref(false);
const userAllergyIds = ref(new Set());

// COMPUTED
const isDishLoaded = computed(() => dish.value !== null && !fetchError.value);

// METHODS
const setCount = (value) => {
  count.value = value
}

const fetchDish = async (id) => {
  isLoading.value = true;
  // Fetch dish details
  const res = await dishStore.fetchDishById(id);

  if (res.success && res.data) {
    dish.value = res.data;
    isLoading.value = false;
  } else {
    // Dish not found or error occurred
    fetchError.value = true;
    isLoading.value = false;
    await router.replace({name: 'NotFound'});
  }
}

// PROPS
const props = defineProps({
  id: {
    required: true,
    type: String,
  }
})

const refreshDish = async () => {
  const res = await dishStore.fetchDishById(props.id);
  if (res.success && res.data) {
    dish.value = { ...dish.value, average_rating: res.data.average_rating, reviews_count: res.data.reviews_count };
  }
};

// WATCH
watch(() => props.id, async (newId) => {await fetchDish(newId);})

// MOUNTING
onMounted(async () => {
  try {
    // Fetch cart only if not loaded (non-blocking)
    if (!cartStore.getIsLoaded) {
      cartStore.fetchCart().catch(err => {
        console.warn('Failed to load cart:', err)
      })
    }

    // Fetch user's personal allergies (non-blocking)
    if (authStore.isAuthenticated) {
      sender.sendRequest('GET', ALLERGIES).then(res => {
        if (res.success) {
          userAllergyIds.value = new Set(res.data.allergies.map(i => i.id));
        }
      });
    }

    // Fetch dish details
    await fetchDish(props.id);
  } catch (error) {
    console.error('Error loading dish:', error);
    fetchError.value = true;
    isLoading.value = false;
    await router.replace({name: 'NotFound'});
  }
});

</script>

<template>
  <the-loader v-if="isLoading"/>
  <div v-else-if="isDishLoaded && dish">
    <page-name :p-name="dish.name"/>
    <the-box>

      <div class="grid grid-cols-5 gap-4 p-5">

        <!-- First 2 columns -->
        <div class="flex flex-col col-span-2 gap-4">
          <dish-images :image-path="dish.image"/>
        </div>

        <!-- Second 2 columns -->
        <div
          class="col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col gap-6">
          <!-- Allergy Status -->
          <allergy-status-badge :status="dish.allergy_status ?? null" />

          <!-- Product Title -->
          <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ dish.name }}</h2>
            <div class="mt-1 text-sm text-gray-500">
              by
              <span class="font-semibold text-gray-700 hover:text-cgreen cursor-pointer">
                Saffron & Smoke
              </span>
            </div>
            <div class="" v-if="dish.category">
              <span class="font-bold">Category:</span>
              <span class="inline-block pl-1 text-cgreen text-md font-bold">
                {{ dish.category.name }}
              </span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
              <h3 class="text-2xl font-semibold text-cgreen">${{ dish.price }}</h3>
              <del class="text-gray-400 text-lg">${{(dish.price * 1.2).toFixed(2)}}</del>
              <span class="text-cgreen font-medium">(20% off)</span>
            </div>
          </div>

          <!-- Rating -->
          <div class="flex items-center gap-2">
            <rating-stars :stars="Number(dish.average_rating) || 0"/>
            <span class="text-sm text-gray-500">{{ dish.reviews_count }} Customer {{ dish.reviews_count === 1 ? 'Review' : 'Reviews' }}</span>
          </div>

          <!-- Description -->
          <p class="text-gray-600 leading-relaxed">
            {{ dish.description }}
          </p>

          <!-- Quantity + Add to Cart -->
          <the-counter @counter-change="setCount"/>
          <add-to-cart-button
            :dish-id="dish.id"
            :quantity="count"
          />

          <!-- Wishlist + Compare -->
          <div class="flex gap-4 text-sm font-medium">
            <a href="#" class="flex items-center gap-1 hover:underline text-gray-600 hover:text-green-700">
              <font-awesome-icon :icon="['fas', 'heart']"/>
              <span>Add To Wishlist</span>
            </a>
            <a href="#" class="flex items-center justify-center hover:underline gap-1 text-gray-600 hover:text-green-700">
              <font-awesome-icon :icon="['fas', 'shuffle']"/>
              <span>Add To Compare</span>
            </a>
          </div>

          <ingredient-list v-if="dish.ingredients" :ingredients="dish.ingredients" :user-allergy-ids="userAllergyIds"/>
        </div>

        <!-- Last Column -->
        <trending-list :dish-id="dish.id"/>
      </div>

      <!-- ✅ Review Section -->
      <review-container :dish="dish" @rating-updated="refreshDish"/>
    </the-box>
  </div>
  <!-- Fallback if redirect fails -->
  <div v-else class="flex items-center justify-center min-h-screen">
    <p class="text-gray-500">Redirecting...</p>
  </div>
</template>
