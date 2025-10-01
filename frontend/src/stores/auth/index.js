import {defineStore} from 'pinia'

// URLS
import {REGISTER_URL} from '@/constants/urls.js'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    userToken: null,
  }),

  getters: {
    getIsLoggedIn(state) {
      return !!state.userToken;
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
            password_confirmation: passwordConfirm
          }),
        });

        if (!response.ok) {
          const errorData = await response.json();
          return {success: false, errors: errorData.errors};
        }

        const result = await response.json();
        this.userToken = result.data?.token;
        return {success: true};

      } catch (error) {
        console.log(error.message);
      }
    }
  }
});
