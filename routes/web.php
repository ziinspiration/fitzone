<?php

use App\Http\Controllers\HomeController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');
