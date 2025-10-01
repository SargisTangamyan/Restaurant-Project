<script setup lang="ts">

// UI COMPONENTS
import TheBox from '@/components/ui/TheBox.vue';

</script>

<template>
  <!-- Breadcrumb Section Start -->
  <the-box class="bg-gray-100 py-4">
    <section class="breadcrumb-section">
      <div class="container mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
          <!-- Page Title -->
          <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-0">
            Sign In
          </h2>

          <!-- Breadcrumb Navigation -->
          <nav class="text-gray-600" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center space-x-2 sm:space-x-3 text-sm sm:text-base">
              <li class="breadcrumb-item">
                <a href="index.html"
                   class="flex items-center hover:text-gray-900 transition-colors">
                  Home
                </a>
              </li>
              <li class="breadcrumb-item text-gray-500">
                <span>/</span>
              </li>
              <li class="breadcrumb-item text-gray-500" aria-current="page">
                Sign In
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </section>
  </the-box>
  <!-- Breadcrumb Section End -->

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
          <form class="space-y-4">
            <div>
              <label for="fullname" class="block text-sm font-medium text-gray-700">Full Name</label>
              <input type="text" id="fullname" placeholder="Full Name"
                     class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0da487] focus:border-[#0da487]">
            </div>

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

            <!-- Checkbox -->
            <div class="flex items-center">
              <input id="flexCheckDefault" type="checkbox"
                     class="h-4 w-4 bg-white border border-gray-300 rounded">
              <label for="flexCheckDefault" class="ml-2 text-sm text-gray-600">
                I agree with <span class="text-[#0da487] cursor-pointer">Terms</span> and
                <span class="text-[#0da487] cursor-pointer">Privacy</span>
              </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
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
            <a href="https://accounts.google.com/signin/v2/identifier?flowName=GlifWebSignIn&flowEntry=ServiceLogin"
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
            <a href="login.html" class="text-[#0da487] font-medium hover:underline">Log In</a>
          </div>

        </div>
      </div>

    </div>
  </the-box>
  <!-- log in section end -->

</template>

<style scoped>

</style>
