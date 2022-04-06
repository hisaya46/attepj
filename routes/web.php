<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

//打刻ページ
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [AttendanceController::class, 'getIndex']);
    Route::post('/attendance/start', [AttendanceController::class, 'startAttendance'])->name('timestamp/start');
    Route::post('/attendance/end', [AttendanceController::class, 'endAttendance'])->name('timestamp/end');
});
// Route::get('/', [AttendanceController::class, 'getIndex'])->middleware(['auth']);






//日付一覧ページ
Route::get('/attendance', [AttendanceController::class, 'getAttendance'])->middleware(['auth']);

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
