<script setup>

// COMPONENTS
import PageName from '@/components/ui/PageName.vue'
import TheBox from '@/components/ui/TheBox.vue'
import DishImages from "@/components/dish/DishImages.vue";
import RatingStars from "@/components/ui/RatingStars.vue";
import TheCounter from "@/components/ui/TheCounter.vue";

// VUE
import { defineProps } from 'vue';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const props = defineProps({
  id: {
    required: true,
    type: String,
  }
})

</script>

<template>
  <page-name p-name="Dish N1"/>
  <the-box>

    <div class="grid grid-cols-5 gap-4 p-5">

      <!-- First 2 columns -->
      <div class="flex flex-col col-span-2 gap-4">
        <dish-images />
      </div>

      <!-- Second 2 columns -->
      <div class="col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col gap-6">
        <!-- Discount Tag -->
        <div class="discount-box">
          30% Off
        </div>

        <!-- Product Title -->
        <div>
          <h2 class="text-3xl font-bold text-gray-800 mb-2">Creamy Chocolate Cake</h2>
          <div class="flex flex-wrap items-center gap-3">
            <h3 class="text-2xl font-semibold text-cgreen">$49.50</h3>
            <del class="text-gray-400 text-lg">$58.46</del>
            <span class="text-cgreen font-medium">(8% off)</span>
          </div>
        </div>

        <!-- Rating -->
        <div class="flex items-center gap-2">
          <rating-stars :stars="3.5" />
          <span class="text-sm text-gray-500">23 Customer Reviews</span>
        </div>

        <!-- Description -->
        <p class="text-gray-600 leading-relaxed">
          Lollipop cake chocolate cake dessert jujubes. Shortbread sugar plum dessert powder cookie sweet brownie.
        </p>

        <!-- Weight Options -->
        <div>
          <h4 class="text-lg font-semibold mb-2">Weight</h4>
          <ul class="flex flex-wrap gap-2">
            <li><a href="#" class="px-3 py-1 bg-cgreen text-white rounded-full text-sm font-medium">1/2 KG</a></li>
            <li><a href="#" class="px-3 py-1 border border-gray-300 rounded-full text-sm hover:bg-gray-100">1 KG</a></li>
            <li><a href="#" class="px-3 py-1 border border-gray-300 rounded-full text-sm hover:bg-gray-100">1.5 KG</a></li>
            <li><a href="#" class="px-3 py-1 border border-gray-300 rounded-full text-sm hover:bg-gray-100">Red Roses</a></li>
            <li><a href="#" class="px-3 py-1 border border-gray-300 rounded-full text-sm hover:bg-gray-100">With Pink Roses</a></li>
          </ul>
        </div>

        <!-- Quantity + Add to Cart -->
        <the-counter></the-counter>
        <button class="flex-1 bg-cgreen hover:bg-emerald-700 text-white font-medium rounded-lg px-5 py-3 transition">
          Add To Cart
        </button>

        <!-- Wishlist + Compare -->
        <div class="flex gap-4 text-sm font-medium">
          <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-green-700">
            <font-awesome-icon :icon="['fas', 'heart']" /><span>Add To Wishlist</span>
          </a>
          <a href="#" class="flex items-center gap-2 text-gray-600 hover:text-green-700">
            <i data-feather="shuffle"></i><span>Add To Compare</span>
          </a>
        </div>

        <!-- Store Info -->
        <div>
          <h4 class="font-semibold mb-2 text-gray-800">Store Information</h4>
          <p class="text-gray-600 mb-3">
            Lollipop cake chocolate chocolate cake dessert jujubes. Shortbread sugar plum dessert powder cookie sweet brownie.
          </p>
          <ul class="text-sm text-gray-700 space-y-1">
            <li>Type: <a href="#" class="text-cgreen">Black Forest</a></li>
            <li>SKU: <a href="#" class="text-cgreen">SDFVW65467</a></li>
            <li>MFG: <a href="#" class="text-cgreen">Jun 4, 2022</a></li>
            <li>Stock: <a href="#" class="text-cgreen">2 Items Left</a></li>
            <li>Tags: <a href="#" class="text-cgreen">Cake</a>, <a href="#" class="text-emerald-600">Bakery</a></li>
          </ul>
        </div>
      </div>


      <!-- Last Column -->
      <div class="category-menu bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
          <h3 class="text-xl font-semibold mb-5 border-b pb-2 text-gray-800">Trending Products</h3>

          <ul class="space-y-4">
            <li v-for="n in 5" :key="n" class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
              <div class="flex items-center gap-4">
                <a href="product-left-thumbnail.html" class="flex-shrink-0">
                  <img src="../assets/images/dish/1.jpg"
                       class="w-20 h-20 object-cover rounded-lg transition-transform duration-300 hover:scale-105"
                       alt="">
                </a>

                <div class="flex flex-col justify-between">
                  <a href="product-left-thumbnail.html">
                    <h6 class="font-medium text-gray-700 hover:text-cgreen transition-colors">Meatigo Premium Goat Curry</h6>
                  </a>
                  <span class="text-sm text-gray-500">450 G</span>
                  <h6 class="text-lg font-semibold text-cgreen">$70.00</h6>
                </div>
              </div>
            </li>
          </ul>
        </div>

      </div>

      <!-- ✅ Review Section -->
      <div class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 col-span-5">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">Customer Reviews</h3>

        <!-- Average Rating Summary -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
          <div class="flex items-center gap-2">
            <ul class="flex text-yellow-400">
              <font-awesome-icon v-for="i in 5" :key="i" :icon="['fas', i <= 4 ? 'star' : 'star-half-alt']" class="w-5 h-5"/>
            </ul>
            <span class="text-lg font-medium text-gray-700 ml-2">4.5 out of 5</span>
          </div>
          <span class="text-sm text-gray-500 mt-2 md:mt-0">Based on 23 customer reviews</span>
        </div>

        <!-- Review List -->
        <div class="space-y-6">
          <div v-for="r in 3" :key="r" class="border-b border-gray-100 pb-4">
            <div class="flex items-center justify-between mb-2">
              <div class="flex items-center gap-2">
                <img src="../assets/images/profile/1.jpg" alt="user" class="w-10 h-10 rounded-full object-cover">
                <div>
                  <h6 class="font-semibold text-gray-800">John Doe</h6>
                  <span class="text-sm text-gray-500">June 4, 2025</span>
                </div>
              </div>
              <ul class="flex text-yellow-400">
                <font-awesome-icon v-for="i in 5" :key="i" :icon="['fas', i <= 4 ? 'star' : 'star-half-alt']" class="w-4 h-4"/>
              </ul>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed">
              The cake was delicious and moist. The packaging was neat and delivery was quick. Definitely ordering again!
            </p>
          </div>
        </div>

        <!-- Add Review Form -->
        <div class="mt-8">
          <h4 class="text-lg font-semibold mb-3 text-gray-800">Add Your Review</h4>

          <form @submit.prevent class="space-y-4">
            <!-- Rating -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Your Rating</label>
              <div class="flex items-center text-yellow-400">
                <font-awesome-icon v-for="i in 5" :key="i" :icon="['fas', 'star']" class="w-5 h-5 cursor-pointer hover:scale-110 transition-transform"/>
              </div>
            </div>

            <!-- Name + Email -->
            <div class="grid sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                <input type="text" placeholder="Enter your name" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-cgreen focus:outline-none">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Your Email</label>
                <input type="email" placeholder="Enter your email" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-cgreen focus:outline-none">
              </div>
            </div>

            <!-- Comment -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
              <textarea rows="4" placeholder="Write your review..." class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-cgreen focus:outline-none"></textarea>
            </div>

            <!-- Submit Button -->
            <button class="bg-cgreen hover:bg-emerald-700 text-white font-medium rounded-lg px-6 py-3 transition">
              Submit Review
            </button>
          </form>
        </div>
      </div>
  </the-box>
</template>

<style scoped>

</style>
