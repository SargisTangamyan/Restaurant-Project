<script setup>
import { onMounted} from 'vue';
import {useAuthStore} from '@/stores/index.js';
import ProfileImage from '@/components/profile/ProfileImage.vue';
import ProfileInformation from '@/components/profile/ProfileInformation.vue';
import ChangePassword from '@/components/profile/ChangePassword.vue';
import DeleteAccount from '@/components/profile/DeleteAccount.vue';
import ProfileBox from "@/components/profile/ProfileBox.vue";
import { useMessageStore } from "@/stores/index.js";

const messageStore = useMessageStore();
const authStore = useAuthStore();

const showSuccess = (msg) => {
  messageStore.showMessage(msg);
};

const showError = (msg) => {
  messageStore.showMessage(msg, 'error');
};

onMounted(async () => {
  try {
    await authStore.loadProfile();
  } catch (error) {
    showError('Failed to load profile');
  }
});
</script>

<template>
  <profile-box heading="My Profile" class="min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-8">My Profile</h1>

      <div v-if="authStore.loading && !authStore.user" class="py-12 text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-gray-900 mx-auto"></div>
        <p class="mt-4 text-gray-600">Loading profile...</p>
      </div>

      <template v-else>
        <!-- Profile Image Section -->
        <div class="mb-6">
          <ProfileImage
            @success="showSuccess"
            @error="showError"
          />
        </div>

        <!-- Profile Information Form -->
        <div class="mb-6">
          <ProfileInformation
            @success="showSuccess"
            @error="showError"
          />
        </div>

        <!-- Change Password Section -->
        <div class="mb-6">
          <ChangePassword
            @success="showSuccess"
            @error="showError"
          />
        </div>

        <!-- Delete Account Section -->
        <DeleteAccount
          @success="showSuccess"
          @error="showError"
        />
      </template>

    </div>
  </profile-box>
</template>
