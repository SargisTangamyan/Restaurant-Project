<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/index.js';

const emit = defineEmits(['success', 'error']);

const router = useRouter();
const authStore = useAuthStore();

const showModal = ref(false);
const password = ref('');
const loading = ref(false);

const closeModal = () => {
  showModal.value = false;
  password.value = '';
  authStore.clearErrors();
};

const handleDelete = async () => {
  if (!password.value) {
    emit('error', 'Please enter your password');
    return;
  }

  authStore.clearErrors();
  loading.value = true;

  try {
    const response = await authStore.deleteAccount(password.value);
    if (response.success) {
      emit('success', 'Account deleted successfully');
      await router.push('/');
    } else {
      password.value = '';
    }
  } catch (error) {
    emit('error', 'Failed to delete account. Please check your password.');
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="bg-white rounded-lg shadow p-6 border-2 border-red-200">
    <h2 class="text-xl font-semibold text-red-600 mb-4">Delete Account</h2>
    <p class="text-gray-600 mb-4">
      Once you delete your account, there is no going back. Please be certain.
    </p>
    <button
      @click="showModal = true"
      class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
    >
      Delete My Account
    </button>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-gray-200 bg-opacity-50 flex items-center justify-center z-50"
      @click.self="closeModal"
    >
      <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-xl font-semibold mb-4">Confirm Account Deletion</h3>
        <p class="text-gray-600 mb-4">
          Please enter your password to confirm account deletion. This action cannot be undone.
        </p>
        <form @submit.prevent="handleDelete">
          <input
            v-model="password"
            type="password"
            placeholder="Enter your password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-red-500 focus:border-transparent"
          />
          <span v-if="authStore.errors.password" class="text-red-500 text-sm block mb-4">
            {{ authStore.errors.password[0] }}
          </span>
          <div class="flex justify-end space-x-3">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="loading"
              class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition disabled:opacity-50"
            >
              {{ loading ? 'Deleting...' : 'Delete Account' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
