import { ref, computed } from 'vue';

export function createAuthState() {
  const user = ref(null);
  const token = ref(localStorage.getItem('auth_token') || null);
  const loading = ref(false);
  const errors = ref({});

  // Computed properties
  const isAuthenticated = computed(() => !!token.value && !!user.value);
  const isAdmin = computed(() => user.value?.role === 'admin');
  const isUser = computed(() => user.value?.role === 'user');

  return {
    user,
    token,
    loading,
    errors,
    isAuthenticated,
    isAdmin,
    isUser,
  };
}
