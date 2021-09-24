<?php

use Simbamahaba\Upepo\Controllers\Customer\Auth\AuthenticatedSessionController;
use Simbamahaba\Upepo\Controllers\Customer\Auth\ConfirmablePasswordController;
use Simbamahaba\Upepo\Controllers\Customer\Auth\EmailVerificationNotificationController;
use Simbamahaba\Upepo\Controllers\Customer\Auth\EmailVerificationPromptController;
use Simbamahaba\Upepo\Controllers\Customer\Auth\NewPasswordController;
use Simbamahaba\Upepo\Controllers\Customer\Auth\PasswordResetLinkController;
use Simbamahaba\Upepo\Controllers\Customer\Auth\RegisteredUserController;
use Simbamahaba\Upepo\Controllers\Customer\Auth\VerifyEmailController;
use Simbamahaba\Upepo\Controllers\Customer\Auth\FbauthController;
use Illuminate\Support\Facades\Route;

# Register customers

Route::get('/customer/register', [RegisteredUserController::class, 'create'])
                ->middleware(['web','customer'])
                ->name('customer.showRegistrationForm');

Route::post('/customer/register', [RegisteredUserController::class, 'store'])
                ->middleware(['web','customer']);

# Login customers

Route::get('/customer/login/{cart?}', [AuthenticatedSessionController::class, 'create'])
                ->middleware(['web','customer'])
                ->name('customer.showLoginForm');

Route::post('/customer/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware(['web','customer']);

# Forgotten passwords

Route::get('customer/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware(['web','customer'])
                ->name('password.request');

Route::post('customer/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware(['web','customer'])
                ->name('password.email');

Route::get('customer/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware(['web','customer'])
                ->name('password.reset');

Route::post('customer/reset-password', [NewPasswordController::class, 'store'])
                ->middleware(['web','customer'])
                ->name('password.update');

# Verify email of new customers


Route::get('customer/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware(['web','loggedcustomer'])
                ->name('verification.notice');

Route::get('customer/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['web','loggedcustomer', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post('customer/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['web','loggedcustomer', 'throttle:6,1'])
                ->name('verification.send');

/*
 * Confirm password
 * You may occasionally have actions that should require the user to confirm their password
 * before the action is performed or before the user is redirected to a sensitive area of
 * the application. Implementing this feature will require you to define two routes:
 * one route to display a view asking the user to confirm their password
 * and another route to confirm that the password is valid and redirect the user to their intended destination.
 * */

Route::get('customer/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware(['web','loggedcustomer'])
                ->name('password.confirm');

Route::post('customer/confirm-password', [ConfirmablePasswordController::class, 'store'])
                ->middleware(['web','loggedcustomer']);

# Logout customers

Route::post('customer/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware(['web','loggedcustomer'])
                ->name('customer.logout');
# Facebook Auth
Route::get('auth/facebook', [FbauthController::class, 'redirectToProvider'])->name('fb.redirectToProvider');
Route::get('auth/facebook/callback', [FbauthController::class, 'handleProviderCallback'])->name('fb.handleProviderCallback');