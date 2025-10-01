<script setup>
import PageName from '@/components/ui/PageName.vue'
import TheBox from '@/components/ui/TheBox.vue'
</script>

<template>
  <page-name p-name="Log In"></page-name>

  <!-- log in section start -->
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

          <!-- Form -->
          <form class="space-y-4">
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
              <input type="email" id="email" placeholder="Email Address"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]">
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" id="password" placeholder="Password"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]">
            </div>

            <!-- Checkbox + Forgot Password -->
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input id="flexCheckDefault" type="checkbox"
                       class="h-4 w-4 bg-white border border-gray-300 rounded accent-blue-600">
                <label for="flexCheckDefault" class="ml-2 text-sm text-gray-600">Remember me</label>
              </div>
              <router-link :to="{name: 'forgot_password'}" class="text-sm text-[#0da487] hover:underline">Forgot Password?</router-link>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
              Log In
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

          <!-- Sign Up Link -->
          <div class="mt-6 text-center">
            <h4 class="text-gray-600">Don't have an account?</h4>
            <router-link :to="{name: 'register'}" class="text-[#0da487] font-medium hover:underline">Sign Up</router-link>
          </div>

        </div>
      </div>

    </div>
  </the-box>
  <!-- log in section end -->

</template>

<style scoped>

</style>
