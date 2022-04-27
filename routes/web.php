<?php

// use App\Http\Controllers\ArticleController;
// use App\Http\Controllers\MessageController;
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

//顯示註冊畫面,處理註冊新增資料
Route::middleware('user.login')->get('register', [UserAuthController::class, 'register']);
Route::post('create', [UserAuthController::class, 'create'])->name('user.create');

//顯示登入畫面,處理登入請求
Route::middleware('user.login')->get('login', [UserAuthController::class, 'login']);
Route::post('check', [UserAuthController::class, 'check'])->name('user.check');

//處理查詢請求
Route::post('search', [UserAuthController::class, 'search']);

//處理登出請求
Route::get('logout', [UserAuthController::class, 'logout']);

// 文章/留言 route
Route::resource('art', 'ArticleController');
Route::resource('mes', 'MessageController');
