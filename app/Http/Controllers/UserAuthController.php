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
            return back()->with('Success', 'Registration success！');
        } else {
            return back()->with('Fail', 'Registration failed!');
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

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('LoggedUser', $user->userNo);

                //call CreateSession api
                $website = 'bbinbgp';
                $uppername = 'dpidtest';
                $username = $request->account;
                $KeyB = '4GZ2qQ';
                date_default_timezone_set("America/New_York");
                $Date = date("Ymd");
                $key = "11" . md5($website . $username . $KeyB . $Date, false) . "2222222";
                $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CreateSession?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&key=" . $key;

                //Response
                $json = file_get_contents($url);
                $json_data = json_decode($json, true);
                $sessionid = $json_data['data']['sessionid'];
                session()->put('ApiData', $sessionid);

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
        $data = [
            'LoggedUserInfo' => [],
        ];
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            //call CheckUsrBalance api
            $website = 'bbinbgp';
            $uppername = 'dpidtest';
            $username = session('LoggedUser');
            $KeyB = 'D5zIM6';
            date_default_timezone_set("America/New_York");
            $Date = date("Ymd");
            $key = "1" . md5($website . $username . $KeyB . $Date, false) . "2222";
            $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CheckUsrBalance?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&key=" . $key;

            // CheckUsrBalance Response
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);

            $data = [
                'LoggedUserInfo' => $user,
                'ApiData' => session('ApiData'),
                'UsrBalance' => [
                    "Currency" => $json_data['data'][0]['Currency'], //幣別
                    "Balance" => $json_data['data'][0]['Balance'], //額度
                    "TotalBalance" => $json_data['data'][0]['TotalBalance'], //總額度
                ],
            ];
        }

        return view('index', $data);
    }
    //顯示首頁查詢後畫面
    public function search(Request $request)
    {
        $data = [
            'LoggedUserInfo' => [],
            'GameTypeList' => [],
        ];
        if (session()->has('LoggedUser')) {

            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            //call CheckUsrBalance api
            $website = 'bbinbgp';
            $uppername = 'dpidtest';
            $username = session('LoggedUser');
            $KeyB = 'D5zIM6';
            date_default_timezone_set("America/New_York");
            $Date = date("Ymd");
            $key = "1" . md5($website . $username . $KeyB . $Date, false) . "2222";
            $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CheckUsrBalance?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&key=" . $key;

            // CheckUsrBalance Response
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);

            //call GetGameTypeList api
            $game_KeyB = '601gyM';
            $lang = $request->lang;
            $gamekind = $request->gamekind;
            $game_Date = date("Ymd");
            $game_key = "11111111" . md5($website . $game_KeyB . $game_Date, false) . "2222";
            $game_url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GetGameTypeList?website=" .
                $website . "&lang=" . $lang . "&gamekind=" . $gamekind . "&key=" . $game_key;

            // GetGameTypeList Response
            $game_json = file_get_contents($game_url);
            $game_json_data = json_decode($game_json, true);
            $data = [
                'LoggedUserInfo' => $user,
                'ApiData' => session('ApiData'),
                'UsrBalance' => [
                    "Currency" => $json_data['data'][0]['Currency'], //幣別
                    "Balance" => $json_data['data'][0]['Balance'], //額度
                    "TotalBalance" => $json_data['data'][0]['TotalBalance'], //總額度
                ],
                'GameTypeList' => $game_json_data['data'],
                'gamekind' => $gamekind,
            ];
        }
        return view('index', $data);
    }

    //處理登出請求
    public function logout()
    {
        session()->flush();
        return redirect('login')->with('logout', 'Logout Successfully !');
    }
}
