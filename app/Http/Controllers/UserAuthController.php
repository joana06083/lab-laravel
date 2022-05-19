<?php

namespace App\Http\Controllers;

use App\ExternalApi\Game\TypeList;
use App\ExternalApi\User\Balance;
use App\ExternalApi\User\Session;
use App\Models\UserInfo;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    use ApiTraits;
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
            return back()->with('Success', 'Registration success！');
        } else {
            return back()->with('Fail', 'Registration failed!');
        }
    }

    //處理登出請求
    public function logout()
    {
        session()->flush();
        return redirect('login')->with('logout', 'Logout Successfully !');
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

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('LoggedUser', $user->userNo);
                $session = new Session;
                $session->CreateSession($user->userNo);
                return redirect('/')->with('Success', 'Login successfully!');
            } else {
                return back()->with('Fail', 'Login failfully!Password error!');
            }
        } else {
            return back()->with('Fail', 'Login failfully!This account is not registered！');
        }
    }

    //顯示首頁畫面
    public function index()
    {
        $balance = new Balance;
        $data = [
            'LoggedUserInfo' => [],
        ];
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
                'sessionId' => session('sessionId'),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
            ];
        }

        return view('index', $data);
    }

    //顯示首頁查詢後畫面
    public function search(Request $request)
    {
        $balance = new Balance;
        $type_list = new TypeList;

        $data = [
            'LoggedUserInfo' => [],
            'GameTypeList' => [],
        ];
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
                'sessionId' => session('sessionId'),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $type_list->GetGameTypeList($request),
                'gamekind' => $request->gamekind,
            ];
        }
        if (!isset($data['GameTypeList']->result)) {
            return view('index', $data);
        } else {
            return redirect('/')->with('Fail', $data['GameTypeList']->data->Message);
        }

    }

}
