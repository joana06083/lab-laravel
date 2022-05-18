<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Models\wagersRecordInfo;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;

class WagersRecordController extends Controller
{
    use ApiTraits;
    public function dateList()
    {
        //date
        $datelist = [];
        for ($i = 0; $i <= 6; $i++) {
            array_push($datelist, date('Y-m-d', strtotime("-{$i} day")));
        }
        return $datelist;
    }

    public function WagersRecordIndex(Request $request)
    {
        ['gamekind' => $gamekind, 'lang' => $lang] = $request;
        $data = [
            'LoggedUserInfo' => [],
            'DateList' => [],
        ];
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
                'ApiData' => session('ApiData'),
                'UsrBalance' => $this->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $this->GetGameTypeList($lang, $gamekind),
                'gamekind' => $gamekind,
                'DateList' => $this->dateList(),
                'lang' => $lang,
            ];
        }

        if (!isset($data['GameTypeList']['result'])) {
            return view('wagersRecord/wagersRecord', $data);
        } else {
            return redirect('/')->with('Fail', $data['GameTypeList']['data']['Message']);
        }
    }
    public function WagersRecord(Request $request)
    {
        $request->validate([
            'starttime' => 'required|',
            'endtime' => 'required|',
        ]);
        ['gamekind' => $gamekind, 'gametype' => $gametype, 'action' => $action, 'lang' => $lang,
            'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $recordData = [];
        $arr = $this->GetWagersRecord($request);

        if (!isset($arr['Message'])) {
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
                if ($action == 'BetTime') {
                    $recordInfo = wagersRecordInfo::whereBetween('WagersDate', [$date . ' ' . $starttime, $date . ' ' . $endtime])
                        ->where('GameType', $gametype)->get();
                } else {
                    $recordInfo = wagersRecordInfo::whereBetween('ModifiedDate', [$date . ' ' . $starttime, $date . ' ' . $endtime])
                        ->where('GameType', $gametype)->get();
                }
                $data = [
                    'LoggedUserInfo' => $user,
                    'ApiData' => session('ApiData'),
                    'UsrBalance' => $this->CheckUsrBalance(session('LoggedUser')),
                    'GameTypeList' => $this->GetGameTypeList($lang, $gamekind),
                    'gamekind' => $gamekind,
                    'DateList' => $this->dateList(),
                    'RecordInfo' => $recordInfo,
                    'lang' => $lang,
                ];
            }
            return view('wagersRecord/wagersRecord', $data);
        } else {
            return redirect('/')->with('Fail', $arr['Message']);
        }
    }

    public function WagersRecordDetail(Request $request)
    {
        return redirect($this->GetWagersRecordDetail($request));
    }

}
