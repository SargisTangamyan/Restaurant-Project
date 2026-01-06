<script setup>

// Vue
import { onBeforeMount, ref, watch } from 'vue';
import { useAuthStore } from '@/stores/index.js';

// COMPONENTS
import TheHeader from '@/layouts/TheHeader.vue'
import TheFooter from '@/layouts/TheFooter.vue'
import MessageBox from "@/components/message/MessageBox.vue";

const authStore = useAuthStore();
const isInitialized = ref(false);

watch(isInitialized, (val) => {
  if (val) {
    const loader = document.getElementById('page-loader');
    if (loader) {
      loader.style.display = 'none';
    }
  }
}, {immediate: true});

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
  <message-box v-if="isInitialized"/>
</template>

<style scoped>
</style>
