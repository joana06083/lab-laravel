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
Route::get('Logout', [UserAuthController::class, 'Logout']);
//顯示註冊畫面,處理註冊新增資料&顯示登入畫面,處理登入請求
Route::middleware('User.Login')->group(function () {
    Route::get('Register', [UserAuthController::class, 'Register']);
    Route::get('Login', [UserAuthController::class, 'Login']);
});

Route::post('Create', [UserAuthController::class, 'Create'])->name('User.Create');
Route::post('Check', [UserAuthController::class, 'Check'])->name('User.Check');

//處理查詢請求
Route::match(['get', 'post'], 'Search', [UserAuthController::class, 'Search']);

// 文章/留言 route
Route::middleware('User.Logout')->resource('Art', 'ArticleController')->except(['show']);
Route::resource('Art', 'ArticleController')->only(['show']);
Route::middleware('User.Logout')->resource('Mes', 'MessageController');

//處理轉帳請求
Route::middleware('User.Logout')->get('TransferIndex', [CoinsController::class, 'Index']);
Route::post('Transfer', [CoinsController::class, 'GetTransfer']);

//處理進入遊戲大廳請求
Route::post('GameIndex', [GameController::class, 'Index']);
//明細
Route::post('WagersRecordIndex', [WagersRecordController::class, 'WagersRecordIndex']);
// Route::post('WagersRecord', [WagersRecordController::class, 'WagersRecord']);
Route::match(['get', 'post'], 'WagersRecord', [WagersRecordController::class, 'WagersRecord']);

Route::post('WagersRecordDetail', [WagersRecordController::class, 'WagersRecordDetail']);
