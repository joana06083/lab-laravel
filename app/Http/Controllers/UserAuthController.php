<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    //顯示登入畫面
    public function login()
    {
        return view('user/login');
    }

    //顯示註冊畫面
    public function register()
    {
        return view('user/register');
    }

    //處理註冊請求
    public function create(Request $request)
    {
        // 檢驗註冊內容
        $request->validate([
            'email' => 'required|email|unique:userData',
            'account' => 'required|min:5|max:25',
            'password' => 'required|min:5|max:25',
            'name' => 'required',
            'sex' => 'required',
        ]);
        // 檢驗完成寫入資料庫
        $user = new UserInfo;
        $user->userNo = $request->account;
        $user->userName = $request->name;
        $user->password = Hash::make($request->password);
        $user->sex = $request->sex;
        $user->email = $request->email;
        $query = $user->save();

        if ($query) {
            return back()->with('Success', '註冊成功！');
        } else {
            return back()->with('Fail', '註冊失敗！');
        }
    }
    //處理登入請求
    public function check(Request $request)
    {
        // 檢驗註冊內容
        $request->validate([
            'account' => 'required|min:5|max:25',
            'password' => 'required|min:5|max:25',
        ]);
        // 檢驗完成寫入資料庫
        $user = UserInfo::where('userNo', $request->account)->first();

        // return $user;
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('LoggedUser', $user->userNo);
                return redirect('/');
            } else {
                return back()->with('Fail', '登入失敗！此帳號未註冊！');
            }
        } else {
            return back()->with('Fail', '登入失敗！此帳號未註冊！');
        }
    }
    //顯示登入畫面
    public function index()
    {
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
            ];
        } else {
            $data = [
                'LoggedUserInfo' => [],
            ];
        }
        return view('index', $data);
    }
    //處理登出請求
    public function logout()
    {
        session()->flush();
        return redirect('login');
    }
}
