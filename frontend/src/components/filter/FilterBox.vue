<script setup>
</script>

<template>
  <div class="flex flex-col gap-4 mb-4">
    <div class="flex items-center justify-between">
      <slot name="header"/>
    </div>
    <div>
      <slot />
    </div>
  </div>
</template>

<style scoped>

</style>
