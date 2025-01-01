<?php

use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\CancelPage;
use App\Livewire\SuccessPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductsPage;
use App\Livewire\MyAccountPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\CategoriesPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\OtpVerify;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProductDetailPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Payment\PaymentSuccess;
use App\Livewire\Auth\ForgotPasswordPage;

Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/cart', CartPage::class);
Route::get('/products/{slug}', ProductDetailPage::class)->name('products.show');


Route::middleware('guest')->group(function () {
    Route::get('/signin', LoginPage::class);
    Route::get('/signup', RegisterPage::class);
    Route::get('/forgot-password', ForgotPasswordPage::class)->name('forgot-password');
    Route::get('/new-password', ResetPasswordPage::class)->name('password.reset');
    Route::get('/verification', OtpVerify::class)->name('verification');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        return redirect()->to('/');
    })->name('logout');

    Route::get('/checkout', CheckoutPage::class);
    Route::get('/my-orders', MyOrdersPage::class);
    Route::get('/my-orders/{order_id}', MyOrderDetailPage::class)->name('my-orders.show');
    Route::get('/success', SuccessPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');
    Route::get('/my-account', MyAccountPage::class)->name('account');
});