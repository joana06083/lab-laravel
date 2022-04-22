<?php

use App\Http\Controllers\ArticleController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

//顯示網站首頁驗證使用者是否登入
Route::get('/', [UserAuthController::class, 'index']);
//顯示登入畫面,處理登入請求
Route::get('login', [UserAuthController::class, 'login']);
Route::post('check', [UserAuthController::class, 'check'])->name('user.check');
//顯示註冊畫面,處理註冊新增資料
Route::get('register', [UserAuthController::class, 'register']);
Route::post('create', [UserAuthController::class, 'create'])->name('user.create');
//處理登出請求
Route::get('logout', [UserAuthController::class, 'logout']);

// 文章route
// Route::get('', [ArticleController::class, 'index']);
Route::get('art/create', [ArticleController::class, 'create']);
Route::get('art/edit', [ArticleController::class, 'edit']);
Route::get('art/show’', [ArticleController::class, 'show’']);

Route::post('art/store', [ArticleController::class, 'store'])->name('art.create');
Route::put('art/update', [ArticleController::class, 'update']);
Route::delete('art/destroy', [ArticleController::class, 'destroy']);
