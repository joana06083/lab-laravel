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

        ['gametype' => $gametype, 'action' => $action, 'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;

        // $request->validate([
        //     'starttime' => 'required|date_format:H:i:s',
        //     'endtime' => 'required|date_format:H:i:s|after:starttime',
        // ]);

        if (session()->has('LoggedUser') && session()->has('session_id')) {
            $request_data = [
                'gamekind' => $request->gamekind,
                'lang' => $request->lang,
            ];
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();

            if ($gametype == 'all') {
                $recordInfo = WagersRecordInfo::whereBetween('WagersDate', [$date . ' ' . $starttime, $date . ' ' . $endtime])
                    ->get();
            } elseif ($action == 'BetTime') {
                $recordInfo = WagersRecordInfo::whereBetween('WagersDate', [$date . ' ' . $starttime, $date . ' ' . $endtime])
                    ->where('GameType', $gametype)->get();
            } else {
                $recordInfo = WagersRecordInfo::whereBetween('ModifiedDate', [$date . ' ' . $starttime, $date . ' ' . $endtime])
                    ->where('GameType', $gametype)->get();
            }

            $data = [
                'LoggedUserInfo' => $user,
                'sessionId' => session('session_id'),
                'gamekind' => $request_data['gamekind'],
                'lang' => $request_data['lang'],
                'DateList' => $this->DateList(),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $type_list->GetGameTypeList($request_data),
                'RecordInfo' => $recordInfo,
            ];
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
