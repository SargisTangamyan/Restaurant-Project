import { createRouter, createWebHistory } from 'vue-router'

// PAGES
import HomePage from "@/pages/HomePage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      redirect: 'home',
    },
    {
      path: '/home',
      name: 'home',
      component: HomePage,
    },
    {
      path: '/account',
      children: [
        {
          path: 'register',
          name: 'register',
          component: () => import('@/pages/Auth/UserRegistration.vue'),
        },
        {
          path: 'login',
          name: 'login',
          component: () => import('@/pages/Auth/UserLogin.vue'),
        },
        {
          path: 'forgot-password',
          name: 'forgot_password',
          component: () => import('@/pages/Auth/ForgotPassword.vue'),

        }
      ]
    },
    {
      path: '/verification-success',
      name: 'verification_success',
      component: () => import('@/pages/VerificationSuccess.vue')
    }
  ],
})

export default router
