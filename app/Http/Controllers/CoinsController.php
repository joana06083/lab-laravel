<?php

namespace App\Http\Controllers;

use App\ExternalApi\User\Balance;
use App\ExternalApi\User\Transfer;
use App\Models\UserInfo;
use App\Traits\SessionTraits;
use Illuminate\Http\Request;

class CoinsController extends Controller
{
    use SessionTraits;
    //顯示轉帳畫面
    public function Index()
    {
        $this->ClearSession();
        $balance = new Balance;
        if (session()->has('LoggedUser') && session()->has('session_id')) {
            $data = [
                'LoggedUserInfo' => UserInfo::where('userNo', session('LoggedUser'))->first(),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
            ];
        }
        return view('Transfer/Transfer', $data);
    }
    //處理轉帳請求
    public function GetTransfer(Request $request)
    {
        $transfer = new Transfer;
        $request->validate([
            'remit' => 'required|numeric',
        ]);

        $request_data = [
            'username' => $request->account,
            'action' => $request->action,
            'remit' => $request->remit,
        ];

        return redirect('/TransferIndex')->with('Success', $transfer->GetTransfer($request_data));
    }
}
