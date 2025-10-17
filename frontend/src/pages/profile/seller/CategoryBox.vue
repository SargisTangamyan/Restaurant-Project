<script setup>

// COMPONENTS
import CategoryList from '@/components/profile/category/CategoryList.vue'
import CategoryForm from "@/components/profile/category/CategoryForm.vue";
import ProfileBox from "@/components/profile/ProfileBox.vue";

</script>

<template>
  <profile-box heading="Manage Categories">

      <category-list />
      <category-form />

  </profile-box>
</template>

<style scoped>

</style>
