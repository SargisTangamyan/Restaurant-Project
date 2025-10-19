<script setup>

// COMPONENTS
import TheHeader from '@/layouts/TheHeader.vue'
import TheFooter from '@/layouts/TheFooter.vue'
import MessageBox from "@/components/message/MessageBox.vue";

</script>

<template>
  <the-header />
  <router-view />
  <the-footer />

  <message-box />
</template>

<style scoped>
</style>
