<script setup>

// COMPONENTS
import TheBox from "@/components/ui/TheBox.vue";
import PageName from "@/components/ui/PageName.vue";
import ErrorMessage from "@/components/ui/form/ErrorMessage.vue";

// VALIDATION
import {useField, useForm} from 'vee-validate';
import * as yup from 'yup';

// STORES
import {useMessageStore, useAuthStore, useLoadingStore} from "@/stores/index.js"

// INIT
const messageStore = useMessageStore();
const loadingStore = useLoadingStore();
const authStore = useAuthStore();

// VALIDATION SCHEMA
const schema = yup.object({
  email: yup.string().email('Invalid email address').required('Email is required')
});

// FORM SET UP
const {handleSubmit, errors, setErrors, setFieldValue} = useForm({
  validationSchema: schema
});

// FIELDS
const {value: email} = useField('email');

// METHODS
const sendMail = handleSubmit(async () => {
  loadingStore.isLoading = true;
  const response = await authStore.forgotPassword(email.value);
  console.log(response);
  if (response.success) {
    const message = `We have sent a password reset link to email '${email.value}'`
    messageStore.showMessage(message)
  } else {
    setErrors(response.errors)
    const message = response.errors.overall;
    messageStore.showMessage(message, 'error')
  }

  setFieldValue('email', '', false);

  setTimeout(() => {
    loadingStore.isLoading = false;
  }, 250)
})
</script>

<template>
  <page-name p-name="Forgot Password"></page-name>
  <!-- Forgot Password section start -->
  <the-box>
    <div class="w-full flex flex-wrap lg:flex-nowrap px-4">
      <div class="hidden px-4 lg:block lg:w-1/2 xl:w-5/12 ml-auto">
        <div class="flex h-full justify-center">
          <img src="../../assets/images/inner-page/forgot.png"
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

          <form @submit.prevent="sendMail" class="space-y-4">
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
              <input v-model="email" type="email" id="email" placeholder="Email Address"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]">
              <ErrorMessage v-for="(error, id) in errors" :message="error" :key="id"/>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
              Forgot Password
            </button>
          </form>

        </div>
      </div>
    </div>
  </the-box>
  <!-- log in section end -->
</template>

<style scoped>

</style>
