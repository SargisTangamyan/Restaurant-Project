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
      meta: { requiresAuth: true },
      children: [
        {
          path: 'categories',
          name: 'categories',
          component: () => import('@/pages/profile/seller/CategoryBox.vue'),
          meta: { requiresAuth: true, requiresAdmin: true }
        },
        {
          path: 'ingredients',
          name: 'ingredients',
          component: () => import('@/pages/profile/seller/IngredientBox.vue'),
          meta: { requiresAuth: true, requiresAdmin: true }
        },
        {
          path: 'add-product',
          name: 'add_product',
          component: () => import('@/pages/profile/seller/AddProduct.vue'),
          meta: { requiresAuth: true, requiresAdmin: true }
        },
        {
          path: 'my-orders',
          name: 'my_orders',
          component: () => import('@/components/order/OrderList.vue'),
          meta: { requiresAuth: true }
        },
        {
          path: 'my-orders/:id',
          name: 'order_detail',
          component: () => import('@/components/order/OrderDetail.vue'),
          meta: { requiresAuth: true },
          props: true
        },
        {
          path: 'admin/orders',
          name: 'admin_orders',
          component: () => import('@/components/order/AdminOrderManagement.vue'),
          meta: { requiresAuth: true, requiresAdmin: true }
        },
      ]
    },

    { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
  ],
})

router.beforeEach((to, _, next) => {
  // USING STORE
  const authStore = useAuthStore();

  // Check if user is authenticated
  const isLoggedIn = authStore.isLoggedIn ?? authStore.getIsLoggedIn;

  // Check if user is admin
  const isAdmin = authStore.isAdmin ?? (authStore.user?.role === 'admin');

  // Redirect authenticated users away from auth pages
  if (to.meta.requiresUnauth && isLoggedIn) {
    next('/home');
  }
  // Redirect unauthenticated users to login
  else if (to.meta.requiresAuth && !isLoggedIn) {
    next('/account/login');
  }
  // Redirect non-admin users away from admin pages
  else if (to.meta.requiresAdmin && !isAdmin) {
    next('/home');
  }
  else {
    next();
  }
})

export default router
