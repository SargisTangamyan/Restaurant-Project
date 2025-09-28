import { createRouter, createWebHistory } from 'vue-router'

// PAGES
import UserRegistration from '@/pages/Auth/UserRegistration.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {path: '/account/register', name: 'register', component: UserRegistration},
  ],
})

export default router
