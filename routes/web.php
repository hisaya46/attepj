<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\UserListController;



//打刻ページ
Route::middleware('auth', 'verified')->group(
    function () {
        //ログイン後
        Route::get('/', [AttendanceController::class, 'getIndex'])->name('stamping');
        //勤務開始
        Route::post('/attendance/start', [AttendanceController::class, 'startAttendance'])->name('timestamp/start');
        //勤務終了
        Route::post('/attendance/end', [AttendanceController::class, 'endAttendance'])->name('timestamp/end');
        //休憩開始
        Route::post('/break/start', [RestController::class, 'startRest'])->name('timestamp/breakin');
        //休憩終了
        Route::post('/break/end', [RestController::class, 'endRest'])->name('timestamp/breakout');
        //日付一覧ページ
        Route::get('/attendance', [AttendanceController::class, 'getAttendance'])->name('attendance');
        Route::post('/attendance', [AttendanceController::class, 'changeDate']);
        //ユーザー一覧ページ
        Route::get('/user/list', [UserListController::class, 'getUserList'])->name('user/list');
        Route::get('/one/user/attendance/{id}', [UserListController::class, 'getOneUserAttendance']);
        Route::post('/one/user/attendance/{id}', [UserListController::class, 'changeMonth']);
    }
);
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
