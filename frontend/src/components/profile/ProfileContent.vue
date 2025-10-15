<script setup>

</script>

<template>
  <main class="flex-1 rounded-tl-2xl">
    <div class="bg-white shadow-sm rounded-xl p-6 min-h-[80vh]">
      <router-view v-slot="{ Component }">
        <component :is="Component" v-if="Component" />
        <div v-else class="text-gray-500 text-center mt-10">
          👋 Welcome! Please choose an option from the menu.
        </div>
      </router-view>
    </div>
  </main>
</template>

<style scoped>

</style>
