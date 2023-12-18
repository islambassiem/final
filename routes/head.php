<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Head\StaffController;
use App\Http\Controllers\Head\PermissionController;
use App\Http\Controllers\Head\HeadVacationController;
use App\Http\Controllers\Head\HeadPermissionController;



Route::get('staff', [StaffController::class, 'index'])->name('staff.index');


Route::get('sLeave', [HeadPermissionController::class, 'index'])->name('sLeave.index');
Route::get('sLeave/show/{id}', [HeadPermissionController::class, 'show'])->name('sLeave.show');
Route::post('sLeave/update/{id}', [HeadPermissionController::class, 'update'])->name('sLeave.update');


Route::get('lLeave', [HeadVacationController::class, 'index'])->name('lLeave.index');
Route::get('lLeave/show/{id}', [HeadVacationController::class, 'show'])->name('lLeave.show');
Route::post('lLeave/update/{id}', [HeadVacationController::class, 'update'])->name('lLeave.update');