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

// VUE
import {ref, defineProps, onMounted} from 'vue';

// ROUTER
import {useRouter} from "vue-router";

const router = useRouter();

// STORE
import {useDishStore} from "@/stores/index.js";
import {useCartStore} from "@/stores/index.js";

const cartStore = useCartStore();
const dishStore = useDishStore();

// REF
const isLoading = ref(true);
const dish = ref({});

// PROPS
const props = defineProps({
  id: {
    required: true,
    type: String,
  }
})

// MOUNTING
onMounted(async () => {
  if (!cartStore.getIsLoaded) {
    await cartStore.fetchCart();
  }

  const res = await dishStore.fetchDishById(props.id);
  if (res.success) {
    dish.value = res.data;
    isLoading.value = false;
  } else {
    isLoading.value = false;
    await router.replace({name: 'NotFound'});
  }
});

</script>

<template>
  <the-loader v-if="isLoading"/>
  <div v-else>
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
          <!-- Discount Tag -->
          <div class="discount-box">
            30% Off
          </div>

          <!-- Product Title -->
          <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ dish.name }}</h2>
            <div class="mb-2">
              <span class="font-bold">Category:</span> <span class="inline-block pl-1 text-cgreen text-md font-bold hover:underline cursor-pointer">{{dish.category.name}}</span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
              <h3 class="text-2xl font-semibold text-cgreen">${{ dish.price }}</h3>
              <del class="text-gray-400 text-lg">$58.46</del>
              <span class="text-cgreen font-medium">(8% off)</span>
            </div>
          </div>

          <!-- Rating -->
          <div class="flex items-center gap-2">
            <rating-stars :stars="3.5"/>
            <span class="text-sm text-gray-500">23 Customer Reviews</span>
          </div>

          <!-- Description -->
          <p class="text-gray-600 leading-relaxed">
            {{ dish.description }}
          </p>

          <!-- Weight Options -->
          <!--        <div>-->
          <!--          <h4 class="text-lg font-semibold mb-2">Weight</h4>-->
          <!--          <ul class="flex flex-wrap gap-2">-->
          <!--            <li><a href="#" class="px-3 py-1 bg-cgreen text-white rounded-full text-sm font-medium">1/2 KG</a></li>-->
          <!--            <li><a href="#" class="px-3 py-1 border border-gray-300 rounded-full text-sm hover:bg-gray-100">1 KG</a></li>-->
          <!--            <li><a href="#" class="px-3 py-1 border border-gray-300 rounded-full text-sm hover:bg-gray-100">1.5 KG</a></li>-->
          <!--            <li><a href="#" class="px-3 py-1 border border-gray-300 rounded-full text-sm hover:bg-gray-100">Red Roses</a></li>-->
          <!--            <li><a href="#" class="px-3 py-1 border border-gray-300 rounded-full text-sm hover:bg-gray-100">With Pink Roses</a></li>-->
          <!--          </ul>-->
          <!--        </div>-->

          <!-- Quantity + Add to Cart -->
          <the-counter/>
          <add-to-cart-button :dish-id="dish.id" />

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

          <ingredient-list :ingredients="dish.ingredients"/>
        </div>


        <!-- Last Column -->
        <trending-list/>
      </div>


      <!-- ✅ Review Section -->
      <review-container/>
    </the-box>
  </div>
</template>

<style scoped>

</style>
