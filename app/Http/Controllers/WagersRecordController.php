<?php

namespace App\Http\Controllers;

use App\ExternalApi\Game\TypeList;
use App\ExternalApi\User\Balance;
use App\ExternalApi\Wagers\RecordDetail;
use App\Models\UserInfo;
use App\Models\WagersRecordInfo;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;

class WagersRecordController extends Controller
{
    use ApiTraits;
    public function DateList()
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
                'DateList' => $this->DateList(),
                'lang' => $lang,
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

        ['gamekind' => $gamekind, 'lang' => $lang, 'gametype' => $gametype, 'action' => $action,
            'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;

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
                'sessionId' => session('sessionId'),
                'gamekind' => $gamekind,
                'lang' => $lang,
                'GameTypeList' => $type_list->GetGameTypeList($request),
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
        return redirect($record_detail->GetWagersRecordDetail($request));
    }

}
