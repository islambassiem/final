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
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\QualificationController;


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

// Route::get('/{page}', [DashboardController::class, 'index']);



Route::get('/lang/{lang}', TranslationController::class)->name('lang');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Qualification

  Route::resource('qualifications', QualificationController::class);

  Route::get('/attachment/{id}', function ($id) {
    $link = Attachment::where('user_id', auth()->user()->id)
      ->where('attachmentable_type', 'App\Models\Qualification')
      ->where('attachmentable_id', $id)
      ->first('link');
    if ($link) {
      return redirect("storage/".$link->link);
    }
    return redirect()->back()->with('message', __('There is no attachment; press edit icon to add one'));
  })->name('qualification.attachment');


  //ajax
  Route::post('major/{firstLetter}', [QualificationController::class, 'major']);
  Route::post('minor/{code}', [QualificationController::class, 'minor']);

// Qualification



Route::resource('dependents', DependentController::class);
Route::resource('acquaintances', AcquaintanceController::class);
Route::resource('achievements', AchievementController::class);
Route::resource('courses', CourseController::class);



Route::get('/data', function () {
  User::create([
    'empid' => '500322',
    'email' => 'islambassiem@inaya.edu.sa',
    'password' => Hash::make('123'),
    'gender_id' => '1',
    'nationality_id' => '18',
    'religion_id' => '1',
    'place_of_birth_id' => '18',
    'marital_status_id' => '1',
    'position_id' => '1',
    'sponsorship_id'=> '1',
    'section_id' => '1',
    'category_id' => '1',
    'created_by' => '1',
    'updated_by' => '1'
  ]);
});
