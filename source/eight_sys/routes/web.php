<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 //company
 Route::resource('company','App\Http\Controllers\companyController');
 //user_detail
 Route::resource('userDetail','App\Http\Controllers\userDetailController');
 //attendance
 Route::resource('attendance','App\Http\Controllers\attendanceController');
 //attendance_detail
 Route::resource('attendanceDetail','App\Http\Controllers\attendanceDetailController');
 //requestRest
 Route::resource('requestRest','App\Http\Controllers\requestRestController');
 //requestRestManagement
 Route::resource('requestRestManagement','App\Http\Controllers\requestRestManagementController');
 //aggregate
 Route::resource('aggregate','App\Http\Controllers\aggregateController');
 //setting
 Route::resource('setting','App\Http\Controllers\settingController');

 Auth::routes();


 Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

 //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home2');
;
