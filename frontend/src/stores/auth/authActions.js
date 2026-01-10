import { sender } from '@/api/Sender.js';
import {
  REGISTER_URL,
  LOGIN_URL,
  LOGOUT_URL,
  REDIRECT_URL,
  FORGOT_PASSWORD,
  RESET_PASSWORD,
  RESET_PASSWORD_REDIRECT,
} from '@/constants/urls.js';

export function createAuthActions(state) {
  const register = async (email, password, passwordConfirm) => {
    state.loading.value = true;
    state.errors.value = {};

    try {
      const response = await sender.sendRequest('POST', REGISTER_URL, {
        email,
        password,
        password_confirmation: passwordConfirm,
        redirect_url: REDIRECT_URL,
      });
      console.log(response)

      if (response.data && response.data.token) {
        state.token.value = response.data.token;
        state.user.value = response.data.user;
        localStorage.setItem('auth_token', response.data.token);

        return { success: true, data: response.data };
      }

      return { success: false, errors: response.errors };
    } catch (error) {
      const errors = {};

      if (error.response?.data?.errors) {
        // Laravel validation errors
        Object.keys(error.response.data.errors).forEach(key => {
          errors[key] = error.response.data.errors[key][0];
        });
      } else if (error.response?.data?.message) {
        errors.overall = error.response.data.message;
      } else {
        errors.overall = 'Registration failed. Please try again.';
      }

      state.errors.value = error.response?.data?.errors || {};
      return { success: false, errors };
    } finally {
      state.loading.value = false;
    }
  };

  const login = async (credentials) => {
    state.loading.value = true;
    state.errors.value = {};

    try {
      const response = await sender.sendRequest('POST', LOGIN_URL, credentials);

      if (response.data.token) {
        state.token.value = response.data.token;
        state.user.value = response.data.user;
        localStorage.setItem('auth_token', response.data.token);

        return { success: true, data: response.data };
      }

      return { success: false, errors: { overall: 'Login failed' } };
    } catch (error) {
      const errors = {};

      if (error.response?.status === 401) {
        errors.overall = 'Invalid email or password';
      } else if (error.response?.data?.errors) {
        // Laravel validation errors
        Object.keys(error.response.data.errors).forEach(key => {
          errors[key] = error.response.data.errors[key][0];
        });
      } else if (error.response?.data?.message) {
        errors.overall = error.response.data.message;
      } else {
        errors.overall = 'Login failed. Please try again.';
      }

      state.errors.value = error.response?.data?.errors || {};
      return { success: false, errors };
    } finally {
      state.loading.value = false;
    }
  };

  const logout = async () => {
    try {
      await sender.sendRequest('DELETE', LOGOUT_URL);
    } catch (error) {
      console.error('Logout error:', error);
    } finally {
      state.user.value = null;
      state.token.value = null;
      localStorage.removeItem('auth_token');
    }
  };

  const verifyEmail = async function (url){
    return await sender.sendRequest('GET', url);
  }

  const forgotPassword = async function (email) {
    state.loading.value = true;
    state.errors.value = {};

    try {
      const response = await sender.sendRequest('POST', FORGOT_PASSWORD, {email, 'redirect_url': RESET_PASSWORD_REDIRECT});

      if (response.success) {
        console.log('From authActions.js: Success')
        return { success: true };
      }

      return { success: false, errors: { overall: 'Failed to send the reset link' } };
    } catch (error) {
      const errors = {};

      if (error.response?.data?.errors) {
        // Laravel validation errors
        Object.keys(error.response.data.errors).forEach(key => {
          errors[key] = error.response.data.errors[key][0];
        });
      } else {
        errors.overall = 'We are having a trouble sending your password reset link. Please try again.';
      }

      state.errors.value = error.response?.data?.errors || {};
      return { success: false, errors };
    } finally {
      state.loading.value = false;
    }
  };

  const resetPassword = async function (payload)
  {
    const response = await sender.sendRequest('POST', RESET_PASSWORD, {
      token: payload.token,
      email: payload.email,
      password: payload.password,
      password_confirmation: payload.password_confirmation,
    });

    if (response.success) {
      return {success: true, message: response.message || 'Password reset successfully.'};
    } else {
      return {success: false, errors: response.errors};
    }
  }

  return {
    register,
    login,
    logout,
    verifyEmail,
    forgotPassword,
    resetPassword,
  };
}
