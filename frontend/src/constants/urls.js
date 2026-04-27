// BASE URL
const BASE_URL = 'http://localhost:8000/api';
const HOME_URL = 'http://localhost:5173'

// AUTHENTICATION
export const REGISTER_URL = `${BASE_URL}/account/register`;
export const LOGIN_URL = `${BASE_URL}/account/login`;
export const LOGOUT_URL = `${BASE_URL}/account/logout`;
export const FORGOT_PASSWORD = `${BASE_URL}/account/forgot-password`;
export const REDIRECT_URL = `${HOME_URL}/verify-email`;
export const RESET_PASSWORD = `${BASE_URL}/account/reset-password`;
export const RESET_PASSWORD_REDIRECT = `${HOME_URL}/account/reset-password`;


// CATEGORY
export const CATEGORY_ALL = `${BASE_URL}/categories`;
export const CATEGORY_SEARCH = `${BASE_URL}/categories/search`;

// INGREDIENT
export const INGREDIENT_ALL = `${BASE_URL}/ingredients`;
export const INGREDIENT_SEARCH = `${BASE_URL}/ingredients/search`;

// DISHES
export const DISHES = `${BASE_URL}/dishes`;
export const DISHES_SEARCH = `${BASE_URL}/dishes/search`;
export const DISHES_RELATED = (id) => `${BASE_URL}/dishes/${id}/related`;

// IMAGES
export const STORAGE = 'http://localhost:8000/'

// CART
export const CART = `${BASE_URL}/cart`;
export const CART_COUNT =  `${CART}/count`;

// STRIPE
export const STRIPE_CREATE_CHECKOUT = `${BASE_URL}/stripe/create-checkout-session`;
export const STRIPE_VERIFY_PAYMENT = `${BASE_URL}/stripe/verify-payment`;
export const STRIPE_CANCEL_PAYMENT = `${BASE_URL}/stripe/cancel-payment`;

// ORDERS
export const ORDERS = `${BASE_URL}/orders`;
export const ADMIN_ORDERS = `${BASE_URL}/admin/orders`;
export const ORDER_CANCEL = (id) => `${BASE_URL}/orders/${id}/cancel`;
export const ORDER_STATUS_UPDATE = (id) => `${BASE_URL}/admin/orders/${id}/status`;

// PROFILE
export const PROFILE_GET = `${BASE_URL}/profile`;
export const PROFILE_UPDATE = `${BASE_URL}/profile`;
export const PROFILE_IMAGE_UPLOAD = `${BASE_URL}/profile/image`;
export const PROFILE_IMAGE_DELETE = `${BASE_URL}/profile/image`;
export const PROFILE_PASSWORD_UPDATE = `${BASE_URL}/account/change-password`;
export const PROFILE_DELETE = `${BASE_URL}/account/delete-account`;

// ALLERGIES
export const ALLERGIES = `${BASE_URL}/profile/allergies`;
export const ALLERGY_ADD = (ingredientId) => `${BASE_URL}/profile/allergies/${ingredientId}`;
export const ALLERGY_REMOVE = (ingredientId) => `${BASE_URL}/profile/allergies/${ingredientId}`;

// RESTAURANTS
export const RESTAURANTS = `${BASE_URL}/restaurants`;
export const RESTAURANT_BY_SLUG = (slug) => `${BASE_URL}/restaurants/${slug}`;
export const RESTAURANT_DISHES = (slug) => `${BASE_URL}/restaurants/${slug}/dishes`;

// REVIEWS
export const DISH_REVIEWS = (dishId) => `${BASE_URL}/dishes/${dishId}/reviews`;
export const DISH_REVIEW = (dishId, reviewId) => `${BASE_URL}/dishes/${dishId}/reviews/${reviewId}`;

