// ROUTER
import { createRouter, createWebHistory } from 'vue-router'

// STORE
import {useAuthStore} from "@/stores/index.js";

// PAGES
import HomePage from "@/pages/HomePage.vue";
import NotFound from "@/pages/NotFound.vue";

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
      meta: {requiresUnauth: true},
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
      path: '/verify-email',
      name: 'verify_email',
      component: () => import('@/pages/VerifyEmail.vue'),
    },
    {
      path: '/dishes/:id',
      name: 'dish',
      component: () => import ('@/pages/ProductDetail.vue'),
      props: true,
    },
    {
      path: '/dishes',
      name: 'dishes',
      component: () => import('@/pages/MenuPage.vue'),
    },
    {
      path: '/wishlist',
      name: 'wishlist',
      component: () => import('@/pages/WishList.vue'),
    },
    {
      path: '/cart',
      name: 'cart',
      component: () => import('@/pages/TheCart.vue'),
    },
    {
      path: '/payment/success',
      name: 'payment_success',
      component: () => import('@/pages/payment/PaymentSuccess.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/payment/cancel',
      name: 'payment_cancel',
      component: () => import('@/pages/payment/PaymentCancel.vue'),
      meta: { requiresAuth: true },
    },
    {
      path: '/user',
      name: 'user',
      component: () => import('@/pages/profile/UserDashboard.vue'),
      children: [
        {path: 'categories', name: 'categories', component: () => import('@/pages/profile/seller/CategoryBox.vue')},
        {path: 'ingredients', name: 'ingredients', component: () => import('@/pages/profile/seller/IngredientBox.vue')},
        {path: 'add-product', name: 'add_product', component: () => import('@/pages/profile/seller/AddProduct.vue')},
        {path: 'my-orders', name: 'my_orders', component: () => import('@/components/order/OrderList.vue'), meta: { requiresAuth: true }},
        {path: 'my-orders/:id', name: 'order_detail', component: () => import('@/components/order/OrderDetail.vue'), meta: { requiresAuth: true }},
      ]
    },

    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
  ],
})

router.beforeEach((to, _, next) => {
  // USING STORE
  const authStore = useAuthStore();

  if (to.meta.requiresUnauth && authStore.getIsLoggedIn)
  {
    next('/home');
  } else if (to.meta.requiresAuth && !authStore.getIsLoggedIn) {
    next('/account/login');
  } else {
    next();
  }
})

export default router
