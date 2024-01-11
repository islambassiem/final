
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\VacationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExitReentryController;
use App\Http\Controllers\Admin\FamilyVisitController;
use App\Http\Controllers\Admin\IqamaController;
use App\Http\Controllers\Admin\LetterController;

  Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


    Route::get('/leaves', [LeaveController::class, 'index'])->name('admin.leaves');
    Route::get('/leaves/{id}', [LeaveController::class, 'show'])->name('admin.leave');
    Route::post('/leaves/action/{id}', [LeaveController::class, 'update'])->name('admin.leave.action');

    Route::get('/vacations', [VacationController::class, 'index'])->name('admin.vacations');
    Route::get('/vacations/{id}', [VacationController::class, 'show'])->name('admin.vacation');
    Route::post('/vacations/action/{id}', [VacationController::class, 'update'])->name('admin.vacations.action');

    Route::get('/staff', [StaffController::class, 'index'])->name('admin.staff');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('admin.employee.create');
    Route::post('/staff/draft', [StaffController::class, 'draft'])->name('admin.employee.draft');
    Route::get('/staff/{id}', [StaffController::class, 'show'])->name('admin.employee');


    Route::get('/iqama', [IqamaController::class, 'index'])->name('admin.iqama');
    Route::post('iqama/renewal/{id}', [IqamaController::class, 'update']);

    Route::get('/letters', [LetterController::class, 'index'])->name('admin.letters');

    Route::get('/visas', [ExitReentryController::class, 'index'])->name('admin.visas');

    Route::get('/visits', [FamilyVisitController::class, 'index'])->name('admin.visits');
  });