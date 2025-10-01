import { createRouter, createWebHistory } from 'vue-router'

// PAGES
import UserRegistration from '@/pages/Auth/UserRegistration.vue'
import UserLogin from "@/pages/Auth/UserLogin.vue";
import ForgotPassword from "@/pages/Auth/ForgotPassword.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/account',
      children: [
        {
          path: 'register',
          name: 'register',
          component: UserRegistration,
        },
        {
          path: 'login',
          name: 'login',
          component: UserLogin,
        },
        {
          path: 'forgot-password',
          name: 'forgot_password',
          component: ForgotPassword,
        }
      ]
    },
  ],
})

export default router
