<script setup>

import ImageDisplay from "@/components/ui/image/ImageDisplay.vue";
import {computed} from "vue";
import defaultAvatar from "@/assets/images/profile/no-avatar.jpg";
import {useAuthStore} from "@/stores/index.js";

const authStore = useAuthStore();
const imageUrl = computed(() => authStore.user?.profile_image || defaultAvatar);
const noImage = computed(() => !!authStore.user?.profile_image);

</script>

<template>
    <div class="relative w-32 h-32 rounded-full overflow-hidden border-gray-200">
      <image-display :url="imageUrl" :inner="!noImage" alt="Profile Image" />
    </div>
</template>

<style scoped>

</style>
