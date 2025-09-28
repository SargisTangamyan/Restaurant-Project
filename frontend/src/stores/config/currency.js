import { defineStore } from 'pinia'

export const useCurrencyStore = defineStore('currency', {
  state: () => ({
    availableCurrencies: ['USD', 'EUR', 'AMD'],

    chosenCurrency: null,
  }),

  getters: {
    getFilteredCurrency(state) {
      return state.availableCurrencies.filter(currency => currency !== state.chosenCurrency)
    },

    getChosenCurrency(state) {
      return state.chosenCurrency;
    }
  },

  actions: {
    predefineCurrency() {
      const currency = localStorage.getItem('currency');
      this.chosenCurrency = currency || this.availableCurrencies[0];
    },

    chooseCurrency(currency) {
      if (this.availableCurrencies.includes(currency)) {
        this.chosenCurrency = currency;
        localStorage.setItem('currency', currency);
      }
    }
  },
});
