<script setup>

import ProfileBox from "@/components/profile/ProfileBox.vue";
import HealthSafety from "@/components/profile/HealthSafety.vue";
import lifestylePreferences from "@/components/profile/LifestylePreferences.vue"
</script>

<template>
  <profile-box heading="Dietary Preferences" class="min-h-screen">
    <health-safety class="mb-8"/>
    <lifestyle-preferences />
  </profile-box>
</template>

<style scoped>

</style>
