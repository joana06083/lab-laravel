<?php

namespace App\Http\Controllers;

use App\ExternalApi\User\Balance;
use App\ExternalApi\User\Transfer;
use App\Models\UserInfo;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;

class CoinsController extends Controller
{
    use ApiTraits;
    //顯示轉帳畫面
    public function Index()
    {
        $balance = new Balance;
        $user = UserInfo::where('userNo', session('LoggedUser'))->first();
        $data = [
            'LoggedUserInfo' => $user,
            'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
        ];
        return view('transfer/transfer', $data);
    }
    //處理轉帳請求
    public function GetTransfer(Request $request)
    {
        $transfer = new Transfer;
        $request->validate([
            'remit' => 'required|numeric',
        ]);
        if ($transfer->GetTransfer($request)->Code == 11100) {
            return redirect('/TransferIndex')->with('Success', 'Transfer successfully!');
        } else {
            return redirect('/TransferIndex')->with('Fail', 'Transfer failfully!Message：' . $transfer->GetTransfer($request)->Message);
        }
    }
}
