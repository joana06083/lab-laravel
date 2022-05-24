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

    public function WagersRecordIndex(Request $request)
    {
        $balance = new Balance;
        $type_list = new TypeList;
        $request_data = [
            'gamekind' => $request->gamekind,
            'lang' => $request->lang,
        ];
        $data = [
            'LoggedUserInfo' => [],
            'DateList' => [],
        ];
        if (session()->has('LoggedUser')) {
            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            $data = [
                'LoggedUserInfo' => $user,
                'sessionId' => session('session_id'),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
                'GameTypeList' => $type_list->GetGameTypeList($request_data),
                'gamekind' => $request_data['gamekind'],
                'DateList' => $this->DateList(),
                'lang' => $request_data['lang'],
            ];
        }
        if (!isset($data['GameTypeList']->result)) {
            return view('WagersRecord/WagersRecord', $data);
        } else {
            return redirect('/')->with('Fail', $data['GameTypeList']->data->Message);
        }
    }
    public function WagersRecord(Request $request)
    {
        $balance = new Balance;
        $type_list = new TypeList;

        $request->validate([
            'starttime' => 'date_format:H:i:s',
            'endtime' => 'date_format:H:i:s|after:starttime',
        ]);

        ['gametype' => $gametype, 'action' => $action, 'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $request_data = [
            'gamekind' => $request->gamekind,
            'lang' => $request->lang,
        ];
        if (session()->has('LoggedUser')) {
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
                'GameTypeList' => $type_list->GetGameTypeList($request_data),
                'UsrBalance' => $balance->CheckUsrBalance(session('LoggedUser')),
                'DateList' => $this->DateList(),
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

        // return redirect($record_detail->GetWagersRecordDetail($data));
    }

}
