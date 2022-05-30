<?php

namespace App\Http\Controllers;

use App\ExternalApi\Game\TypeList;
use App\ExternalApi\User\Balance;
use App\ExternalApi\Wagers\RecordDetail;
use App\Models\UserInfo;
use App\Models\WagersRecordInfo;
use Illuminate\Http\Request;

class WagersRecordController extends Controller
{
    public function DateList()
    {
        $date_list = [];
        for ($i = 0; $i <= 6; $i++) {
            array_push($date_list, date('Y-m-d', strtotime("-{$i} day")));
        }
        return $date_list;
    }

    public function WagersRecord(Request $request)
    {
        $balance = new Balance;
        $type_list = new TypeList;

        [
            'gametype' => $gametype,
            'action' => $action,
            'date' => $date,
            'starttime' => $starttime,
            'endtime' => $endtime,
        ] = $request;

        if (session()->has('LoggedUser') && session()->has('session_id')) {
            if (session()->has('gamekind') == false && session()->has('lang') == false) {
                $request->session()->put('gamekind', $request->gamekind);
                $request->session()->put('lang', $request->lang);
            }
            $data = [
                'LoggedUserInfo' => UserInfo::where('userNo', session('LoggedUser'))->first(),
                'sessionId' => session('session_id'),
                'gamekind' => session('gamekind'),
                'lang' => session('lang'),
                'DateList' => $this->DateList(),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $type_list->GetGameTypeList([
                    'gamekind' => session('gamekind'),
                    'lang' => session('lang'),
                ]),
            ];
            if (isset($gametype) && !empty($starttime) && !empty($endtime)) {

                $request->validate([
                    'starttime' => 'required|date_format:H:i:s',
                    'endtime' => 'required|date_format:H:i:s|after:starttime',
                ]);

                $recordInfo = WagersRecordInfo::whereBetween($action, [$date . ' ' . $starttime, $date . ' ' . $endtime])
                    ->where('userNo', session('LoggedUser'))->where('GameType', 'like', $gametype)->get();
                $data['RecordInfo'] = $recordInfo;

            }
        }
        return view('WagersRecord/WagersRecord', $data);
    }

    public function WagersRecordDetail(Request $request)
    {
        $record_detail = new RecordDetail;
        $data = [
            'gamekind' => $request->gamekind,
            'lang' => $request->lang,
            'username' => $request->username,
            'wagersid' => $request->wagersid,
            'gametype' => $request->gametype,
        ];

        return $record_detail->GetWagersRecordDetail($data);
    }

}
