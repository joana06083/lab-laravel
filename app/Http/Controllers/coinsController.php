<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;

class coinsController extends Controller
{
    use ApiTraits;
    //顯示轉帳畫面
    public function index()
    {
        $user = UserInfo::where('userNo', session('LoggedUser'))->first();

        $data = [
            'LoggedUserInfo' => $user,
            'ApiData' => session('ApiData'),
            'UsrBalance' => $this->CheckUsrBalance(session('LoggedUser')),
        ];

        return view('transfer/transfer', $data);
    }
    //處理轉帳請求
    public function getTransfer(Request $request)
    {
        ['account' => $username, 'action' => $action, 'remit' => $remit] = $request;

        if ($this->Transfer($username, $action, $remit)['Code'] == 11100) {
            return redirect('/transferIndex')->with('Success', 'Transfer successfully!');
        } else {
            return redirect('/transferIndex')->with('Fail', 'Transfer failfully!Message：' . $this->Transfer($username, $action, $remit)['Message']);
        }
    }
}
