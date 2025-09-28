import {defineStore} from 'pinia'

export const useLanguageStore = defineStore('language', {
  state: () => ({
    availableLanguages: [
      {
        id: 'us',
        name: 'English (US)',
        flagPath: new URL('@/assets/images/country/united-states.png', import.meta.url).href,
      },
      {
        id: 'uk',
        name: 'English (UK)',
        flagPath: new URL('@/assets/images/country/united-kingdom.png', import.meta.url).href,
      },
      {
        id: 'de',
        name: 'German',
        flagPath: new URL('@/assets/images/country/germany.png', import.meta.url).href,
      },
    ],

    chosenLanguage: null,
  }),

  getters: {
    getFilteredLanguages(state) {
      if (!state.chosenLanguage) return state.availableLanguages;
      return state.availableLanguages.filter(c => c.id !== state.chosenLanguage.id);
    },

    getChosenLanguage(state) {
      return state.chosenLanguage;
    }
  },

  actions: {
    predefineLanguage() {
      const languageId = localStorage.getItem('language_id');
      const found = languageId
        ? this.availableLanguages.find(lang => lang.id === languageId)
        : null;

      this.chosenLanguage = found ?? this.availableLanguages[0];
    },

    chooseLanguage(languageId) {
      const foundCountry = this.availableLanguages.find(language => language.id === languageId);
      if (foundCountry) {
        this.chosenLanguage = foundCountry;
        localStorage.setItem('language_id', languageId);
      }
    }
  }
});

