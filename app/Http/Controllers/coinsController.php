<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;

class coinsController extends Controller
{
    //顯示轉帳畫面
    public function index()
    {

        //顯示新增頁面
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
            ];
            return view('transfer/transfer', $data);
        }

    }
    //處理轉帳請求
    public function transfer(Request $request)
    {
        //call CheckUsrBalance api
        ['website' => $website, 'uppername' => $uppername, 'account' => $username,
            'action' => $action, 'remit' => $remit,
        ] = $request;

        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999)); //int(19)( 1~9223372036854775806)來做設定
        $KeyB = 'yb89lxTRVB';
        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $key = "11" . md5($website . $username . $remitno . $KeyB . $Date, false) . "222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/Transfer?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&remitno=" . $remitno . "&action=" . $action . "&remit=" . $remit . "&key=" . $key;
        // CheckUsrBalance Response
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        if ($json_data['data']['Code'] == 11100) {
            return redirect('/')->with('Success', 'Transfer successfully!');
        } else {
            return redirect('/')->with('Fail', 'Transfer failfully!Message：' . $json_data['data']['Message']);
        }
    }
}
