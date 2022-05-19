<?php

namespace App\Http\Controllers;

use App\ExternalApi\Game\TypeList;
use App\ExternalApi\User\Balance;
use App\ExternalApi\Wagers\Record;
use App\ExternalApi\Wagers\RecordDetail;
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
        $balance = new Balance;
        $type_list = new TypeList;

        ['gamekind' => $gamekind, 'lang' => $lang] = $request;
        $data = [
            'LoggedUserInfo' => [],
            'DateList' => [],
        ];
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
                'sessionId' => session('sessionId'),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $type_list->GetGameTypeList($request),
                'gamekind' => $gamekind,
                'DateList' => $this->dateList(),
                'lang' => $lang,
            ];
        }
        if (!isset($data['GameTypeList']->result)) {
            return view('wagersRecord/wagersRecord', $data);
        } else {
            return redirect('/')->with('Fail', $data['GameTypeList']->data->Message);
        }
    }
    public function RecordInsert(Request $request)
    {

        $record = new Record;
        // $request->validate([
        //     'starttime' => 'date_format:H:i:s',
        //     'endtime' => 'date_format:H:i:s|after:starttime',
        // ]);
        ['gametype' => $gametype, 'action' => $action, 'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $recordData = [];
        $arr = $record->GetWagersRecord($request);

        if (!isset($arr->Message)) {
            foreach ($arr as $key => $value) {
                $arrdata = [
                    'WagersID' => $value->WagersID,
                    'WagersDate' => $value->WagersDate,
                    'SerialID' => $value->SerialID,
                    'GameType' => $value->GameType,
                    'Result' => $value->Result,
                    'BetAmount' => $value->BetAmount,
                    'Commissionable' => $value->Commissionable,
                    'Payoff' => $value->Payoff,
                    'Currency' => $value->Currency,
                    'ExchangeRate' => $value->ExchangeRate,
                    'ModifiedDate' => $value->ModifiedDate,
                    'Origin' => $value->Origin,
                    'Star' => $value->Star,
                    'userNo' => $value->UserName,
                ];
                array_push($recordData, $arrdata);
            }

            $recordCheck = wagersRecordInfo::whereIn('WagersID', array_column($recordData, 'WagersID'))->get();
            $recordCheckarr = json_decode($recordCheck, true);
            $diff = array_diff(array_map('serialize', $recordData), array_map('serialize', $recordCheckarr));
            $result = array_map('unserialize', $diff);
            wagersRecordInfo::insert($result);

            //recordInfo
            if ($gametype == 'all') {
                $recordInfo = wagersRecordInfo::whereBetween('WagersDate', [$date . ' ' . $starttime, $date . ' ' . $endtime])
                    ->get();
            } elseif ($action == 'BetTime') {
                $recordInfo = wagersRecordInfo::whereBetween('WagersDate', [$date . ' ' . $starttime, $date . ' ' . $endtime])
                    ->where('GameType', $gametype)->get();
            } else {
                $recordInfo = wagersRecordInfo::whereBetween('ModifiedDate', [$date . ' ' . $starttime, $date . ' ' . $endtime])
                    ->where('GameType', $gametype)->get();
            }
            return $recordInfo;
        } else {
            return redirect('/')->with('Fail', $arr->Message);
        }
    }
    public function WagersRecord(Request $request)
    {
        $balance = new Balance;
        $type_list = new TypeList;
        ['gamekind' => $gamekind, 'lang' => $lang] = $request;

        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
                'sessionId' => session('sessionId'),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $type_list->GetGameTypeList($request),
                'gamekind' => $gamekind,
                'DateList' => $this->dateList(),
                'lang' => $lang,
            ];
            $data['RecordInfo'] = $this->RecordInsert($request);
        }

        return view('wagersRecord/wagersRecord', $data);
    }

    public function WagersRecordDetail(Request $request)
    {
        $record_detail = new RecordDetail;
        return redirect($record_detail->GetWagersRecordDetail($request));
    }

}
