<script setup>

import TheBox from "@/components/ui/TheBox.vue";
import { defineProps } from 'vue';

defineProps({
  pName: {
    type: String,
    required: true,
  }
})

</script>

<template>
  <!-- Breadcrumb Section Start -->
  <the-box class="bg-gray-100 py-6">
    <section class="breadcrumb-section">
      <div class="container mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
          <!-- Page Title -->
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-0">
            {{ pName }}
          </h2>

          <!-- Breadcrumb Navigation -->
          <nav class="text-gray-600" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center space-x-2 sm:space-x-3 text-sm sm:text-base">
              <li class="breadcrumb-item">
                <a href="index.html"
                   class="flex items-center hover:text-gray-900 transition-colors">
                  Home
                </a>
              </li>
              <li class="breadcrumb-item text-gray-500">
                <span>/</span>
              </li>
              <li class="breadcrumb-item text-gray-500" aria-current="page">
                {{ pName }}
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </section>
  </the-box>
  <!-- Breadcrumb Section End -->
</template>

<style scoped>

</style>
