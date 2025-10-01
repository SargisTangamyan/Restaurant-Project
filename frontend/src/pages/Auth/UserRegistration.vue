<script setup>

// VUE
import { ref } from 'vue';

// STORE IMPORT
import {useAuthStore} from "@/stores/index.js";

// REFS
const isLoading = ref(false);

// USING STORE
const user = useAuthStore();

// UI COMPONENTS
import TheBox from '@/components/ui/TheBox.vue';
import PageName from '@/components/ui/PageName.vue';

// VALIDATION
import {useField, useForm} from 'vee-validate';
import * as yup from 'yup';

// VALIDATION SCHEMA
const schema = yup.object({
  email: yup.string().email('Invalid email address').required('Email is required'),
  password: yup.string().min(8, 'Password must be at least 8 characters')
    .matches(
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/,
      'Password must contain uppercase, lowercase, number, and special character'
    )
    .required('Password is required'),
  passwordConfirm: yup.string().oneOf([yup.ref('password')], 'Passwords do not match').required('Password Confirmation is required'),
  agree: yup.boolean().oneOf([true], 'You must agree the Terms and Privacy')
})

// SET UP FORM
const {handleSubmit, errors, setErrors} = useForm({
  validationSchema: schema,
})

// FIELDS
const {value: email} = useField('email');
const {value: password} = useField('password');
const {value: passwordConfirm} = useField('passwordConfirm');
const {value: agree} = useField('agree');

// METHODS
const registerUser = handleSubmit(async ({email, password, passwordConfirm}) => {
  isLoading.value = true;
  const result = await user.registerUser(email, password, passwordConfirm);
  console.log(result);
  const serverErrors = {};
  if (!result.success && result.errors) {
    for (const field in result.errors) {
      serverErrors[field] = result.errors[field];
    }
    setErrors(serverErrors);
  }
  isLoading.value = false;
})

</script>

<template>
  <the-loader v-if="isLoading" />

  <page-name p-name="Sign Up"/>

  <!-- log in section start -->
  <the-box>
    <div class="w-full flex flex-wrap lg:flex-nowrap">

      <!-- Left Image -->
      <div class="hidden px-4 lg:block lg:w-1/2 xl:w-5/12 ml-auto">
        <div class="flex h-full justify-center">
          <img src="../../assets/images/inner-page/sign-up.png"
               class="w-full max-w-md object-contain"
               alt="Sign up illustration">
        </div>
      </div>

      <!-- Form Section -->
      <div class="w-full px-4 sm:w-3/5 lg:w-1/2 xl:w-4/12 mx-auto">
        <div class="bg-white shadow-lg rounded-2xl p-8">

          <!-- Titles -->
          <div class="mb-6 text-center">
            <h3 class="text-2xl font-bold text-gray-800">Welcome To Fastkart</h3>
            <h4 class="text-lg text-gray-600">Create New Account</h4>
          </div>

          <!-- Form -->
          <form @submit.prevent="registerUser" class="space-y-4">

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email
                Address</label>
              <input type="email" placeholder="Email Address"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]"
                     v-model="email"
              >
              <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email }}</p>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" placeholder="Password"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]"
                     v-model="password"
              >
              <p v-if="errors.password" class="text-red-600 text-sm mt-1">{{ errors.password }}</p>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password
                Confirmation</label>
              <input type="password" placeholder="Password"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]"
                     v-model="passwordConfirm"
              >
              <p v-if="errors.passwordConfirm" class="text-red-600 text-sm mt-1">
                {{ errors.passwordConfirm }}</p>
            </div>

            <!-- Checkbox -->
            <div class="flex items-center">
              <input type="checkbox" id="agree"
                     class="h-4 w-4 bg-white border border-gray-300 rounded"
                     v-model="agree" name="agree"
              >
              <label for="agree" class="ml-2 text-sm text-gray-600">
                I agree with <span class="text-[#0da487] cursor-pointer">Terms</span> and
                <span class="text-[#0da487] cursor-pointer">Privacy</span>
              </label>
              <p v-if="errors.agree" class="text-red-600 text-sm mt-1">{{ errors.agree }}</p>
            </div>

            <!-- Submit Button -->
            <button
              type="submit"
              :disabled="!agree"
              class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition disabled:bg-gray-300 disabled:cursor-not-allowed"
            >
              Sign Up
            </button>
          </form>

          <!-- Divider -->
          <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="mx-3 text-sm text-gray-500">or</span>
            <div class="flex-grow border-t border-gray-300"></div>
          </div>

          <!-- Social Login -->
          <div class="space-y-3">
            <a
              href="https://accounts.google.com/signin/v2/identifier?flowName=GlifWebSignIn&flowEntry=ServiceLogin"
              class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
              <img src="../../assets/images/inner-page/google.png" alt="Google" class="w-5 h-5">
              <span>Sign up with Google</span>
            </a>
            <a href="https://www.facebook.com/"
               class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2 hover:bg-gray-50 transition">
              <img src="../../assets/images/inner-page/facebook.png" alt="Facebook" class="w-5 h-5">
              <span>Sign up with Facebook</span>
            </a>
          </div>

          <!-- Already have account -->
          <div class="mt-6 text-center">
            <h4 class="text-gray-600">Already have an account?</h4>
            <router-link :to="{name: 'login'}" class="text-[#0da487] font-medium hover:underline">
              Log In
            </router-link>
          </div>

        </div>
      </div>

    </div>
  </the-box>
  <!-- log in section end -->

</template>

<style scoped>

</style>
