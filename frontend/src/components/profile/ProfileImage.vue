<script setup>
import { ref, computed } from 'vue';
import { useAuthStore } from '@/stores/index.js';
import { useMessageStore } from "@/stores/index.js";

// COMPONENTS
import ProfileImageDisplay from "@/components/profile/ProfileImageDisplay.vue";
import ConfirmDialog from "@/components/ui/ConfirmDialog.vue";

const emit = defineEmits(['success', 'error']);

const authStore = useAuthStore();
const messageStore = useMessageStore()


const imageInput = ref(null);
const uploading = ref(false);
const deleting = ref(false);

const imageUrl = computed(() => authStore.user?.profile_image);

const handleImageUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  // Validate file size (2MB)
  if (file.size > 2 * 1024 * 1024) {
    emit('error', 'Image size must be less than 2MB');
    return;
  }

  uploading.value = true;

  try {
    await authStore.uploadProfileImage(file);
    emit('success', 'Profile image uploaded successfully!');
    // Reset input
    if (imageInput.value) {
      imageInput.value.value = '';
    }
  } catch (error) {
    emit('error', 'Failed to upload image. Please try again.');
  } finally {
    uploading.value = false;
  }
};

const handleDeleteImage = async () => {
  const confirmed = await messageStore.showConfirm({
    title: 'Remove Profile Image',
    message: 'Are you sure you want to delete your profile picture?',
    confirmText: 'Yes, Remove',
    cancelText: 'Cancel',
    type: 'danger',
    onConfirm: async () => {
      deleting.value = true
      try {
        await authStore.deleteProfileImage()
        emit('success', 'Profile image removed successfully!')
      } catch (error) {
        emit('error', 'Failed to delete image. Please try again.')
      } finally {
        deleting.value = false
      }
    }
  })

  if (!confirmed) {
    emit('error', 'Action cancelled.')
  }
};
</script>

<template>
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Profile Picture</h2>
    <div class="flex items-center space-x-6">
      <profile-image-display />
      <div class="flex-1">
        <input
          ref="imageInput"
          type="file"
          accept="image/*"
          class="hidden"
          @change="handleImageUpload"
        />
        <button
          @click="$refs.imageInput.click()"
          :disabled="uploading"
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50 mr-2"
        >
          {{ uploading ? 'Uploading...' : 'Upload New Image' }}
        </button>
        <button
          v-if="imageUrl"
          @click="handleDeleteImage"
          :disabled="deleting"
          class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition disabled:opacity-50"
        >
          {{ deleting ? 'Removing...' : 'Remove Image' }}
        </button>
        <p class="text-sm text-gray-500 mt-2">
          JPG, PNG or GIF. Max size 2MB.
        </p>
      </div>
    </div>

    <confirm-dialog
      :show="messageStore.confirmDialog.show"
      :title="messageStore.confirmDialog.title"
      :message="messageStore.confirmDialog.message"
      :confirm-text="messageStore.confirmDialog.confirmText"
      :cancel-text="messageStore.confirmDialog.cancelText"
      :type="messageStore.confirmDialog.type"
      :loading="messageStore.confirmDialog.loading"
      @confirm="messageStore.confirmDialog.onConfirm"
      @cancel="messageStore.confirmDialog.onCancel"
    />
  </div>
</template>
