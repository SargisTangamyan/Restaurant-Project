import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

// FONT AWESOME
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCheck, faCoffee } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {useLanguageStore} from "@/stores/config/language.js";
import {useCurrencyStore} from "@/stores/index.js";

// TAILWINDCSS
import '@/assets/css/main.css'

// Add icons to the library
library.add(faCheck, faCoffee)

const app = createApp(App)

// Register the component globally
app.component('font-awesome-icon', FontAwesomeIcon)

app.use(createPinia())
useLanguageStore().predefineLanguage();
useCurrencyStore().predefineCurrency();

app.use(router)

app.mount('#app')
