import { defineStore } from 'pinia';
import { createAuthState } from './state.js';
import { createAuthActions } from './authActions.js';
import { createProfileActions } from './profileActions.js';

export const useAuthStore = defineStore('auth', () => {
  // Initialize state
  const state = createAuthState();

  // Initialize auth actions
  const authActions = createAuthActions(state);

  // Initialize profile actions (pass logout from authActions)
  const profileActions = createProfileActions(state, authActions.logout);

  // Utility functions
  const clearErrors = () => {
    state.errors.value = {};
  };

  const initAuth = async () => {
    if (state.token.value) {
      try {
        await profileActions.loadProfile();
      } catch (error) {
        console.error('Failed to initialize auth:', error);
      }
    }
  };

  // Return all state, computed, and actions
  return {
    // State
    user: state.user,
    token: state.token,
    loading: state.loading,
    errors: state.errors,

    // Computed
    isAuthenticated: state.isAuthenticated,
    isAdmin: state.isAdmin,
    isUser: state.isUser,

    // Auth Actions
    register: authActions.register,
    login: authActions.login,
    logout: authActions.logout,

    // Profile Actions
    loadProfile: profileActions.loadProfile,
    updateProfile: profileActions.updateProfile,
    uploadProfileImage: profileActions.uploadProfileImage,
    deleteProfileImage: profileActions.deleteProfileImage,
    updatePassword: profileActions.updatePassword,
    deleteAccount: profileActions.deleteAccount,

    // Utilities
    clearErrors,
    initAuth,
  };
});
