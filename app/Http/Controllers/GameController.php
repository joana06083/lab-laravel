<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Models\wagersRecordInfo;
use Illuminate\Http\Request;

class GameController extends Controller
{
    //進入遊戲
    public function GameIndex(Request $request)
    {
        //call CreateSession api
        $website = 'bbinbgp';

        ['gamekind' => $gamekind, 'lang' => $lang, 'SessionID' => $sessionid, 'GameType' => $gametype] = $request;

        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $KeyB = '09fJb0vYem';
        $key = "11111111" . md5($website . $KeyB . $Date, false) . "2222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GameUrlBy" . $gamekind . "?website=" . $website . "&lang=" . $lang .
            "&sessionid=" . $sessionid . "&gametype=" . $gametype . "&key=" . $key;
        //Response
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        if (empty($gamekind) == true or empty($lang) == true or empty($sessionid) == true or empty($gametype) == true) {
            return redirect('/')->with('Fail', 'Parameter is missing!');
        } else {
            return redirect($json_data['data'][0]['html5']);
        }

    }
    public function WagersRecordIndex(Request $request)
    {
        ['gamekind' => $gamekind] = $request;

        $data = [
            'LoggedUserInfo' => [],
            'GameTypeList' => [],
            'DateList' => [],
        ];
        if (session()->has('LoggedUser')) {

            $user = UserInfo::where('userNo', session('LoggedUser'))->first();
            //call CheckUsrBalance api
            $website = 'bbinbgp';
            $uppername = 'dpidtest';
            $username = session('LoggedUser');
            $KeyB = 'D5zIM6';
            date_default_timezone_set("America/New_York");
            $Date = date("Ymd");
            $key = "1" . md5($website . $username . $KeyB . $Date, false) . "2222";
            $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CheckUsrBalance?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&key=" . $key;

            // CheckUsrBalance Response
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);

            //call GetGameTypeList api
            $game_KeyB = '601gyM';
            $lang = $request->lang;
            $gamekind = $request->gamekind;
            $game_key = "11111111" . md5($website . $game_KeyB . $Date, false) . "2222";
            $game_url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GetGameTypeList?website=" .
                $website . "&lang=" . $lang . "&gamekind=" . $gamekind . "&key=" . $game_key;

            // GetGameTypeList Response
            $game_json = file_get_contents($game_url);
            $game_json_data = json_decode($game_json, true);

            //date
            $datelist = [];
            for ($i = 0; $i <= 6; $i++) {
                array_push($datelist, date('Y-m-d', strtotime("-{$i} day")));
            }

            $data = [
                'LoggedUserInfo' => $user,
                'ApiData' => session('ApiData'),
                'UsrBalance' => [
                    "Currency" => $json_data['data'][0]['Currency'], //幣別
                    "Balance" => $json_data['data'][0]['Balance'], //額度
                    "TotalBalance" => $json_data['data'][0]['TotalBalance'], //總額度
                ],
                'GameTypeList' => $game_json_data['data'],
                'gamekind' => $gamekind,
                'DateList' => $datelist,
            ];
        }
        return view('wagersRecord/wagersRecord', $data);
    }
    public function WagersRecord(Request $request)
    {
        $website = 'bbinbgp';
        ['gamekind' => $gamekind, 'gametype' => $gametype, 'date' => $date, 'action' => $action] = $request;

        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $KeyB = '7uK3nZ6Y9';
        $key = "1111111" . md5($website . $KeyB . $Date, false) . "2222222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/WagersRecordBy" . $gamekind .
            "?website=" . $website . "&action=" . $action . "&uppername=dpidtest" .
            "&date=" . $date . "&starttime=00:00:00&endtime=23:59:59" .
            "&gametype=" . $gametype . "&key=" . $key;
        //Response
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        $recordData = [];

        foreach ($json_data['data'] as $key => $value) {
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
            //call CheckUsrBalance api
            $website = 'bbinbgp';
            $uppername = 'dpidtest';
            $username = session('LoggedUser');
            $KeyB = 'D5zIM6';
            date_default_timezone_set("America/New_York");
            $Date = date("Ymd");
            $key = "1" . md5($website . $username . $KeyB . $Date, false) . "2222";
            $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CheckUsrBalance?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&key=" . $key;

            // CheckUsrBalance Response
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);

            //call GetGameTypeList api
            $game_KeyB = '601gyM';
            $lang = $request->lang;
            $gamekind = $request->gamekind;
            $game_key = "11111111" . md5($website . $game_KeyB . $Date, false) . "2222";
            $game_url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GetGameTypeList?website=" .
                $website . "&lang=" . $lang . "&gamekind=" . $gamekind . "&key=" . $game_key;

            // GetGameTypeList Response
            $game_json = file_get_contents($game_url);
            $game_json_data = json_decode($game_json, true);

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
                'UsrBalance' => [
                    "Currency" => $json_data['data'][0]['Currency'], //幣別
                    "Balance" => $json_data['data'][0]['Balance'], //額度
                    "TotalBalance" => $json_data['data'][0]['TotalBalance'], //總額度
                ],
                'GameTypeList' => $game_json_data['data'],
                'gamekind' => $gamekind,
                'DateList' => $datelist,
                'RecordInfo' => $recordInfo,
            ];
        }
        return view('wagersRecord/wagersRecord', $data);

    }
}
