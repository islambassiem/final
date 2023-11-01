<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\GoogleController;

// Log in
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// forgot password
Route::get('/forget-password', [ForgetPasswordController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forget-password', [ForgetPasswordController::class, 'forgotPasswordPost'])->name('forgot-password.post');

//reset password
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPasswordPost'])->name('reset-password.post') ;

// sign in with google
Route::get('/auth/google', [GoogleController::class, 'googlePage'])->name('google');
Route::get('/auth/google/callback', [GoogleController::class, 'googleCallBack']);