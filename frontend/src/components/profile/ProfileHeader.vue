<script setup>

// VUE
import { computed } from 'vue';

// STORE
import { useAuthStore } from "@/stores/index.js";

// COMPONETS
import ProfileImageDisplay from "@/components/profile/ProfileImageDisplay.vue";

// USING STORE
const authStore = useAuthStore();

// GETTING DATA
const username = computed(() => authStore.user.username)
const email = computed(() => authStore.user.email)

</script>

<template>
  <div class="relative rounded-xl overflow-hidden">
    <img src="../../assets/images/profile/profile-background.jpg" class="w-full h-24 object-cover" alt="Cover">

    <div class="flex flex-col items-center -mt-10">
      <profile-image-display class="border-4 border-white shadow-md"/>
      <div class="text-center mt-3">
        <h3 class="text-lg font-semibold text-gray-800">{{ username ?? 'Unknown' }}</h3>
        <h6 class="text-sm text-gray-500">{{ email }}</h6>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
