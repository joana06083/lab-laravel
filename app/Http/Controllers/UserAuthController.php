<?php

namespace App\Http\Controllers;

use App\ExternalApi\Game\TypeList;
use App\ExternalApi\User\Balance;
use App\ExternalApi\User\Session;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    //顯示登入畫面
    public function Login()
    {
        return view('User/Login');
    }

    //顯示註冊畫面
    public function Register()
    {
        return view('User/Register');
    }

    //處理註冊請求
    public function Create(Request $request)
    {
        // 檢驗註冊內容
        $request->validate([
            'email' => 'required|email|unique:userData',
            'userNo' => 'required|min:5|max:25|unique:userData',
            'password' => 'required|min:5|max:25',
            'name' => 'required',
            'sex' => 'required',
        ]);
        // 檢驗完成寫入資料庫
        $user = new UserInfo;
        $user->email = $request->email;
        $user->userNo = $request->userNo;
        $user->password = Hash::make($request->password);
        $user->userName = $request->name;
        $user->sex = $request->sex;
        $query = $user->save();

        if ($query) {
            return back()->with('Success', 'Registration success！');
        } else {
            return back()->with('Fail', 'Registration failed!');
        }

    }

    //處理登出請求
    public function Logout()
    {
        session()->flush();
        return redirect('Login')->with('logout', 'Logout Successfully !');
    }

    //處理登入請求
    public function Check(Request $request)
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
                $session_id = $session->CreateSession($user->userNo);
                session()->put('session_id', $session_id);
                return redirect('/')->with('Success', 'Login successfully!');
            }
            return back()->with('Fail', 'Login failfully!Password error!');
        }
        return back()->with('Fail', 'Login failfully!This account is not registered！');

    }

    //顯示首頁畫面
    public function Index()
    {
        $balance = new Balance;
        $data = [
            'LoggedUserInfo' => [],
        ];
        if (session()->has('LoggedUser') && session()->has('session_id')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
                'sessionId' => session('session_id'),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
            ];
        }
        return view('Index', $data);
    }

    //顯示首頁查詢後畫面
    public function Search(Request $request)
    {
        $balance = new Balance;
        $type_list = new TypeList;

        $data = [
            'LoggedUserInfo' => [],
            'GameTypeList' => [],
        ];

        if (session()->has('LoggedUser') && session()->has('session_id')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $request_data = [
                'gamekind' => $request->gamekind,
                'lang' => $request->lang,
            ];
            $data = [
                'LoggedUserInfo' => $user,
                'sessionId' => session('session_id'),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $type_list->GetGameTypeList($request_data),
                'gamekind' => $request->gamekind,
            ];
        }
        if (!isset($data['GameTypeList']->result)) {
            return view('Index', $data);
        } else {
            return redirect('/')->with('Fail', $data['GameTypeList']->data->Message);
        }

    }

}
