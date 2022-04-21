<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

//驗證
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

// 透過GET方法，導向「/user」，執行UserInfoController的function，並回傳某個畫面
// ex:
// Route::get('user/login', [UserInfoController::class, 'index']); //抓取所有資料的列表
// Route::get('user/{id}', [UserInfoController::class, 'show’']); //抓取指定 id 的資料
// Route::post('user/signup', [UserInfoController::class, 'store']); //新增資料
// Route::put('user/{id}', [UserInfoController::class, 'update']); //更新資料
// Route::delete('user/{id}', [UserInfoController::class, 'destroy']); //刪除資料

//顯示網站首頁驗證使用者是否登入

//顯示登入畫面
//處理登入請求

//處理登出請求

//處理註冊新增資料
