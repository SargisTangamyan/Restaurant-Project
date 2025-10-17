<script setup>
import ProfileBox from '@/components/profile/ProfileBox.vue'
import IngredientList from "@/components/profile/ingredient/IngredientList.vue";
import IngredientForm from "@/components/profile/ingredient/IngredientForm.vue";
</script>

<template>
  <profile-box heading="Manage Ingredients">

    <ingredient-list />

    <ingredient-form />

  </profile-box>
</template>

<style scoped>

</style>
