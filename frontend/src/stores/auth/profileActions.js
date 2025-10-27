import { sender } from '@/api/Sender.js';
import {
  PROFILE_GET,
  PROFILE_UPDATE,
  PROFILE_IMAGE_UPLOAD,
  PROFILE_IMAGE_DELETE,
  PROFILE_PASSWORD_UPDATE,
  PROFILE_DELETE,
} from '@/constants/urls.js';
import { createAuthActions } from "@/stores/auth/authActions.js";

export function createProfileActions(state, logout) {
  const loadProfile = async () => {
    if (!state.token.value) {
      return null;
    }

    state.loading.value = true;
    state.errors.value = {};

    try {
      const response = await sender.sendRequest('GET', PROFILE_GET);
      state.user.value = response.data.user;
      return response.data;
    } catch (error) {
      console.error('Failed to load profile:', error);

      // If unauthorized, clear auth state
      if (error.response?.status === 401) {
        await logout();
      }

      throw error;
    } finally {
      state.loading.value = false;
    }
  };

  const updateProfile = async (profileData) => {
    state.loading.value = true;
    state.errors.value = {};

    try {
      const response = await sender.sendRequest('PUT', PROFILE_UPDATE, profileData);
      state.user.value = response.data.user;
      return response.data;
    } catch (error) {
      if (error.response?.data?.errors) {
        state.errors.value = error.response.data.errors;
      }
      throw error;
    } finally {
      state.loading.value = false;
    }
  };

  const uploadProfileImage = async (file) => {
    const formData = new FormData();
    formData.append('image', file);

    try {
      const response = await sender.sendRequest('POST', PROFILE_IMAGE_UPLOAD, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });

      if (state.user.value) {
        state.user.value.profile_image = response.data.profile_image;
      }

      return response.data;
    } catch (error) {
      console.error('Failed to upload image:', error);
      throw error;
    }
  };

  const deleteProfileImage = async () => {
    try {
      const response = await sender.sendRequest('DELETE', PROFILE_IMAGE_DELETE);

      if (state.user.value) {
        state.user.value.profile_image = null;
      }

      return response.data;
    } catch (error) {
      console.error('Failed to delete image:', error);
      throw error;
    }
  };

  const updatePassword = async (passwordData) => {
    state.errors.value = {};

    try {
      const response = await sender.sendRequest('PUT', PROFILE_PASSWORD_UPDATE, passwordData);
      if (!response.success) {
        state.errors.value = response.errors;
      }
      return response;
    } catch (error) {
      if (error.response?.data?.errors) {
        state.errors.value = error.response.data.errors;
      }
      throw error;
    }
  };

  const deleteAccount = async (password) => {
    state.errors.value = {};

    try {
      const response = await sender.sendRequest('POST', PROFILE_DELETE, { password });

      if (response.success) {
        const {logout} = createAuthActions(state);
        await logout();
      } else {
        state.errors.value = response.errors;
      }
      return response;
    } catch (error) {
      if (error.response?.data?.errors) {
        state.errors.value = error.response.data.errors;
      }
      throw error;
    }
  };

  return {
    loadProfile,
    updateProfile,
    uploadProfileImage,
    deleteProfileImage,
    updatePassword,
    deleteAccount,
  };
}
