<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TranslationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

require_once __DIR__ . '/auth.php';


Route::get('/lang/{lang}', TranslationController::class)->name('lang');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
