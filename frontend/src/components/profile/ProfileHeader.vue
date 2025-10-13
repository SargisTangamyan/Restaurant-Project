<script setup>

// STORE
import { useAuthStore } from "@/stores/index.js";

// USING STORE
const authStore = useAuthStore();

// GETTING DATA
const user = authStore.getUser;

</script>

<template>
  <div class="relative rounded-xl overflow-hidden">
    <img src="../../assets/images/restaurant/banner/1.jpg" class="w-full h-24 object-cover" alt="Cover">

    <div class="flex flex-col items-center -mt-10">
      <div class="relative w-20 h-20 rounded-full border-4 border-white overflow-hidden shadow-md">
        <img src="../../assets/images/profile/1.jpg" class="w-full h-full object-cover" alt="Profile">
      </div>
      <div class="text-center mt-3">
        <h3 class="text-lg font-semibold text-gray-800">{{ user.username ?? 'Unknown' }}</h3>
        <h6 class="text-sm text-gray-500">{{ user.email }}</h6>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
