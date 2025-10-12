<script setup>

// VUE
import {defineProps} from 'vue';

const props = defineProps({
  links: {
    required: true,
    type: Array,
  }
});

</script>

<template>
  <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-10 transition-all duration-300 transform origin-top scale-y-0 group-hover:scale-y-100">
    <ul class="list-none p-0 m-0">
      <li v-for="(link, index) in props.links" :key="index">
        <router-link
          :to="{ name: link.urlName }"
          class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100 hover:text-gray-900 rounded"
        >
          {{ link.name }}
        </router-link>
      </li>
    </ul>
  </div>
</template>


<style scoped>
</style>
