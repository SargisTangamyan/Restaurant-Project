<script setup>

// COMPONENT
import RatingStars from "@/components/ui/RatingStars.vue";

</script>

<template>
  <div class="border-b border-gray-100 pb-4">
    <div class="flex items-center justify-between mb-2">
      <div class="flex items-center gap-2">
        <img src="../../../assets/images/profile/no-avatar.jpg" alt="user"
             class="w-10 h-10 rounded-full object-cover">
        <div>
          <h6 class="font-semibold text-gray-800">John Doe</h6>
          <span class="text-sm text-gray-500">June 4, 2025</span>
        </div>
      </div>
      <rating-stars :stars="4.5" />
    </div>
    <p class="text-gray-600 text-sm leading-relaxed">
      The cake was delicious and moist. The packaging was neat and delivery was quick.
      Definitely ordering again!
    </p>
  </div>
</template>

<style scoped>

</style>
