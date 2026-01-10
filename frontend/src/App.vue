<script setup>

// Vue
import { onBeforeMount, ref, watch } from 'vue';

// STORES
import {useAuthStore, useLoadingStore} from '@/stores/index.js';

// COMPONENTS
import TheHeader from '@/layouts/TheHeader.vue'
import TheFooter from '@/layouts/TheFooter.vue'
import MessageBox from "@/components/message/MessageBox.vue";
import TheLoader from "@/components/ui/TheLoader.vue";

// INIT
const authStore = useAuthStore();
const loadingStore = useLoadingStore()

// REFS
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
  <div class="flex flex-col justify-between min-h-screen">
    <div>
      <the-header />
      <router-view />
    </div>
    <the-footer />
  </div>
  <message-box v-if="isInitialized"/>
  <the-loader v-if="loadingStore.isLoading"/>
</template>

<style scoped>
</style>
