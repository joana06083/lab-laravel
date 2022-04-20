<?php

use App\Http\Controllers\api\UserInfoController;
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
// user使用者route
Route::get('user', [UserInfoController::class, 'index']);
Route::get('user/{id}', [UserInfoController::class, 'show’']);
Route::post('user/signup', [UserInfoController::class, 'store']);
Route::put('user/{id}', [UserInfoController::class, 'update']);
Route::delete('user/{id}', [UserInfoController::class, 'destroy']);
