<script setup>

// COMPONENT
import AverageRating from "@/components/detail/review/AverageRating.vue";
import ReviewList from "@/components/detail/review/ReviewList.vue";

</script>

<template>
  <div class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 col-span-5">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">Customer Reviews</h3>

    <!-- Average Rating Summary -->
    <average-rating />

    <!-- Review List -->
    <review-list />

    <!-- Add Review Form -->
    <div class="mt-8">
      <h4 class="text-lg font-semibold mb-3 text-gray-800">Add Your Review</h4>

      <form @submit.prevent class="space-y-4">
        <!-- Rating -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Your Rating</label>
          <div class="flex items-center text-yellow-400">
            <font-awesome-icon v-for="i in 5" :key="i" :icon="['fas', 'star']"
                               class="w-5 h-5 cursor-pointer hover:scale-110 transition-transform"/>
          </div>
        </div>

        <!-- Name + Email -->
        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
            <input type="text" placeholder="Enter your name"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-cgreen focus:outline-none">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Your Email</label>
            <input type="email" placeholder="Enter your email"
                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-cgreen focus:outline-none">
          </div>
        </div>

        <!-- Comment -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Your Review</label>
          <textarea rows="4" placeholder="Write your review..."
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-cgreen focus:outline-none"></textarea>
        </div>

        <!-- Submit Button -->
        <button
          class="bg-cgreen hover:bg-emerald-700 text-white font-medium rounded-lg px-6 py-3 transition">
          Submit Review
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>

</style>
