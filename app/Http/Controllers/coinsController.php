<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;

class CoinsController extends Controller
{
    use ApiTraits;
    //顯示轉帳畫面
    public function index()
    {
        $user = UserInfo::where('userNo', session('LoggedUser'))->first();
        $data = [
            'LoggedUserInfo' => $user,
            'UsrBalance' => $this->CheckUsrBalance(session('LoggedUser')),
        ];
        return view('transfer/transfer', $data);
    }
    //處理轉帳請求
    public function getTransfer(Request $request)
    {
        $request->validate([
            'remit' => 'required|numeric',
        ]);
        if ($this->Transfer($request)->Code == 11100) {
            return redirect('/transferIndex')->with('Success', 'Transfer successfully!');
        } else {
            return redirect('/transferIndex')->with('Fail', 'Transfer failfully!Message：' . $this->Transfer($request)->Message);
        }
    }
}
