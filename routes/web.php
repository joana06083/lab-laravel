<?php

use App\Http\Controllers\coinsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserAuthController;
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

//顯示網站首頁驗證使用者是否登入
Route::get('/', [UserAuthController::class, 'index']);

//顯示註冊畫面,處理註冊新增資料&顯示登入畫面,處理登入請求
Route::middleware('user.login')->group(function () {
    Route::get('register', [UserAuthController::class, 'register']);
    Route::get('login', [UserAuthController::class, 'login']);
});

Route::post('create', [UserAuthController::class, 'create'])->name('user.create');
Route::post('check', [UserAuthController::class, 'check'])->name('user.check');

//處理查詢請求
Route::match(['get', 'post'], 'search', [UserAuthController::class, 'search']);

//處理登出請求
Route::get('logout', [UserAuthController::class, 'logout']);

// 文章/留言 route
Route::middleware('user.logout')->resource('art', 'ArticleController')->except(['show']);
Route::resource('art', 'ArticleController')->only(['show']);
Route::middleware('user.logout')->resource('mes', 'MessageController');

//處理進入遊戲大廳請求
Route::post('GameIndex', [GameController::class, 'GameIndex']);

//處理轉帳請求
Route::middleware('user.logout')->get('transferIndex', [coinsController::class, 'index']);
Route::post('transfer', [coinsController::class, 'transfer']);
