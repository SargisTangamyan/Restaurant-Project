<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishReviewController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\UserAllergyController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working',
        'status' => 200
    ]);
})->middleware(['auth:sanctum']);

// Authentication
Route::name('account.')->prefix('account')->group(function () {
    Route::post('/login', [LoginController::class, 'store'])->name('login');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot_password');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset_password');

    Route::controller(AccountController::class)->middleware('auth:sanctum')->group(function () {
        Route::delete('/logout', 'logout')->name('logout');
        Route::post('/delete-account', 'destroy')->name('delete_account');
        Route::put('/change-password', 'changePassword')->name('change_password');
    });
});

// Verify Email
Route::get('/verify-email/{id}/{hash}', EmailVerificationController::class)->middleware(['signed'])->name('verification.verify');

// Profile
Route::middleware('auth:sanctum')->prefix('profile')->name('profile.')->group(function() {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
    Route::post('/image', [ProfileController::class, 'uploadImage'])->name('upload_image');
    Route::delete('/image', [ProfileController::class, 'deleteImage'])->name('upload_image');
});

// Category Resource
Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
Route::apiResource('/categories', CategoryController::class);

// Ingredient Resource
Route::get('/ingredients/search', [IngredientController::class, 'search'])->name('ingredients.search');
Route::apiResource('/ingredients', IngredientController::class);

// Dish Resource
Route::get('/dishes/{dish}/related', [DishController::class, 'related'])->name('dishes.related');
Route::get('dishes/search', [DishController::class, 'search'])->name('dishes.search');
Route::apiResource('/dishes', DishController::class);

// Dish Reviews
Route::get('/dishes/{dish}/reviews', [DishReviewController::class, 'index'])->name('dish_reviews.index');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/dishes/{dish}/reviews', [DishReviewController::class, 'store'])->name('dish_reviews.store');
    Route::put('/dishes/{dish}/reviews/{review}', [DishReviewController::class, 'update'])->name('dish_reviews.update');
    Route::delete('/dishes/{dish}/reviews/{review}', [DishReviewController::class, 'destroy'])->name('dish_reviews.destroy');
});

// User Allergies
Route::prefix('/profile/allergies')->controller(UserAllergyController::class)->middleware('auth:sanctum')->name('allergies.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/{ingredient}', 'store')->name('store');
    Route::delete('/{ingredient}', 'destroy')->name('destroy');
});

// Wishlist
Route::prefix('/wishlist')->controller(WishlistController::class)->middleware('auth:sanctum')->name('wishlist.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/{dish}', 'store')->name('store');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

// Cart
Route::prefix('/cart')->controller(CartController::class)->middleware('auth:sanctum')->name('cart.')->group(function () {
    Route::get('/count', 'count')->name('count');
    Route::get('/', 'index')->name('index');
    Route::post('/{dish}', 'store')->name('store');
    Route::put('/{dish}', 'update')->name('update');
    Route::delete('/{dish}', 'destroy')->name('destroy');
});

// Orders
Route::prefix('/orders')->controller(OrderController::class)->middleware('auth:sanctum')->name('order.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{order}', 'show')->name('show');
    Route::post('/', 'store')->name('store');
    Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
});

// Orders for Admin
Route::middleware(AdminMiddleware::class)->prefix('/admin')->controller(OrderController::class)->name('admin_orders.')->group(function () {
    Route::get('/orders', 'adminIndex')->name('index');
    Route::patch('/orders/{order}/status', 'updateStatus')->name('update_status');
});

// Payment
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/stripe/create-checkout-session', [StripePaymentController::class, 'createCheckoutSession']);
    Route::post('/stripe/verify-payment', [StripePaymentController::class, 'verifyPayment']);
    Route::post('/stripe/cancel-payment', [StripePaymentController::class, 'cancelPayment']);
});

// Restaurant
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{restaurant:slug}', [RestaurantController::class, 'show'])->name('restaurants.show');
Route::get('/restaurants/{restaurant:slug}/dishes', [RestaurantController::class, 'dishes'])->name('restaurants.dishes');

// Stripe Webhook
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
