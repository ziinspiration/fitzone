<?php

use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\CancelPage;
use App\Livewire\SuccessPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductsPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\CategoriesPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProductDetailPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Auth\ForgotPasswordPage;

Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/cart', CartPage::class);
Route::get('/products/{slug}', ProductDetailPage::class);

Route::get('/checkout', CheckoutPage::class);
Route::get('/my-orders', MyOrdersPage::class);
Route::get('/my-orders/{order}', MyOrderDetailPage::class);

Route::get('/login', [LoginPage::class, 'render'])->name('login');
Route::post('/login', [LoginPage::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginPage::class, 'logout'])->name('logout');

Route::get('/register', [RegisterPage::class, 'render'])->name('register.form');
Route::post('/register', [RegisterPage::class, 'register'])->name('signup');
Route::get('/register/google', [RegisterPage::class, 'redirectToGoogle'])->name('register.google');
Route::get('/register/google/callback', [RegisterPage::class, 'handleGoogleCallback']);
Route::get('/verification', [RegisterPage::class, 'showVerificationPage'])->name('verification');
Route::post('/verification', [RegisterPage::class, 'verifyOtp'])->name('verification.otp');
Route::post('/verification/resend', [RegisterPage::class, 'resendOtp'])->name('verification.resend');

Route::get('/forgot', ForgotPasswordPage::class);
Route::get('/reset', ResetPasswordPage::class);

Route::get('/success', SuccessPage::class);
Route::get('/cancel', CancelPage::class);
