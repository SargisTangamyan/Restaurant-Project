<script setup>

import ProfileNavigation from "@/components/profile/ProfileNavigation.vue";
import ProfileHeader from "@/components/profile/ProfileHeader.vue";
</script>

<template>
  <aside class="w-full lg:w-1/4 bg-white shadow-md rounded-xl overflow-hidden flex flex-col gap-6">
    <!-- Profile Box -->
    <profile-header />

    <profile-navigation :links="[
          {routeName: 'categories',
          name: 'Categories'},
        ]">

    </profile-navigation>

  </aside>
</template>

<style scoped>

</style>
