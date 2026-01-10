<script setup>

// VUE
import {onMounted} from "vue";

// COMPONENTS
import TheBox from "@/components/ui/TheBox.vue";
import PageName from "@/components/ui/PageName.vue";
import ErrorMessage from "@/components/ui/form/ErrorMessage.vue";

// STORE
import {useLoadingStore, useAuthStore, useMessageStore} from "@/stores/index.js";

// ROUTE
import {useRoute, useRouter} from "vue-router";

// VALIDATION
import { useField, useForm } from 'vee-validate';
import * as yup from 'yup';

// VALIDATION SCHEMA
const schema = yup.object({
  password: yup.string().min(8, 'Password must be at least 8 characters').required('Password is required'),
  password_confirmation: yup.string()
    .oneOf([yup.ref('password')], 'Passwords must match')
    .required('Please confirm your password')
});

// FORM SET UP
const { handleSubmit, errors, setErrors, setFieldValue } = useForm({
  validationSchema: schema
});

// ROUTE/ROUTER INIT
const route = useRoute();
const router = useRouter();

// STORE INIT
const loaderStore = useLoadingStore();
const authStore = useAuthStore();
const messageStore = useMessageStore();

// INIT
let email;
let token;

// FIELDS
const { value: password } = useField('password');
const { value: password_confirmation } = useField('password_confirmation');

// METHODS
const resetPassword = handleSubmit(async (credentials) => {
  loaderStore.setLoading();
  const data = {
    email,
    token,
    ...credentials
  };

  const response = await authStore.resetPassword(data);
  if (response.success) {
    messageStore.showMessage(response.message);
    await router.push({name: 'login'})
  } else {
    messageStore.showMessage('Failed to Reset Your Password', 'error')
    setFieldValue('password', '', false);
    setFieldValue('password_confirmation', '', false);
    setErrors(response.errors)
  }

  setTimeout(() => {
    loaderStore.setLoading(false);
  }, 250);
});

const ValidateTokenAndEmailOrRedirect = function () {
  email = route.query.email;
  token = route.query.token;

  if (!token || !email)
  {
    router.push({name: 'home'})
  }
}

onMounted(() => {
  ValidateTokenAndEmailOrRedirect()
})
</script>

<template>
  <page-name p-name="Reset Password"></page-name>

  <the-box>
    <div class="w-full flex flex-wrap lg:flex-nowrap px-4">
      <!-- Illustration Section -->
      <div class="hidden px-4 lg:block lg:w-1/2 xl:w-5/12 ml-auto">
        <div class="flex h-full justify-center">
          <img src="../../assets/images/inner-page/forgot.png"
               class="w-full max-w-md object-contain"
               alt="Reset password illustration">
        </div>
      </div>

      <!-- Form Section -->
      <div class="w-full px-4 sm:w-3/5 lg:w-1/2 xl:w-4/12 mx-auto">
        <div class="bg-white shadow-lg rounded-2xl p-8">

          <div class="text-center mb-4">
            <h3 class="text-2xl font-bold text-gray-800">Reset Your Password</h3>
            <h4 class="text-lg text-gray-600">Enter your new credentials</h4>
          </div>

          <div
            v-if="errors?.overall"
            class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-center"
          >
            <p class="text-sm font-medium text-red-600">
              {{ errors.overall }}
            </p>
          </div>

          <form @submit.prevent="resetPassword" class="space-y-4">
            <input
              type="email"
              name="email"
              autocomplete="username"
              value="testadmin@example.com"
              readonly
              hidden
            />
            <!-- New Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
              <input v-model="password" autocomplete="new-password" type="password" id="password" placeholder="New Password"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]">
              <ErrorMessage v-if="errors.password" :message="errors.password" />
            </div>

            <!-- Confirm Password -->
            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
              <input v-model="password_confirmation" autocomplete="new-password" type="password" id="password_confirmation" placeholder="Confirm Password"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]">
              <ErrorMessage v-if="errors.password_confirmation" :message="errors.password_confirmation" />
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
              Reset Password
            </button>
          </form>

        </div>
      </div>
    </div>
  </the-box>
</template>

<style scoped>
</style>
