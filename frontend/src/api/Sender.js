import { useAuthStore } from '@/stores/index.js'

class Sender {
  #headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }

  #tokenSet = false;

  #trySettingToken() {
    if (this.#tokenSet) return;
    const authStore = useAuthStore();
    const token = authStore.token;
    if (token) {
      this.#headers['Authorization'] = `Bearer ${token}`;
      this.#tokenSet = true;
    }
  }

  /**
   * General-purpose request method
   * @param {string} method - HTTP method (GET, POST, PUT, DELETE, PATCH)
   * @param {string} url - Request URL
   * @param {object|null} payload - Request body (if applicable)
   * @param {object} headers - Additional headers
   */
  async sendRequest(method, url, payload = null, headers = {}) {
    this.#trySettingToken();

    const options = {
      method,
      headers: {
        ...this.#headers,
        ...headers,
      },
    };

    const isFormData = payload instanceof FormData;

    // If it's FormData, remove JSON header and don't stringify
    if (isFormData) {
      delete options.headers['Content-Type']; // ❗ Let browser set correct boundary
      options.body = payload;
    }
    else if (payload && method !== 'GET' && method !== 'HEAD') {
      options.body = JSON.stringify(payload);
    }

    try {
      const response = await fetch(url, options);
      const data = await response.json().catch(() => ({}));

      if (!response.ok) {
        return { success: false, errors: data.errors || [data.message || response.statusText] };
      }

      return { success: true, data };
    } catch (error) {
      return { success: false, errors: [error.message] };
    }
  }
}

export const sender = new Sender();
