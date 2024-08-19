
<?php

use App\Models\User;
use App\Models\Admin\Month;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Holiday;
use App\Http\Controllers\PayslipController;
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
use App\Http\Controllers\Admin\TransportationDeductionController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Authenticate;

  Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


    Route::get('/leaves', [LeaveController::class, 'index'])->name('admin.leaves');
    Route::get('/leaves/{id}', [LeaveController::class, 'show'])->name('admin.leave');
    Route::delete('/delete/leaves/{id}', [LeaveController::class, 'destroy'])->name('admin.leave.delete');
    Route::post('/leaves/action/{id}', [LeaveController::class, 'update'])->name('admin.leave.action');

    Route::get('/vacations', [VacationController::class, 'index'])->name('admin.vacations');
    Route::get('/vacations/pending', [VacationController::class, 'pending'])->name('admin.pending.vacations');
    Route::get('/vacations/upcoming', [VacationController::class, 'upcoming'])->name('admin.upcoming.vacations');
    Route::get('/vacations/search', [VacationController::class, 'search'])->name('admin.search.vacations');
    Route::get('/vacations/balance', [VacationController::class, 'annualBalance'])->name('admin.balance');
    Route::get('/vacations/{id}', [VacationController::class, 'show'])->name('admin.vacation');
    Route::delete('/vacations/delete/{id}', [VacationController::class, 'destroy'])->name('admin.vacation.delete');
    Route::post('/vacations/action/{id}', [VacationController::class, 'update'])->name('admin.vacations.action');

    Route::get('/staff', [StaffController::class, 'index'])->name('admin.staff');
    Route::post('/staff/search/{search}', [StaffController::class, 'search'])->name('admin.staff.search');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('admin.employee.create');
    Route::post('/staff/draft', [StaffController::class, 'draft'])->name('admin.employee.draft');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('admin.employee.store');
    Route::post('staff/email/{email}', [StaffController::class, 'email']);
    Route::get('/staff/{id}', [StaffController::class, 'show'])->name('admin.employee');
    Route::get('/download', [StaffController::class, 'download'])->name('admin.staff.download');
    Route::post('/addSalary', [StaffController::class, 'addSalary'])->name('admin.addSalary');
    Route::post('/editIBAN', [StaffController::class, 'editIBAN'])->name('admin.editIBAN');
    Route::post('/leaver/{id}', [StaffController::class, 'resign'])->name('admin.resingnation');

    Route::get('/iqama', [IqamaController::class, 'index'])->name('admin.iqama');
    Route::post('iqama/renewal/{id}', [IqamaController::class, 'update']);

    Route::get('/letters', [LetterController::class, 'index'])->name('admin.letters');

    Route::get('/visas', [ExitReentryController::class, 'index'])->name('admin.visas');

    Route::get('/visits', [FamilyVisitController::class, 'index'])->name('admin.visits');

		Route::get('/holiday', [HolidayController::class, 'index'])->name('admin.holiday');
		Route::post('/holiday', [HolidayController::class, 'store'])->name('admin.holiday.create');

		Route::get('/salaries', [SalariesController::class, 'index'])->name('admin.salaries');
		Route::post('/salaries', [SalariesController::class, 'store'])->name('admin.salaries.create');
    Route::post('/salaries/process', [SalariesController::class, 'process'])->name('salary.process');
    Route::get('/salaries/working/{month_id}', [SalariesController::class, 'working'])->name('admin.salaries.working');
    Route::get('/salaries/dashboard/{month_id}', [SalariesController::class, 'dashboard'])->name('admin.salaries.dashboard');
    Route::get('/salaries/non/working/{month_id}', [SalariesController::class, 'nonWorking'])->name('admin.salaries.non.working');
    Route::get('/salaries/payables/{month_id}', [PayDeductController::class, 'payables'])->name('admin.salaries.payables');
    Route::post('/salaries/payables', [PayDeductController::class, 'storePayables'])->name('admin.salaries.payables.store');
    Route::get('/salaries/deductables/{month_id}', [PayDeductController::class, 'deductables'])->name('admin.salaries.deductables');
    Route::post('/salaries/deductables', [PayDeductController::class, 'storedeductables'])->name('admin.salaries.deductables.store');
    Route::get('/trasportation/deductions', [TransportationDeductionController::class, 'index'])->name('trasportation.deduction.list');
    Route::post('/trasportation/deductions', [TransportationDeductionController::class, 'store'])->name('trasportation.deduction.create');
    Route::post('/trasportation/deductions/{deduction}', [TransportationDeductionController::class, 'update']);
    Route::get('/salaries/timesheet/{month_id}', [SalariesController::class, 'timesheet'])->withoutMiddleware([Admin::class, Authenticate::class])->name('timesheet');
    Route::get('/salaries/paydeduct/{month_id}', [SalariesController::class, 'paydeduct'])->withoutMiddleware([Admin::class, Authenticate::class])->name('paydeduct');
    Route::get('/salaries/send/{month_id}', [SalariesController::class, 'send'])->name('send');
    Route::get('salaries/payslip', [PayslipController::class, 'index'])->name('admin.payslip');
  });
