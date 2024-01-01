
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\VacationController;
use App\Http\Controllers\Admin\DashboardController;




  Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


    Route::get('/leaves', [LeaveController::class, 'index'])->name('admin.leaves');
    Route::get('/leaves/{id}', [LeaveController::class, 'show'])->name('admin.leave');
    Route::post('/leaves/action/{id}', [LeaveController::class, 'update'])->name('admin.leave.action');

    Route::get('/vacations', [VacationController::class, 'index'])->name('admin.vacations');
    Route::get('/vacations/{id}', [VacationController::class, 'show'])->name('admin.vacation');
    Route::post('/vacations/action/{id}', [VacationController::class, 'update'])->name('admin.vacations.action');
  });