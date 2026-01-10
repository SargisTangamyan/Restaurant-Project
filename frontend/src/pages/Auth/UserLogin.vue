<script setup>

// COMPONENTS
import PageName from '@/components/ui/PageName.vue'
import TheBox from '@/components/ui/TheBox.vue'

// VUE
import { ref } from 'vue';

// ROUTER
import { useRouter } from 'vue-router'
const router = useRouter();

// STORE IMPORT
import { useAuthStore } from "@/stores/index.js";

// REFS
const isLoading = ref(false);

// USING STORE
const user = useAuthStore();

// VALIDATION
import { useField, useForm } from 'vee-validate';
import * as yup from 'yup';

// VALIDATION SCHEMA
const schema = yup.object({
  email: yup.string().email('Invalid email address').required('Email is required'),
  password: yup.string().required('Password is required'),
})

// SET UP FORM
const { handleSubmit, errors, setErrors, setFieldValue } = useForm({
  validationSchema: schema,
})

// FIELDS
const { value: email } = useField('email');
const { value: password } = useField('password');

// METHODS
const loginUser = handleSubmit(async (credentials) => {
  isLoading.value = true;

  // Call your Pinia store action
  const result = await user.login({email: credentials.email, password: credentials.password});

  if (result.success) {
    // Redirect to home/dashboard
    await router.replace({ name: 'home' });
  } else if (!result.success && result.errors) {
    setErrors(result.errors);
    setFieldValue('password', '', false);
  }

  isLoading.value = false;
});


</script>

<template>
  <the-loader v-if="isLoading" />

  <page-name p-name="Log In" />

  <the-box>
    <div class="w-full flex flex-wrap lg:flex-nowrap px-4">

      <!-- Left Image -->
      <div class="hidden px-4 lg:block lg:w-1/2 xl:w-5/12 ml-auto">
        <div class="flex h-full justify-center">
          <img src="../../assets/images/inner-page/log-in.png"
               class="w-full max-w-md object-contain"
               alt="Log in illustration">
        </div>
      </div>

      <!-- Form Section -->
      <div class="w-full px-4 sm:w-3/5 lg:w-1/2 xl:w-4/12 mx-auto">
        <div class="bg-white shadow-lg rounded-2xl p-8">

          <!-- Titles -->
          <div class="mb-6 text-center">
            <h3 class="text-2xl font-bold text-gray-800">Welcome To Fastkart</h3>
            <h4 class="text-lg text-gray-600">Log In Your Account</h4>
          </div>

          <!-- Error message -->
          <div v-if="errors.overall" class="mb-4 text-red-500 text-sm text-center">
            {{ errors.overall }}
          </div>

          <!-- Form -->
          <form @submit.prevent="loginUser" class="space-y-4">

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
              <input type="email" placeholder="Email Address"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]"
                     v-model="email">
              <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" placeholder="Password"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]"
                     v-model="password">
              <p v-if="errors.password" class="text-red-600 text-sm mt-1">{{ errors.password }}</p>
            </div>

            <div class="flex justify-end">
              <router-link :to="{name: 'forgot_password'}" class="text-sm text-cgreen hover:underline">
                Forgot Password?
              </router-link>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
              Log In
            </button>
          </form>

          <!-- Divider + Social Login + Sign Up Link -->
          <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-3 text-sm text-gray-500">or</span>
            <div class="flex-grow border-t border-gray-300"></div>
          </div>

          <div class="space-y-3">
            <a href="https://www.google.com/"
               class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
              <img src="../../assets/images/inner-page/google.png" alt="Google" class="w-5 h-5">
              <span>Log In with Google</span>
            </a>
            <a href="https://www.facebook.com/"
               class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
              <img src="../../assets/images/inner-page/facebook.png" alt="Facebook" class="w-5 h-5">
              <span>Log In with Facebook</span>
            </a>
          </div>

          <div class="mt-6 text-center">
            <h4 class="text-gray-600">Don't have an account?</h4>
            <router-link :to="{name: 'register'}" class="text-[#0da487] font-medium hover:underline">Sign Up</router-link>
          </div>

        </div>
      </div>

    </div>
  </the-box>
</template>

<style scoped>
</style>
