<script setup>
import ProfileBox from '@/components/profile/ProfileBox.vue'
import IngredientList from "@/components/profile/ingredient/IngredientList.vue";
import IngredientForm from "@/components/profile/ingredient/IngredientForm.vue";
</script>

<template>
  <profile-box heading="Manage Ingredients">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <ingredient-list />
      <ingredient-form />

    </div>
  </profile-box>
</template>

<style scoped>

</style>
