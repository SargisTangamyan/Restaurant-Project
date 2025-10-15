<script setup>

// COMPONENTS
import PageName from "@/components/ui/PageName.vue";
import TheBox from "@/components/ui/TheBox.vue";
import ProfileColumn from "@/components/profile/ProfileColumn.vue";
import ProfileContent from "@/components/profile/ProfileContent.vue";

</script>

<template>
  <page-name p-name="Seller" />
  <the-box>
    <div class="flex gap-4 flex-col lg:flex-row ">
      <!-- Left Sidebar -->
      <profile-column />

      <profile-content />
    </div>

  </the-box>

</template>

<style scoped>

</style>
