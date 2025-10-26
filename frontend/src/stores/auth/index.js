import {defineStore} from 'pinia'

// HELPERS
import {sender} from '@/api/Sender.js'

// URLS
import {REGISTER_URL, REDIRECT_URL, LOGIN_URL, LOGOUT_URL} from '@/constants/urls.js'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: null,
    user: null, // { id, username, email, role, image, emailVerified }
  }),

  getters: {
    // Backward compatible getters
    getIsLoggedIn(state) {
      return !!state.token;
    },
    getUserToken(state) {
      return state.token;
    },
    getUser(state) {
      return state.user ?? {};
    },
    // Convenience getters
    isLoggedIn(state) {
      return !!state.token;
    },
    isAdmin(state) {
      return state.user?.role === 'admin';
    },
  },

  actions: {
    async registerUser(email, password, passwordConfirm) {
      try {
        const response = await fetch(REGISTER_URL, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          body: JSON.stringify({
            email,
            password,
            password_confirmation: passwordConfirm,
            redirect_url: REDIRECT_URL,
          }),
        });

        if (!response.ok) {
          const errorData = await response.json();
          return {success: false, errors: errorData.errors};
        }

        const result = await response.json();
        this.token = result.data?.token ?? null;
        // user may be null until verification/login
        return {success: true};

      } catch (error) {
        console.log(error.message);
        return { success: false, errors: { overall: [error.message] } };
      }
    },

    async verifyEmail(url){
      return await sender.sendGetRequest(url);
    },

    async loginUser(email, password) {
      const response = await sender.sendRequest('POST', LOGIN_URL, {email, password});
      if (response.success) {
        const data = response.data;
        this.token = data.token;
        this.user = {
          id: data.user.id,
          username: data.user.username,
          email: data.user.email,
          role: data.user.role,
          image: data.user.image ?? null,
          emailVerified: data.user.emailVerified ?? data.user.email_verified ?? null,
        };
        return {success: true};
      }
      return {
        success: false,
        errors: {
          overall: response.errors
        }
      };
    },

    async logoutUser() {
      const response = await sender.sendRequest('DELETE', LOGOUT_URL);
      console.log(response);
      this.token = null;
      this.user = null;
    }
  },

  persist: true,
});
