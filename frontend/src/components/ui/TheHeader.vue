<script setup>

// STYLING IMPORTS
// FontAwesome
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {faBars} from '@fortawesome/free-solid-svg-icons'

// UI COMPONENTS
import TheBox from '@/components/ui/TheBox.vue'

// DEFAULT VUE METHODS
import { onUnmounted, ref, computed, onMounted } from "vue";

// STORES
import { useLanguageStore } from "@/stores/index.js";
import { useCurrencyStore } from "@/stores/index.js";

// COMPOSABLES
import { useBoxOpenClose } from "@/composables/useBoxOpenClose.js";

// DEFINING STORE
const languageStore = useLanguageStore();
const currencyStore = useCurrencyStore();

// CONSTANT DATA
const isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

// COMPUTED
const chosenLanguage = computed(() => languageStore.getChosenLanguage);
const chosenCurrency = computed(() => currencyStore.getChosenCurrency);

// BASE LOGICS
const useDropDownLogic = function () {
  // REFERENCES
  const showLanguageMenu = ref(false);
  const showCurrencyMenu = ref(false);

  // METHODS
  const toggleMenu = function(menu, event) {
    event.stopPropagation();

    if (menu === 'language') {
      showCurrencyMenu.value = false;
      showLanguageMenu.value = !showLanguageMenu.value
      if (showLanguageMenu.value) addOutsideListener()
    } else if (menu === 'currency') {
      showLanguageMenu.value = false;
      showCurrencyMenu.value = !showCurrencyMenu.value
      if (showCurrencyMenu.value) addOutsideListener()
    }
  }

  const hideMenus = function() {
    showLanguageMenu.value = false;
    showCurrencyMenu.value = false;
  }

  const handleClickOutside = function (event) {
    // Check if the click is inside any dropdown
    const clickedInsideDropdown = (event.target).closest('.dropdown-toggle')
    if (!clickedInsideDropdown) {
      hideMenus();
      document.removeEventListener('click', handleClickOutside)
    }
  }

  function addOutsideListener() {
    document.addEventListener('click', handleClickOutside)
  }

  onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
  });

  return {showLanguageMenu, showCurrencyMenu, toggleMenu}
}

const useWelcomeTextLogic = function () {
  // ROUGH DATA
  let changeTextInterval;

  // REFERENCES
  const showFirstWelcomeText = ref(false);
  const startTextVisible = ref(window.innerWidth >= 1024)

  // METHODS
    const handleResize = function () {
      const visible = window.innerWidth >= 1024;
      startTextVisible.value = visible;

      if (visible && !changeTextInterval) {
        startInterval()
      } else if (!visible && changeTextInterval) {
        stopInterval()
      }
    }

    const startInterval = function () {
      console.log('startInerval Called')
      changeTextInterval = setInterval(() => {
        showFirstWelcomeText.value = !showFirstWelcomeText.value;
      }, 3000);
    }

    const stopInterval = function () {
      console.log('stopInterval Called');
      clearInterval(changeTextInterval);
      changeTextInterval = null;
    }

    onMounted(() => {
      if (startTextVisible.value) startInterval();
      window.addEventListener('resize', handleResize);
    });

    onUnmounted(() => {
    stopInterval();
    window.removeEventListener('resize', handleResize);
  });

  return {showFirstWelcomeText, startTextVisible};
}

const useMenuLogic = function () {
  // For Account
  const showAccount = ref(false);
  const {openBox: openAccount, closeBox: closeAccount, toggleShowBox: toggleShowAccount} = useBoxOpenClose(showAccount);

  return {showAccount, toggleShowAccount, openAccount, closeAccount};
}

// USING THE LOGIC
const {showLanguageMenu, showCurrencyMenu, toggleMenu} = useDropDownLogic();
const {showFirstWelcomeText, startTextVisible} = useWelcomeTextLogic();
const {showAccount, toggleShowAccount, openAccount, closeAccount } = useMenuLogic();

</script>

<template>
  <header class="pb-md-4">
    <div class="header-top">
      <the-box :mb="false">
        <div class="row">

          <div class="address">
              <span class="text-white">1418 Riverwood Drive, CA 96052, US</span>
          </div>

          <div v-if="startTextVisible" class="start-text">
              <div class="notification-slider">
                <transition name="slide-fade" mode="out-in">
                  <div v-if="showFirstWelcomeText" class="timer-notification">
                    <h6 class="welcome-text"><strong class="me-1">Welcome to Fastkart!</strong> Wrap new offers/gift
                      every single day on Weekends. <strong class="ms-1">Coupon Code: Fast024
                      </strong>

                    </h6>
                  </div>

                  <div v-else class="timer-notification">
                    <h6 class="welcome-text">Something you love is now on sale!
                      <a href="#" class="text-white">Buy Now
                        !</a>
                    </h6>
                  </div>
                </transition>
              </div>
          </div>

          <div class="lang-cur">
            <ul class="about-list right-nav-about">
              <li class="right-nav-list">
                <div class="dropdown theme-form-select">
                  <button @click="toggleMenu('language', $event)" class="btn dropdown-toggle" type="button">
                    <img :src="languageStore.getChosenLanguage.flagPath" class="flag-img" :alt="languageStore.getChosenLanguage.id"/>
                    <span class="dropdown-text">{{ chosenLanguage.name }}</span>
                  </button>

                  <ul v-if="showLanguageMenu" class="dropdown-menu dropdown-menu-end">
                    <li v-for="language in languageStore.getFilteredLanguages" :key="language.id" @click="languageStore.chooseLanguage(language.id)">
                      <a class="dropdown-item" href="#" id="english">
                        <img :src="language.flagPath" class="flag-img" :alt="language.id">
                        <span class="dropdown-text">{{ language.name }}</span>
                      </a>
                    </li>
                  </ul>

                </div>
              </li>
              <li class="right-nav-list">
                <div class="dropdown theme-form-select">
                  <button @click="toggleMenu('currency', $event)" class="btn-with-sep dropdown-toggle" type="button">
                    <span class="dropdown-text">{{chosenCurrency}}</span>
                  </button>

                  <ul v-if="showCurrencyMenu" class="dropdown-menu sm-dropdown-menu">
                    <li v-for="(currency, idx) in currencyStore.getFilteredCurrency" :key="idx" @click="currencyStore.chooseCurrency(currency)">
                      <a class="dropdown-item">{{currency}}</a>
                    </li>
                  </ul>

                </div>
              </li>
            </ul>
          </div>

        </div>
      </the-box>
    </div>

    <div class="top-nav">
      <the-box :mb="false">
        <div class="row">
          <div class="navbar-container">
            <div class="navbar">
              <button class="navbar-menu-button" type="button">
                <FontAwesomeIcon class="bar-icon" :icon="faBars" />
              </button>

              <a href="index.html" class="web-logo nav-logo">
                <img src="../../assets/images/logo/1.png" class="logo-img" alt="">
              </a>

              <!-- Now Working on -->
              <div class="middle-box">
                <input type="search" class="search-input" placeholder="I'm searching for...">
                <button class="btn-outline search-button" type="button">
                  <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M448 272C448 174.8 369.2 96 272 96C174.8 96 96 174.8 96 272C96 369.2 174.8 448 272 448C369.2 448 448 369.2 448 272zM407.3 430C371 461.2 323.7 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272C480 323.7 461.2 371 430 407.3L571.3 548.7C577.5 554.9 577.5 565.1 571.3 571.3C565.1 577.5 554.9 577.5 548.7 571.3L407.3 430z"/></svg>
                </button>
              </div>
              <!-- End -->

              <div class="rightside-box">
                <ul class="right-side-menu">
                  <li class="right-side hidden-sm search-bg">
                    <div class="delivery-login-box">
                      <div class="delivery-icon">
                        <div class="search-box">
                          <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M448 272C448 174.8 369.2 96 272 96C174.8 96 96 174.8 96 272C96 369.2 174.8 448 272 448C369.2 448 448 369.2 448 272zM407.3 430C371 461.2 323.7 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272C480 323.7 461.2 371 430 407.3L571.3 548.7C577.5 554.9 577.5 565.1 571.3 571.3C565.1 577.5 554.9 577.5 548.7 571.3L407.3 430z"/></svg>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="right-side hidden-sm">
                    <a href="contact-us.html" class="delivery-login-box">
                      <div class="delivery-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="menu-icon" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#000000" d="M208.4 106.7C205 98.7 196.2 94.4 187.8 96.6L181.1 98.4C127.9 113 86.1 163.1 98.2 221.4C131.6 382 258.1 508.4 418.7 541.9C476.9 554 527.1 512.2 541.6 458.9L543.4 452.2C545.7 443.8 541.4 435 533.3 431.6L440 392.7C432.9 389.8 424.8 391.8 419.9 397.7L383.3 442.4C378.6 448.1 370.7 449.9 364.1 446.7C289.1 411.1 229.1 349.1 196 272.7C193.2 266.1 195 258.5 200.6 254L242.2 219.9C248.1 215.1 250.2 206.9 247.2 199.8L208.4 106.7zM179.4 65.8C203.3 59.3 228.4 71.5 237.9 94.4L276.8 187.7C285.2 207.8 279.4 231.1 262.5 244.9L230.4 271.2C259.4 331.7 307.5 381.4 366.7 412.5L395.2 377.6C409 360.7 432.2 354.9 452.4 363.3L545.7 402.2C568.6 411.7 580.8 436.8 574.3 460.7L572.5 467.4C554.8 532.3 491.2 589.6 412.2 573.2C239.1 537.2 102.9 401 66.9 227.9C50.4 148.8 107.7 85.3 172.7 67.6L179.4 65.8z"/></svg>
                      </div>
                      <div style="display:none" class="delivery-detail">
                        <h6>24/7 Delivery</h6>
                        <h5>+91 888 104 2340</h5>
                      </div>
                    </a>
                  </li>

                  <li class="right-side hidden-sm">
                    <a href="wishlist.html" class="btn">
                      <svg class="menu-icon heart-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M442.9 128C410.5 128 380 143.6 361 169.9L333 208.6C330 212.8 325.2 215.2 320 215.2C314.8 215.2 310 212.7 307 208.6L279 169.9L279 169.9C260 143.6 229.5 128 197.1 128C141.2 128 96 173.3 96 229.1C96 284.1 130.4 336.2 167.8 381.6C209.9 432.8 261.2 477.6 296.3 504.5C302.5 509.3 310.7 512 320 512C329.3 512 337.4 509.3 343.7 504.5C378.8 477.7 430.1 432.8 472.2 381.6C509.5 336.2 544 284.1 544 229.1C544 173.2 498.7 128 442.9 128zM335 151.1C360 116.5 400.2 96 442.9 96C516.4 96 576 155.6 576 229.1C576 296.5 534.4 356.4 496.9 401.9C452.8 455.5 399.6 502 363.1 529.8C350.7 539.2 335.5 543.9 320 543.9C304.5 543.9 289.2 539.3 276.9 529.8C240.4 502 187.2 455.5 143.1 402C105.6 356.4 64 296.5 64 229.1C64 155.6 123.6 96 197.1 96C239.8 96 280 116.5 305 151.1L320 171.8L335 151.1z"/></svg>
                    </a>
                  </li>

                  <li class="right-side hidden-sm">
                    <div class="onhover-dropdown header-badge">
                      <button type="button" class="btn-outline cart-button">
                        <svg class="shopping-cart-icon menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M16 64C7.2 64 0 71.2 0 80C0 88.8 7.2 96 16 96L61.3 96C69 96 75.7 101.5 77 109.1L127.9 388.8C134.1 423 163.9 447.9 198.7 447.9L464 448C472.8 448 480 440.8 480 432C480 423.2 472.8 416 464 416L198.7 416C179.4 416 162.8 402.2 159.3 383.2L153.6 352L466.6 352C500.5 352 529.9 328.3 537 295.1L569.4 144.4C574.8 119.5 555.8 96 530.3 96L106.6 96C99.9 77.1 81.9 64 61.3 64L16 64zM113 128L530.3 128C535.4 128 539.2 132.7 538.1 137.7L505.8 288.4C501.8 306.8 485.6 320 466.7 320L147.9 320L113 128zM188 524C188 513 197 504 208 504C219 504 228 513 228 524C228 535 219 544 208 544C197 544 188 535 188 524zM260 524C260 495.3 236.7 472 208 472C179.3 472 156 495.3 156 524C156 552.7 179.3 576 208 576C236.7 576 260 552.7 260 524zM432 504C443 504 452 513 452 524C452 535 443 544 432 544C421 544 412 535 412 524C412 513 421 504 432 504zM432 576C460.7 576 484 552.7 484 524C484 495.3 460.7 472 432 472C403.3 472 380 495.3 380 524C380 552.7 403.3 576 432 576z"/></svg>
                        <span class="cart-badge">2
                            <span style="display: none" class="visually-hidden">unread messages</span>
                        </span>
                      </button>

<!--                      <div class="onhover-div">-->
<!--                        <ul class="cart-list">-->
<!--                          <li class="product-box-contain">-->
<!--                            <div class="drop-cart">-->
<!--                              <a href="product-left-thumbnail.html" class="drop-image">-->
<!--                                <img src="../assets/images/vegetable/product/1.png"-->
<!--                                     class="blur-up lazyload" alt="">-->
<!--                              </a>-->

<!--                              <div class="drop-contain">-->
<!--                                <a href="product-left-thumbnail.html">-->
<!--                                  <h5>Fantasy Crunchy Choco Chip Cookies</h5>-->
<!--                                </a>-->
<!--                                <h6><span>1 x</span> $80.58</h6>-->
<!--                                <button class="close-button close_button">-->
<!--                                  <i class="fa-solid fa-xmark"></i>-->
<!--                                </button>-->
<!--                              </div>-->
<!--                            </div>-->
<!--                          </li>-->

<!--                          <li class="product-box-contain">-->
<!--                            <div class="drop-cart">-->
<!--                              <a href="product-left-thumbnail.html" class="drop-image">-->
<!--                                <img src="../assets/images/vegetable/product/2.png"-->
<!--                                     class="blur-up lazyload" alt="">-->
<!--                              </a>-->

<!--                              <div class="drop-contain">-->
<!--                                <a href="product-left-thumbnail.html">-->
<!--                                  <h5>Peanut Butter Bite Premium Butter Cookies 600 g-->
<!--                                  </h5>-->
<!--                                </a>-->
<!--                                <h6><span>1 x</span> $25.68</h6>-->
<!--                                <button class="close-button close_button">-->
<!--                                  <i class="fa-solid fa-xmark"></i>-->
<!--                                </button>-->
<!--                              </div>-->
<!--                            </div>-->
<!--                          </li>-->
<!--                        </ul>-->

<!--                        <div class="price-box">-->
<!--                          <h5>Total :</h5>-->
<!--                          <h4 class="theme-color fw-bold">$106.58</h4>-->
<!--                        </div>-->

<!--                        <div class="button-group">-->
<!--                          <a href="cart.html" class="btn btn-sm cart-button">View Cart</a>-->
<!--                          <a href="checkout.html" class="btn btn-sm cart-button theme-bg-color-->
<!--                                                    text-white">Checkout</a>-->
<!--                        </div>-->
<!--                      </div>-->
                    </div>
                  </li>

                  <li class="right-side onhover-dropdown">
                    <div class="delivery-login-box"
                         @click="toggleShowAccount"
                         @mouseenter="!isTouch && openAccount()"
                         @mouseleave="!isTouch && closeAccount()"
                    >
                      <div class="delivery-icon">
                        <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 192C224 139 267 96 320 96C373 96 416 139 416 192C416 245 373 288 320 288C267 288 224 245 224 192zM448 192C448 121.3 390.7 64 320 64C249.3 64 192 121.3 192 192C192 262.7 249.3 320 320 320C390.7 320 448 262.7 448 192zM128 544C128 464.5 192.5 400 272 400L368 400C447.5 400 512 464.5 512 544L512 560C512 568.8 519.2 576 528 576C536.8 576 544 568.8 544 560L544 544C544 446.8 465.2 368 368 368L272 368C174.8 368 96 446.8 96 544L96 560C96 568.8 103.2 576 112 576C120.8 576 128 568.8 128 560L128 544z"/></svg>
                      </div>
<!--                      <div class="delivery-detail">-->
<!--                        <h6>Hello,</h6>-->
<!--                        <h5>My Account</h5>-->
<!--                      </div>-->
                    </div>

                    <transition name="menu-slide">
                      <div class="dropdown-menu onhover-div" v-show="showAccount" @mouseenter="!isTouch && openAccount()" @mouseleave="!isTouch && closeAccount()">
                        <ul class="user-box-name">
                          <li class="product-box-contain">
                            <router-link class="dropdown-item" :to="{name: 'login'}">Log In</router-link>
                          </li>

                          <li class="product-box-contain">
                            <router-link class="dropdown-item" :to="{name: 'register'}">Register</router-link>
                          </li>

                          <li class="product-box-contain">
                            <router-link class="dropdown-item" :to="{name: 'forgot_password'}">Forgot Password</router-link>
                          </li>
                        </ul>
                      </div>
                    </transition>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </the-box>
    </div>

    <the-box :mb="false">
      <div class="row">
        <div class="main-nav">
          <div class="menu-container">
            <div class="header-nav-left">
              <button class="btn-outline btn-struct dropdown-category">
                <svg class="menu-icon category-icon" width="17" height="14" viewBox="0 0 17 14" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.875 2C0.875 2.49728 1.07254 2.97419 1.42417 3.32583C1.77581 3.67746 2.25272 3.875 2.75 3.875C3.24728 3.875 3.72419 3.67746 4.07583 3.32583C4.42746 2.97419 4.625 2.49728 4.625 2C4.625 1.50272 4.42746 1.02581 4.07583 0.674175C3.72419 0.322544 3.24728 0.125 2.75 0.125C2.25272 0.125 1.77581 0.322544 1.42417 0.674175C1.07254 1.02581 0.875 1.50272 0.875 2ZM6.5 1.25C6.5 0.973858 6.72386 0.75 7 0.75H16C16.2761 0.75 16.5 0.973858 16.5 1.25V2.75C16.5 3.02614 16.2761 3.25 16 3.25H7C6.72386 3.25 6.5 3.02614 6.5 2.75V1.25ZM0.875 7C0.875 7.49728 1.07254 7.97419 1.42417 8.32583C1.77581 8.67746 2.25272 8.875 2.75 8.875C3.24728 8.875 3.72419 8.67746 4.07583 8.32583C4.42746 7.97419 4.625 7.49728 4.625 7C4.625 6.50272 4.42746 6.02581 4.07583 5.67417C3.72419 5.32254 3.24728 5.125 2.75 5.125C2.25272 5.125 1.77581 5.32254 1.42417 5.67417C1.07254 6.02581 0.875 6.50272 0.875 7ZM6.5 6.25C6.5 5.97386 6.72386 5.75 7 5.75H16C16.2761 5.75 16.5 5.97386 16.5 6.25V7.75C16.5 8.02614 16.2761 8.25 16 8.25H7C6.72386 8.25 6.5 8.02614 6.5 7.75V6.25ZM0.875 12C0.875 12.4973 1.07254 12.9742 1.42417 13.3258C1.77581 13.6775 2.25272 13.875 2.75 13.875C3.24728 13.875 3.72419 13.6775 4.07583 13.3258C4.42746 12.9742 4.625 12.4973 4.625 12C4.625 11.5027 4.42746 11.0258 4.07583 10.6742C3.72419 10.3225 3.24728 10.125 2.75 10.125C2.25272 10.125 1.77581 10.3225 1.42417 10.6742C1.07254 11.0258 0.875 11.5027 0.875 12ZM6.5 11.25C6.5 10.9739 6.72386 10.75 7 10.75H16C16.2761 10.75 16.5 10.9739 16.5 11.25V12.75C16.5 13.0261 16.2761 13.25 16 13.25H7C6.72386 13.25 6.5 13.0261 6.5 12.75V11.25Z" fill="#ffffff" />
                </svg>
                <span class="category-text">All Categories</span>
              </button>
            </div>
          </div>

          <div class="header-nav-middle">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#">Menu</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#">Blog</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#">Account</a>
              </li>
            </ul>
          </div>

          <div class="header-nav-right">
            <button class="btn-outline btn-struct deal-button" data-bs-toggle="modal" data-bs-target="#deal-box">
              <svg class="menu-icon deal-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M434.8 54.1C446.7 62.7 451.1 78.3 445.7 91.9L367.3 288L512 288C525.5 288 537.5 296.4 542.1 309.1C546.7 321.8 542.8 336 532.5 344.6L244.5 584.6C233.2 594 217.1 594.5 205.2 585.9C193.3 577.3 188.9 561.7 194.3 548.1L272.7 352L128 352C114.5 352 102.5 343.6 97.9 330.9C93.3 318.2 97.2 304 107.5 295.4L395.5 55.4C406.8 46 422.9 45.5 434.8 54.1z"/></svg>
              <span class="deal-text">Deal Today</span>
            </button>
          </div>
        </div>
      </div>
    </the-box>
  </header>
</template>

<style scoped>

.header-top {
  background-color: #0da487;
  padding: 10px 0;
  color: #fff;
  font-size: 14px;
}

.row {
  display: flex;
  justify-content: flex-end;
}

.lang-cur {
  padding: 0 12px;
  box-sizing: border-box;
}

.about-list {
  padding: 0;
  margin: 0;
  list-style: none;
  display: flex;
  justify-content: flex-end;
}

.right-nav-list {
  font-size: 1rem;
}

.dropdown {
  position: relative;
}

.dropdown-toggle {
  all:unset;
  display: flex;
  align-items: center;
  padding-right: 18px;
  position: relative;
  cursor: pointer;
}

.dropdown-toggle::after {
  content: "\2228";
  position: absolute;
  font-family: "Nunito", sans-serif;
  font-weight: 900;
  line-height: 1.5;
  right: 0;        /* adjust horizontal placement */
  top: 50%;           /* vertical centering */
  transform: translateY(-50%)  scale(1, 0.6);
  pointer-events: none; /* so it doesn't block clicks */
}

.flag-img {
  width: 20px;
  height: auto;
  margin-right: 10px;
}

.dropdown-text {
  display: inline-block;
  margin: 1px 0;
  font-weight: 500;
}

.btn-with-sep::before {
  content: "";
  display: block;
  width: 3px;
  height: 20px;
  margin: 0 10px;
  background-color: rgba(255, 255, 255, 0.5);
}

.dropdown-menu {
  background-color: #fff;
  min-width: 10rem;
  position:absolute;
  list-style: none;
  padding: 0.5rem 0;
  border: 1px solid rgba(0, 0, 0, 0.15);
  color: #212529;
  border-radius: 0.25rem;
  top: 100%;
  right: 0;
  z-index: 1;
}

.dropdown-item {
  width: 100%;
  padding: 0.25rem 1rem;
  font-weight: 400;
  text-decoration: none;
  text-wrap: nowrap;
  color: #212529;
  display: flex;
  align-items: center;
  box-sizing: border-box;
  cursor: pointer;
}

.sm-dropdown-menu {
  min-width: 4rem;
}

.start-text {
  flex-grow: 1;
  box-sizing: border-box;
  padding: 0 1rem;
  align-self: center;
}

.welcome-text {
  margin: 0;
  font-size: 14px;
  letter-spacing: 0.4px;
  font-weight: normal;
}

.text-white {
  color: white;
  font-weight: bold;
}

.address {
  display: none;
}

/* Transition timing */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
  width: 100%;
}

/* Enter: slide in from below */
.slide-fade-enter-from {
  opacity: 0;
  transform: translateY(50%);
}

.slide-fade-enter-to {
  opacity: 1;
  transform: translateY(0);
}

/* Leave: slide up */
.slide-fade-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-50%);
}

/* SECOND PART OF THE HEADER */
.top-nav {
  padding-top: 1.5rem;
  box-sizing: border-box;
}

.navbar-container {
  width: 100%;
  padding: 0 12px;
}

.navbar {
  display: flex;
  height: 1.5rem;
  justify-content: space-between;
  align-items: center;
}

.navbar-menu-button {
  all: unset;
  font-size: 1.5rem;
  display: flex;
  align-items: center;
}

.nav-logo {
  flex-shrink: 0;
  display: block;
  height: 25px;
  width: 141px;
}

.logo-img {
  height: 100%;
  width: 100%;
  display: block;
}

.rightside-box {
  display: flex;
  justify-content: flex-end;
  height: 100%;
  align-items: center;

}

.right-side-menu {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
}

.right-side {
  position: relative;
  padding-right: 2rem;
}

.right-side::after {
  content: "";
  display: block;
  position: absolute;
  right: 1rem;
  top: 0;
  width: 1px;
  height: 100%;
  background-color: #212529;
}

.right-side:last-child::after{
  display: none;
}

.right-side:last-child {
  padding-right: 0;
}


.delivery-login-box {
  display: flex;
  align-items: center; /* vertically centers children */
  justify-content: center; /* optional: horizontally center if needed */
  height: 100%; /* ensure it inherits navbar height */
}

.menu-icon {
  height: 1.5rem;
  font-size: 1.5rem;
  cursor: pointer;
}

.heart-icon {
  color: #212529;
}

.user-box-name {
  list-style: none;
  margin: 0;
  padding: 0;
}

.menu-slide-enter-active,
.menu-slide-leave-active {
  transition: all 0.2s ease;
}

/* Enter: slide in from below */
.menu-slide-enter-from {
  opacity: 0;
  transform: translateY(20%);
}

.menu-slide-enter-to {
  opacity: 1;
  transform: translateY(0);
}

/* Leave: slide up */
.menu-slide-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.menu-slide-leave-to {
  opacity: 0;
  transform: translateY(20%);
}

.onhover-div {
  top: 200%;
}

.btn-outline {
  all: unset;
  cursor: pointer;
}

.header-badge {
  height: 100%;
  padding-right: 9px;
}

.cart-button {
  position: relative;
  display: flex;
  align-items: center;
}

.cart-badge {
  position: absolute;
  background-color: #FF7272;
  width: 18px;
  height: 18px;
  font-size: 12px;
  text-align: center;
  line-height: 19px;
  font-weight: bold;
  color: #fff;
  border-radius: 2px;
  top: -9px;
  right: -9px;
}

.middle-box {
  display: none;
  height: 100%;
  width: 100%;
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 0.5rem;
  overflow: hidden;
}

.search-input {
  flex: 1;
  border: none;
  padding: 0.8rem 1rem;
  border-bottom-left-radius: 0.5rem;
  border-top-left-radius: 0.5rem;
}

.search-input:focus {
  border: 1px solid #0da487;
  outline: none;
}

input::-webkit-search-cancel-button,
input::-webkit-clear-button {
  display: none;
}

.search-button {
  width: 4rem;
  background-color: #FFA53B;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.search-icon {
  height: 1.75rem;
  fill: white;
}

.header-nav-left {
  color: #ffffff;
}

.main-nav {
  width: 100%;
  display: flex;
  justify-content: space-between;
  gap: 2rem;
}

.btn-struct {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1.25rem;
  border-radius: 0.5rem;
}

.dropdown-category {
  background-color: #0da487;
}

.category-icon {
  fill: #ffffff;
  margin-right: 0.75rem;
}

.category-text {
  display: block;
  font-weight: bold;
  line-height: 100%;
}

.header-nav-middle {
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 1;
  width: 100%;
}

.navbar-nav {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: space-around;
  gap: 2.5rem;
  text-transform: uppercase;
  /*width: 100%; */
}

.nav-link {
  text-decoration: none;
  color: #212529;
}


.deal-button {
  background-color: #0da48726;
}

.deal-text {
  display: block;
  text-wrap: nowrap;
  color: #0da487;
  font-weight: bold;
}

.deal-icon {
  fill: #0da487;
  margin-right: 0.75rem;
}


@media (min-width: 768px) { /* md breakpoint */
  .pb-md-4 {
    padding-bottom: 1.5rem !important; /* same as Bootstrap */
  }

  .top-nav {
    margin-bottom: 1.5rem;
  }

  .navbar {
    height: 3.5rem;
    justify-content: flex-start;
  }

  .navbar-menu-button {
    margin-right: 10px;
  }

  .rightside-box {
    flex: 1;
  }
}

@media (min-width: 1024px) {
  .navbar-menu-button {
    display: none;
  }

  .navbar {
    justify-content: space-between;
    gap: 3rem;
  }

  .middle-box {
    display: flex;
  }

  .search-bg {
    display: none;
  }
}

@media (min-width: 1300px) {
  .address {
    display: block;
    align-self: center;
  }

  .address span {
    font-weight: 600;
  }

  .timer-notification {
    text-align: center;
  }

  .rightside-box {
    flex-grow: 0;
  }

  .navbar-container {
    padding: 0;
  }
}

@media (max-width: 767px) { /* md breakpoint */

  .lang-cur {
    width: 100%; /* same as Bootstrap */
  }

  .hidden-sm {
    display: none;
  }

  .onhover-div {
    top: 150%;
  }

  .main-nav {
    display: none;
  }
}

@media (max-width: 1023px) {

  .header-nav-middle {
    display: none;
  }

  .deal-text {
    display: none;
  }

  .deal-icon {
    margin: 0;
  }
}

</style>
