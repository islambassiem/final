<?php

use App\Models\User;
use App\Models\Attachment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DependentController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\AcquaintanceController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\OtherExperienceController;
use App\Http\Controllers\ProfileController;
use App\Models\Experience;

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
  Route::get('/attachment/qualification/{id}', [QualificationController::class, 'getAttachment'])->name('qualification.attachment');
// Qualification

Route::post('/major/{code}', [QualificationController::class, 'major']);
Route::post('/minor/{code}', [QualificationController::class, 'minor']);

Route::resource('dependents', DependentController::class);
Route::resource('acquaintances', AcquaintanceController::class);
Route::resource('achievements', AchievementController::class);
Route::resource('courses', CourseController::class);
Route::resource('research', ResearchController::class);


Route::resource('other_experience', OtherExperienceController::class);
Route::get('/attachment/other/experience/{id}', [OtherExperienceController::class, 'getAttachment'])->name('other.experience.attachment');


// Experience
Route::resource('experience', ExperienceController::class);
Route::post('institutions/{firstLetter}', [ExperienceController::class, 'institutions']);
Route::post('governorate/{code}', [ExperienceController::class, 'governorate']);
Route::post('city/{code}', [ExperienceController::class, 'city']);
Route::post('colleges/{code}', [ExperienceController::class, 'colleges']);
Route::post('department_major/{code}', [ExperienceController::class, 'department_major']);
Route::post('department_minor/{code}', [ExperienceController::class, 'department_minor']);
Route::get('/attachment/experience/{id}', [ExperienceController::class, 'getAttachment'])->name('experience.attachment');
// Experience

Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('national/address', [ProfileController::class, 'storeNationalAddress'])->name('national.address');
Route::post('national/address/edit/{id}', [ProfileController::class, 'updateNationalAddress'])->name('national.address.edit');
Route::post('address', [ProfileController::class, 'storeAddress'])->name('address');
Route::post('address/edit/{id}', [ProfileController::class, 'updateAddress'])->name('address.edit');
Route::post('edit/profile/{user}', [ProfileController::class, 'editProfile'])->name('profile.edit');
Route::delete('delete/picture/{empid}', [ProfileController::class, 'deletePicture'])->name('delete.picture');
Route::post('upload/picture/{empid}', [ProfileController::class, 'uploadPicture'])->name('upload.picture');