import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/index.js';
import { useMessageStore } from '@/stores/index.js';

export function useAuthActions() {
  const router = useRouter();
  const authStore = useAuthStore();
  const messageStore = useMessageStore();

  const logout = async () => {
    try {
      // Redirect to homepage
      await router.push({ name: 'home' });

      // Call auth store logout
      await authStore.logout();

      // Show success message
      messageStore.showMessage('You have been logged out successfully', 'success');
    } catch (error) {
      console.error('Logout error:', error);
      messageStore.showMessage('An error occurred during logout', 'error');
    }
  };

  return {
    logout,
  };
}
