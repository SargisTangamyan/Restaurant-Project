<script setup>

// VUE
import { defineProps } from 'vue'

const props = defineProps({
  links: {
    type: Array,
    required: true,
  }
})

</script>

<template>
  <!-- Navigation -->
  <nav class="flex flex-col gap-2">

    <router-link v-for="(link, index) in props.links" :key="index" :to="{name: link.routeName}" class="flex items-center gap-2 py-3 px-8 rounded-lg text-gray-700 hover:bg-gray-100 transition">
      {{link.name}}
    </router-link>

    <slot>

    </slot>
  </nav>
</template>

<style scoped>

</style>
