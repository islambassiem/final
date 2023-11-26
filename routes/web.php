<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AcquaintanceController;
use App\Http\Controllers\CourseController;
use App\Models\User;
use App\Models\Attachment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DependentController;
use App\Http\Controllers\OtherExperienceController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\ResearchController;

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
  return view('auth.login');
});

require_once __DIR__ . '/auth.php';

Route::get('/lang/{lang}', TranslationController::class)->name('lang');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Qualification
  Route::resource('qualifications', QualificationController::class);
  Route::get('/attachment/{id}', [QualificationController::class, 'getAttachment'])->name('qualification.attachment');
  //ajax
  Route::post('major/{firstLetter}', [QualificationController::class, 'major']);
  Route::post('minor/{code}', [QualificationController::class, 'minor']);
// Qualification



Route::resource('dependents', DependentController::class);
Route::resource('acquaintances', AcquaintanceController::class);
Route::resource('achievements', AchievementController::class);
Route::resource('courses', CourseController::class);
Route::resource('research', ResearchController::class);
Route::resource('other_experience', OtherExperienceController::class);
