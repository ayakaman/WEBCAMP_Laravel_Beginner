<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;

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

// タスク管理システム
Route::get('/', [AuthController::class, 'index'])->name('front.index');
Route::post('/login', [AuthController::class, 'login']);

//認可処理
Route::middleware(['auth'])->group(function () {
   Route::prefix('/task')->group(function () {
       Route::get('/list', [TaskController::class, 'list']);
       Route::post('/register', [TaskController::class, 'register']);
       Route::get('/detail/{task_id}', [TaskController::class, 'detail'])->whereNumber('task_id')->name('detail');
       Route::get('/edit/{task_id}', [TaskController::class, 'edit'])->whereNumber('task_id')->name('edit');
       Route::put('/edit/{task_id}', [TaskController::class, 'editSave'])->whereNumber('task_id')->name('edit_save');
    });
       //
       Route::get('/logout', [AuthController::class, 'logout']);
});

//テスト用
Route::get('/welcome', [WelcomeController::class, 'index']);
Route::get('/welcome/second', [WelcomeController::class, 'second']);

// form入力テスト用
Route::get('/test', [TestController::class, 'index']);
Route::post('/test/input', [TestController::class, 'input']);