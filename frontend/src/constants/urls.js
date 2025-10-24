// BASE URL
const BASE_URL = 'http://localhost:8000/api';

// AUTHENTICATION
export const REGISTER_URL = `${BASE_URL}/account/register`;
export const LOGIN_URL = `${BASE_URL}/account/login`;
export const LOGOUT_URL = `${BASE_URL}/account/logout`;

export const REDIRECT_URL = 'http://localhost:5173/verify-email';


// CATEGORY
export const CATEGORY_ALL = `${BASE_URL}/categories`;
export const CATEGORY_SEARCH = `${BASE_URL}/categories/search`;

// INGREDIENT
export const INGREDIENT_ALL = `${BASE_URL}/ingredients`;
export const INGREDIENT_SEARCH = `${BASE_URL}/ingredients/search`;

// DISHES
export const DISHES = `${BASE_URL}/dishes`;
export const DISHES_SEARCH = `${BASE_URL}/dishes/search`;

// IMAGES
export const STORAGE = 'http://localhost:8000/storage'

// CART
export const CART = `${BASE_URL}/cart`;
export const CART_COUNT =  `${CART}/count`;

// STRIPE
export const STRIPE_CREATE_CHECKOUT = `${BASE_URL}/stripe/create-checkout-session`;
export const STRIPE_VERIFY_PAYMENT = `${BASE_URL}/stripe/verify-payment`;
export const STRIPE_CANCEL_PAYMENT = `${BASE_URL}/stripe/cancel-payment`;
