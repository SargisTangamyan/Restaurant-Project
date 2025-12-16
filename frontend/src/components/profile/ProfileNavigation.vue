<script setup>

// VUE ROUTER
import { useRoute } from 'vue-router'

// STORE
import { useAuthStore } from "@/stores/index.js";
const authStore = useAuthStore();

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
  <nav class="flex flex-col">

    <div v-for="(link, index) in props.links" :key="index">
      <router-link v-if="!link.forAdmin || authStore.isAdmin" :to="{name: link.routeName}"
                   class="flex items-center gap-2 py-3 mb-2 px-8 rounded-lg text-gray-700 hover:bg-gray-100 transition"
                   :class="{'bg-gray-200 pointer-events-none hover:bg-gray-200': link.routeName === route.name}"
      >
        {{ link.name }}
      </router-link>
    </div>
    <button class="bg-red-500 text-white py-3 font-bold text-lg hover:bg-red-600">
      SOS
    </button>
    <slot>

    </slot>
  </nav>
</template>

<style scoped>

</style>
