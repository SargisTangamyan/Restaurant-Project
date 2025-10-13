<script setup>

// COMPONENTS
import CategoryList from '@/components/category/CategoryList.vue'
import CategoryForm from "@/components/category/CategoryForm.vue";

</script>

<template>
  <main class="flex-1 bg-white rounded-xl shadow-md p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Categories</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <category-list />
      <category-form />

    </div>
  </main>
</template>

<style scoped>

</style>
