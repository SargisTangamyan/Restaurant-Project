class Sender {
  #heathers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }

  async sendGetRequest(url, headers = {}) {
    try {
      const response = await fetch(url, {
        method: 'GET',
        headers: {
          ...this.#heathers,
          ...headers,
        },
      });

      const data = await response.json();

      if (!response.ok) {
        return {success: false, errors: data.errors || [data.message]};
      }

      return {success: true, data};

    } catch (error) {
      return {success: false, errors: [error.message]};
    }
  }


  async sendPostRequest(url, payload, headers = {}) {
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          ...this.#heathers,
          ...headers,
        },
        body: JSON.stringify(payload),
      });

      const data = await response.json();

      if (!response.ok) {
        return {success: false, errors: data.errors || [data.message]};
      }

      return {success: true, data};

    } catch (error) {
      return {success: false, errors: [error.message]};
    }
  }
}

export const sender = new Sender();

