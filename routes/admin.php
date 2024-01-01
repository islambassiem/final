
<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeaveController;
use Illuminate\Support\Facades\Route;




  Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


    Route::get('/leaves', [LeaveController::class, 'index'])->name('admin.leaves');
    Route::get('/leaves/{id}', [LeaveController::class, 'show'])->name('admin.leave');
    Route::post('/leaves/action/{id}', [LeaveController::class, 'update'])->name('admin.leave.action');
  });