<script setup>

// VUE
import { defineProps } from 'vue'

// VUE ROUTER
import { useRoute } from 'vue-router'

// PROPS
const props = defineProps({
  links: {
    type: Array,
    required: true,
  }
})

// ROUTE
const route = useRoute();

</script>

<template>
  <!-- Navigation -->
  <nav class="flex flex-col gap-2">

    <router-link v-for="(link, index) in props.links" :key="index" :to="{name: link.routeName}"
                 class="flex items-center gap-2 py-3 px-8 rounded-lg text-gray-700 hover:bg-gray-100 transition"
                 :class="{'bg-gray-200 pointer-events-none hover:bg-gray-200': link.routeName === route.name}"
    >
      {{ link.name }}
    </router-link>

    <slot>

    </slot>
  </nav>
</template>

<style scoped>

</style>
