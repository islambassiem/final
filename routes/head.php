<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Head\StaffController;
use App\Http\Controllers\Head\PermissionController;
use App\Http\Controllers\Head\HeadVacationController;
use App\Http\Controllers\Head\HeadPermissionController;



Route::get('staff', [StaffController::class, 'index'])->name('staff.index');


Route::get('sLeave', [HeadPermissionController::class, 'index'])->name('sLeave.index');


Route::get('lLeave', [HeadVacationController::class, 'index'])->name('lLeave.index');