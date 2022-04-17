<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

//打刻ページ
Route::group(['middleware' => 'auth'], function () {
    //勤務開始
    Route::get('/', [AttendanceController::class, 'getIndex']);
    Route::post('/attendance/start', [AttendanceController::class, 'startAttendance'])->name('timestamp/start');
    //勤務終了
    Route::get('/end', [AttendanceController::class, 'getEnd'])->name('end'); //←必要ないかも
    Route::post('/attendance/end', [AttendanceController::class, 'endAttendance'])->name('timestamp/end');
    //休憩開始
    Route::get('/breakin', [AttendanceController::class, 'getBreakin'])->name('breakin');
    Route::post('/break/start', [RestController::class, 'startRest'])->name('timestamp/breakin');
    //休憩終了
    Route::get('/breakout', [AttendanceController::class, 'getBreakout'])->name('breakout');
    Route::post('/break/end', [RestController::class, 'endRest'])->name('timestamp/breakout');
});

//日付一覧ページ
Route::get('/attendance', [AttendanceController::class, 'getAttendance'])->middleware(['auth']);
Route::post('/attendance', [AttendanceController::class, 'changeDate'])->middleware(['auth']);

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('index');
// })->middleware(['auth']);

require __DIR__ . '/auth.php';
