<?php

use App\Http\Controllers\CoinsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\WagersRecordController;
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
Route::get('/', [UserAuthController::class, 'Index']);
//處理登出請求
Route::get('logout', [UserAuthController::class, 'Logout']);
//顯示註冊畫面,處理註冊新增資料&顯示登入畫面,處理登入請求
Route::middleware('user.login')->group(function () {
    Route::get('register', [UserAuthController::class, 'Register']);
    Route::get('login', [UserAuthController::class, 'Login']);
});

Route::post('create', [UserAuthController::class, 'Create'])->name('user.create');
Route::post('check', [UserAuthController::class, 'Check'])->name('user.check');

//處理查詢請求
Route::match(['get', 'post'], 'Search', [UserAuthController::class, 'Search']);

// 文章/留言 route
Route::middleware('user.logout')->resource('art', 'ArticleController')->except(['show']);
Route::resource('art', 'ArticleController')->only(['show']);
Route::middleware('user.logout')->resource('mes', 'MessageController');

//處理轉帳請求
Route::middleware('user.logout')->get('TransferIndex', [CoinsController::class, 'Index']);
Route::post('Transfer', [CoinsController::class, 'GetTransfer']);

//處理進入遊戲大廳請求
Route::post('GameIndex', [GameController::class, 'Index']);
//明細
Route::post('WagersRecordIndex', [WagersRecordController::class, 'WagersRecordIndex']);
Route::post('WagersRecord', [WagersRecordController::class, 'WagersRecord']);
Route::post('WagersRecordDetail', [WagersRecordController::class, 'WagersRecordDetail']);
