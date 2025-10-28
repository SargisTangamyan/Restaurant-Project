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

