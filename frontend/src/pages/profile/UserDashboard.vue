<script setup>

// COMPONENTS
import PageName from "@/components/ui/PageName.vue";
import TheBox from "@/components/ui/TheBox.vue";
import ProfileHeader from "@/components/profile/ProfileHeader.vue";

</script>

<template>
  <page-name p-name="Seller" />
  <the-box>
    <div class="flex gap-4 flex-col lg:flex-row min-h-screen ">
      <!-- Left Sidebar -->
      <aside class="w-full lg:w-1/4 bg-white shadow-md flex flex-col gap-6">
        <!-- Profile Box -->
        <profile-header />

        <!-- Navigation -->
        <nav class="flex flex-col gap-2">
          <a href="#pills-dashboard" class="flex items-center gap-2 p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
            <i data-feather="home" class="w-4 h-4"></i> Dashboard
          </a>

          <button class="flex items-center gap-2 p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
            <i data-feather="shopping-bag" class="w-4 h-4"></i> Products
          </button>

          <button class="flex items-center gap-2 p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
            <i data-feather="shopping-cart" class="w-4 h-4"></i> Orders
          </button>

          <button class="flex items-center gap-2 p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
            <i data-feather="user" class="w-4 h-4"></i> Profile
          </button>

          <button class="flex items-center gap-2 p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
            <i data-feather="settings" class="w-4 h-4"></i> Settings
          </button>

          <button class="flex items-center gap-2 p-3 rounded-lg text-red-600 hover:bg-red-50 transition">
            <i data-feather="log-out" class="w-4 h-4"></i> Log Out
          </button>
        </nav>
      </aside>

      <!-- Right Content -->
      <main class="flex-1 rounded-tl-2xl">
        <div class="bg-white shadow-sm rounded-xl p-6 min-h-[80vh]">
          <router-view />
        </div>
      </main>
    </div>

  </the-box>

</template>

<style scoped>

</style>
