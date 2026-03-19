import { useRouter } from 'vue-router';
import {
  useAuthStore,
  useMessageStore,
  useLoadingStore
} from '@/stores/index.js';

export function useAuthActions() {
  const router = useRouter();
  const authStore = useAuthStore();
  const loadingStore = useLoadingStore();
  const messageStore = useMessageStore();

  const logout = async () => {
    // Start Loading
    loadingStore.startLoading();

    try {
      // Call auth store logout
      await authStore.logout();

      // Redirect to homepage
      await router.replace({ name: 'home' });

      // Show a success message
      await messageStore.showMessageAdnWaitUntilVisible('You have been logged out successfully', 'success');
    } catch (error) {
      console.error('Logout error:', error);
      await router.push({ name: 'home' })

      await messageStore.showMessageAdnWaitUntilVisible('An error occurred during logout', 'error');
    } finally {
      loadingStore.stopLoading();
    }
  };

  return {
    logout,
  };
}
