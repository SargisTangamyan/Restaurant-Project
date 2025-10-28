import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

import App from './App.vue'
import router from './router'

// FONT AWESOME
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCaretDown, faCaretUp, faXmark, faMagnifyingGlass, faListCheck, faEye,
  faHeart, faPlus, faMinus, faStar, faStarHalfAlt, faStarHalfStroke, faCircle,
  faShuffle, faCheck, faUtensils  } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {useLanguageStore} from "@/stores/config/language.js";
import {useCurrencyStore} from "@/stores/index.js";

// TAILWINDCSS
import '@/assets/css/main.css'

// COMPONENTS
import TheLoader from '@/components/ui/TheLoader.vue'

// Add icons to the library
library.add(faCaretDown, faCaretUp, faMagnifyingGlass, faXmark, faListCheck, faEye, faHeart, faPlus, faMinus,
  faStar, faStarHalfAlt, faStarHalfStroke, faCircle, faShuffle, faCheck, faUtensils );

const app = createApp(App);

// Register the component globally
app.component('font-awesome-icon', FontAwesomeIcon);
app.component('the-loader', TheLoader);

// Store
const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)
app.use(pinia);
useLanguageStore().predefineLanguage();
useCurrencyStore().predefineCurrency();

// Router
app.use(router)

app.mount('#app')
