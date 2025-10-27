<script setup>
import { reactive, ref } from 'vue';
import { useAuthStore } from '@/stores/index.js';

const emit = defineEmits(['success', 'error']);

const authStore = useAuthStore();
const loading = ref(false);

const form = reactive({
  current_password: '',
  password: '',
  password_confirmation: '',
});

const handleSubmit = async () => {
  authStore.clearErrors();
  loading.value = true;

  try {
    const response = await authStore.updatePassword(form);

    // Reset form
    form.current_password = '';
    form.password = '';
    form.password_confirmation = '';
    if (response.success)
      emit('success', 'Password updated successfully!');
    else {
      emit('error', 'Failed to update password. Please check your current password.');
    }
  } catch (error) {
    emit('error', 'Failed to update password. Please check your current password.');
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Change Password</h2>
    <form @submit.prevent="handleSubmit">
      <div class="space-y-4 max-w-md">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Current Password
          </label>
          <input
            v-model="form.current_password"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <span v-if="authStore.errors.current_password" class="text-red-500 text-sm">
            {{ authStore.errors.current_password[0] }}
          </span>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            New Password
          </label>
          <input
            v-model="form.password"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <div v-if="authStore.errors.password">
            <span v-for="(error, idx) in authStore.errors.password" :key="idx" class="block text-red-500 text-sm">
              -{{ error }}
            </span>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Confirm New Password
          </label>
          <input
            v-model="form.password_confirmation"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="px-6 py-2 bg-cgreen text-white rounded-lg hover:bg-cgreen transition disabled:opacity-50"
        >
          {{ loading ? 'Updating...' : 'Update Password' }}
        </button>
      </div>
    </form>
  </div>
</template>
