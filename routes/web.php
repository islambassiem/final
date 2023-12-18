<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DependentController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ExitReentryController;
use App\Http\Controllers\FamilyVisitController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\AcquaintanceController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\GenericRequestController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\OtherExperienceController;

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
require_once __DIR__ . '/head.php';

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
Route::get('attachment/achievement/{id}', [AchievementController::class, 'getAttachment'])->name('attachment.achievement');


Route::resource('courses', CourseController::class);
Route::get('attachment/course/{id}', [CourseController::class, 'getAttachment'])->name('attachment.course');



Route::resource('research', ResearchController::class);


Route::resource('documents', DocumentController::class);
Route::post('document/id/edit/{id}', [DocumentController::class, 'editID']);
Route::post('document/passport/edit/{id}', [DocumentController::class, 'editPassport']);
Route::post('document/doc/edit/{id}', [DocumentController::class, 'editDoc']);
Route::get('document/{id}', [DocumentController::class, 'getLink'])->name('nationalID');
Route::get('/attachment/document/{id}', [DocumentController::class, 'getAttachment'])->name('document.attachment');





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


Route::get('salary', [SalaryController::class, 'index'])->name('salary.index');


Route::resource('vacations', VacationController::class);
Route::get('attachment/vacation/{id}', [VacationController::class, 'getAttachment'])->name('attachment.vacation');
Route::post('add/attachment/vacation/{id}', [VacationController::class, 'attachAttachment'])->name('vacation.addAttachment');


Route::resource('permissions', PermissionController::class);
Route::get('attachment/permission/{id}', [PermissionController::class, 'getAttachment'])->name('attachment.permission');

Route::get('attachments', [AttachmentController::class, 'index'])->name('attachments.index');
Route::post('attachment/store', [AttachmentController::class, 'store'])->name('attachment.store');
Route::get('attachments/{folder}',[AttachmentController::class, 'folderContent'])->name('folder.contents');
Route::get('attachment/download/{id}', [AttachmentController::class, 'getAttachment'])->name('attachment.download');


Route::get('visits', [FamilyVisitController::class, 'index'])->name('visits.index');
Route::post('visits.store', [FamilyVisitController::class, 'store'])->name('visits.store');

Route::get('reentry', [ExitReentryController::class, 'index'])->name('reentry.index');
Route::post('reentryStore', [ExitReentryController::class, 'store'])->name('reentry.store');

Route::get('letters', [LetterController::class, 'index'])->name('letters.index');
Route::post('lettersStore', [LetterController::class, 'store'])->name('letters.store');

Route::get('transportation/requests', [TransportationController::class, 'index'])->name('transportation.index');
Route::post('transportation/requestsStore', [TransportationController::class, 'store'])->name('transportation.store');

Route::get('generics', [GenericRequestController::class, 'index'])->name('generics.index');
Route::get('genericsShow/{id}', [GenericRequestController::class, 'show'])->name('generics.show');
Route::get('genericsAdd', [GenericRequestController::class, 'create'])->name('generics.create');
Route::post('genericsStore', [GenericRequestController::class, 'store'])->name('generics.store');



Route::get('notification/{id}', function($id){
  auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
  return redirect()->back();
})->name('read.notification');

Route::get('readAll', function(){
  foreach (auth()->user()->unreadNotifications as $notification) {
    $notification->markAsRead();
  }
  return redirect()->back();
})->name('read.all.notifications');