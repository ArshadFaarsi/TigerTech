<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('sinup',[AuthController::class,'sinup'])->name('sinup');
Route::get('log',[AuthController::class,'index'])->name('log');
Route::post('register',[AuthController::class,'register'])->name('register');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('logout',[AuthController::class,'logout'])->name('logout');

Route::get('home',[AuthController::class,'home'])->name('home');

// login with social media
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google');
Route::get('callback/google', [AuthController::class, 'handleCallback']);
Route::get('location', [AuthController::class, 'location']);



//payment strip
Route::get('stripe', [StripeController::class, 'stripe'])->name('stripe');
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');

