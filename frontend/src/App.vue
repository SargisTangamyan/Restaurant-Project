<script setup>

// COMPONENTS
import TheHeader from '@/layouts/TheHeader.vue'
import TheFooter from '@/layouts/TheFooter.vue'
import MessageBox from "@/components/message/MessageBox.vue";

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
