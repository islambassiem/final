
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Holiday;
use App\Http\Controllers\Admin\IqamaController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\SalariesController;
use App\Http\Controllers\Admin\VacationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExitReentryController;
use App\Http\Controllers\Admin\FamilyVisitController;
use App\Http\Controllers\Admin\Salaries\PayDeductController;

  Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


    Route::get('/leaves', [LeaveController::class, 'index'])->name('admin.leaves');
    Route::get('/leaves/{id}', [LeaveController::class, 'show'])->name('admin.leave');
    Route::delete('/delete/leaves/{id}', [LeaveController::class, 'destroy'])->name('admin.leave.delete');
    Route::post('/leaves/action/{id}', [LeaveController::class, 'update'])->name('admin.leave.action');

    Route::get('/vacations', [VacationController::class, 'index'])->name('admin.vacations');
    Route::get('/balance', [VacationController::class, 'annualBalance'])->name('admin.balance');
    Route::get('/vacations/{id}', [VacationController::class, 'show'])->name('admin.vacation');
    Route::delete('/delete/vacations/{id}', [VacationController::class, 'destroy'])->name('admin.vacation.delete');
    Route::post('/vacations/action/{id}', [VacationController::class, 'update'])->name('admin.vacations.action');

    Route::get('/staff', [StaffController::class, 'index'])->name('admin.staff');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('admin.employee.create');
    Route::post('/staff/draft', [StaffController::class, 'draft'])->name('admin.employee.draft');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('admin.employee.store');
    Route::post('staff/email/{email}', [StaffController::class, 'email']);
    Route::get('/staff/{id}', [StaffController::class, 'show'])->name('admin.employee');


    Route::get('/iqama', [IqamaController::class, 'index'])->name('admin.iqama');
    Route::post('iqama/renewal/{id}', [IqamaController::class, 'update']);

    Route::get('/letters', [LetterController::class, 'index'])->name('admin.letters');

    Route::get('/visas', [ExitReentryController::class, 'index'])->name('admin.visas');

    Route::get('/visits', [FamilyVisitController::class, 'index'])->name('admin.visits');

		Route::get('/holiday', [HolidayController::class, 'index'])->name('admin.holiday');
		Route::post('/holiday', [HolidayController::class, 'store'])->name('admin.holiday.create');

		Route::get('/salaries', [SalariesController::class, 'index'])->name('admin.salaries');
		Route::post('/salaries', [SalariesController::class, 'store'])->name('admin.salaries.create');
    Route::post('/salaries/process/{month}', [SalariesController::class, 'process']);
    Route::get('/salaries/working/{month_id}', [SalariesController::class, 'working'])->name('admin.salaries.working');
    Route::get('/salaries/non/working/{month_id}', [SalariesController::class, 'nonWorking'])->name('admin.salaries.non.working');
    Route::get('/salaries/payables/{month_id}', [PayDeductController::class, 'payables'])->name('admin.salaries.payables');
    Route::post('/salaries/payables', [PayDeductController::class, 'storePayables'])->name('admin.salaries.payables.store');
    Route::get('/salaries/deductables/{month_id}', [PayDeductController::class, 'deductables'])->name('admin.salaries.deductables');
    Route::post('/salaries/deductables', [PayDeductController::class, 'storedeductables'])->name('admin.salaries.deductables.store');
  });
