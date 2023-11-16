<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth')->group(function () {
    Route::get('/', [StampController::class, 'index']);
    Route::post('/start_work', [StampController::class, 'start_work']);
    Route::post('/end_work', [StampController::class, 'end_work']);
    Route::post('/start_rest', [StampController::class, 'start_rest']);
    Route::post('/end_rest', [StampController::class, 'end_rest']);

    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::get('/attendance/next_date', [AttendanceController::class, 'next_date']);
    Route::get('/attendance/previous_date', [AttendanceController::class, 'previous_date']);

    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user_information', [UserController::class, 'information']);
});
