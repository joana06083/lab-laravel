<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Models\wagersRecordInfo;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;

class WagersRecordController extends Controller
{
    use ApiTraits;

    public function WagersRecordIndex(Request $request)
    {
        ['gamekind' => $gamekind, 'lang' => $lang] = $request;

        $data = [
            'LoggedUserInfo' => [],
            'GameTypeList' => [],
            'DateList' => [],
        ];
        if (session()->has('LoggedUser')) {

            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            //date
            $datelist = [];
            for ($i = 0; $i <= 6; $i++) {
                array_push($datelist, date('Y-m-d', strtotime("-{$i} day")));
            }

            $data = [
                'LoggedUserInfo' => $user,
                'ApiData' => session('ApiData'),
                'UsrBalance' => $this->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $this->GetGameTypeList($lang, $gamekind),
                'gamekind' => $gamekind,
                'DateList' => $datelist,
                'lang' => $lang,
            ];
        }
        return view('wagersRecord/wagersRecord', $data);
    }
    public function WagersRecord(Request $request)
    {

        ['gamekind' => $gamekind, 'gametype' => $gametype, 'date' => $date, 'action' => $action, 'lang' => $lang] = $request;

        $recordData = [];
        $arr = $this->GetWagersRecord($gamekind, $gametype, $date, $action);
        foreach ($arr as $key => $value) {
            $data = [
                'WagersID' => $value['WagersID'],
                'WagersDate' => $value['WagersDate'],
                'SerialID' => $value['SerialID'],
                'GameType' => $value['GameType'],
                'Result' => $value['Result'],
                'BetAmount' => $value['BetAmount'],
                'Commissionable' => $value['Commissionable'],
                'Payoff' => $value['Payoff'],
                'Currency' => $value['Currency'],
                'ExchangeRate' => $value['ExchangeRate'],
                'ModifiedDate' => $value['ModifiedDate'],
                'Origin' => $value['Origin'],
                'Star' => $value['Star'],
                'userNo' => $value['UserName'],
            ];
            array_push($recordData, $data);
        }

        $recordCheck = wagersRecordInfo::whereIn('WagersID', array_column($recordData, 'WagersID'))->get();
        $recordCheckarr = json_decode($recordCheck, true);
        $diff = array_diff(array_map('serialize', $recordData), array_map('serialize', $recordCheckarr));
        $result = array_map('unserialize', $diff);
        wagersRecordInfo::insert($result);

        //導回查詢畫面
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();

            //date
            $datelist = [];
            for ($i = 0; $i <= 6; $i++) {
                array_push($datelist, date('Y-m-d', strtotime("-{$i} day")));
            }

            //明細
            if ($action == 'BetTime') {
                $recordInfo = wagersRecordInfo::whereBetween('WagersDate', [$date . ' 00:00:00', $date . ' 23:59:59'])
                    ->where('GameType', $gametype)->get();
            } else {
                $recordInfo = wagersRecordInfo::whereBetween('ModifiedDate', [$date . ' 00:00:00', $date . ' 23:59:59'])
                    ->where('GameType', $gametype)->get();
            }
            $data = [
                'LoggedUserInfo' => $user,
                'ApiData' => session('ApiData'),
                'UsrBalance' => $this->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $this->GetGameTypeList($lang, $gamekind),
                'gamekind' => $gamekind,
                'DateList' => $datelist,
                'RecordInfo' => $recordInfo,
                'lang' => $lang,
            ];
        }
        return view('wagersRecord/wagersRecord', $data);
    }

    public function WagersRecordDetail(Request $request)
    {
        ['gamekind' => $gamekind, 'lang' => $lang, 'username' => $username,
            'wagersid' => $wagersid, 'gametype' => $gametype] = $request;
        return redirect($this->GetWagersRecordDetail($gamekind, $lang, $username, $wagersid, $gametype));

    }

}
