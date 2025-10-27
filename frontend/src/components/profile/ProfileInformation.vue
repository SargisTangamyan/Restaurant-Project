<script setup>
import { reactive, watch } from 'vue';
import { useAuthStore } from '@/stores/index.js';

const emit = defineEmits(['success', 'error']);

const authStore = useAuthStore();

const form = reactive({
  username: '',
  first_name: '',
  last_name: '',
  phone_number: '',
  city: '',
  address: '',
});

// Watch for profile data changes and populate form
watch(() => authStore.user, (newUser) => {
  if (newUser) {
    form.username = newUser.username || '';
    form.first_name = newUser.first_name || '';
    form.last_name = newUser.last_name || '';
    form.phone_number = newUser.phone_number || '';
    form.city = newUser.city || '';
    form.address = newUser.address || '';
  }
}, { immediate: true });

const handleSubmit = async () => {
  authStore.clearErrors();

  try {
    await authStore.updateProfile(form);
    emit('success', 'Profile updated successfully!');
  } catch (error) {
    emit('error', 'Failed to update profile. Please check the form.');
  }
};
</script>

<template>
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
    <form @submit.prevent="handleSubmit">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Username
          </label>
          <input
            v-model="form.username"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <span v-if="authStore.errors.username" class="text-red-500 text-sm">
            {{ authStore.errors.username[0] }}
          </span>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Email (read-only)
          </label>
          <input
            :value="authStore.user?.email"
            type="email"
            disabled
            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            First Name
          </label>
          <input
            v-model="form.first_name"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <span v-if="authStore.errors.first_name" class="text-red-500 text-sm">
            {{ authStore.errors.first_name[0] }}
          </span>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Last Name
          </label>
          <input
            v-model="form.last_name"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <span v-if="authStore.errors.last_name" class="text-red-500 text-sm">
            {{ authStore.errors.last_name[0] }}
          </span>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Phone Number
          </label>
          <input
            v-model="form.phone_number"
            type="tel"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <span v-if="authStore.errors.phone_number" class="text-red-500 text-sm">
            {{ authStore.errors.phone_number[0] }}
          </span>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            City
          </label>
          <input
            v-model="form.city"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <span v-if="authStore.errors.city" class="text-red-500 text-sm">
            {{ authStore.errors.city[0] }}
          </span>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Address
          </label>
          <input
            v-model="form.address"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <span v-if="authStore.errors.address" class="text-red-500 text-sm">
            {{ authStore.errors.address[0] }}
          </span>
        </div>
      </div>

      <div class="mt-6">
        <button
          type="submit"
          :disabled="authStore.loading"
          class="px-6 py-2 bg-cgreen text-white rounded-lg hover:bg-cgreen transition disabled:opacity-50"
        >
          {{ authStore.loading ? 'Saving...' : 'Save Changes' }}
        </button>
      </div>
    </form>
  </div>
</template>
