<script setup>

// COMPONENTS
import TheHeader from '@/layouts/TheHeader.vue'
import TheFooter from '@/layouts/TheFooter.vue'
import MessageBox from "@/components/message/MessageBox.vue";

import { onBeforeMount, ref } from 'vue';
import { useAuthStore } from '@/stores/index.js';

const authStore = useAuthStore();
const isInitialized = ref(false);

onBeforeMount(async () => {
  // Initialize auth state before any routing happens
  if (authStore.token) {
    try {
      await authStore.initAuth();
    } catch (error) {
      console.error('Failed to initialize auth:', error);
    }
  }

  isInitialized.value = true;
});
</script>

<template>
  <div class="flex flex-col min-h-screen">
    <the-header />
    <router-view />
    <the-footer />
  </div>
  <message-box />
</template>

<style scoped>
</style>
