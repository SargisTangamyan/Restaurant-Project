import {defineStore} from 'pinia'

// HELPERS
import {sender} from '@/api/Sender.js'

// URLS
import {REGISTER_URL, REDIRECT_URL, LOGIN_URL, LOGOUT_URL} from '@/constants/urls.js'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    userToken: null,
    userName: null,
    userEmail: null,
    userEmailVerified: null,
    userRole: null,
    userImage: null,
  }),

  getters: {
    getIsLoggedIn(state) {
      return !!state.userToken;
    },
    getUserToken(state) {
      return state.userToken;
    },
    getUser(state) {
      return {
        'username': state.userName,
        'email': state.userEmail,
        'role': state.userRole,
        'image': state.userImage,
      }
    }
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
        this.userToken = result.data?.token;
        return {success: true};

      } catch (error) {
        console.log(error.message);
      }
    },

    async verifyEmail(url){
      return await sender.sendGetRequest(url);
    },

    async loginUser(email, password) {
      const response = await sender.sendRequest('POST', LOGIN_URL, {email, password});
      if (response.success) {
        this.userToken = response.data.token;
        this.userName = response.data.user.username;
        this.userEmail = response.data.user.email;
        this.userRole = response.data.user.role;
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
      this.userToken = null;
    }
  },

  persist: true,
});
