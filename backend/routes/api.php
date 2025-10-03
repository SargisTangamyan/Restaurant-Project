<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\IngredientController;
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

// Category Resource
Route::apiResource('/categories', CategoryController::class);

// Ingredient Resource
Route::apiResource('/ingredients', IngredientController::class);

// Dish Resource
Route::apiResource('/dishes', DishController::class);
