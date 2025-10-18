<script setup>

// COMPONENTS
import CategoryList from '@/components/profile/category/CategoryList.vue'
import CategoryForm from "@/components/profile/category/CategoryForm.vue";
import ProfileBox from "@/components/profile/ProfileBox.vue";

</script>

<template>
  <profile-box heading="Manage Categories">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <category-list />
      <category-form />

    </div>
  </profile-box>
</template>

<style scoped>

</style>
