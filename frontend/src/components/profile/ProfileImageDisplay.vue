<script setup>

import ImageDisplay from "@/components/ui/image/ImageDisplay.vue";
import {computed} from "vue";
import defaultAvatar from "@/assets/images/profile/no-avatar.jpg";
import {useAuthStore} from "@/stores/index.js";

const authStore = useAuthStore();
const imageUrl = computed(() => authStore.user?.profile_image || null);

</script>

<template>
    <div class="relative w-32 h-32 rounded-full overflow-hidden border-gray-200">
      <image-display :image-path="imageUrl" :fallback-image="defaultAvatar" alt="Profile Image" />
    </div>
</template>

<style scoped>

</style>
