<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ApiTraits
{
    public function param()
    {
        date_default_timezone_set("America/New_York");
        $data = [
            'website' => 'bbinbgp',
            'uppername' => 'dpidtest',
            'Date' => date("Ymd"),
        ];
        return $data;
    }
    public function Api($apiName, $data)
    {
        $response = Http::get('http://apollo.vir777.net/app/WebService/JSON/display.php/' . $apiName . '?', $data);
        $json_data = json_decode($response->body());
        return $json_data;
    }
    //user
    public function CreateSession($request)
    {
        $param = $this->param();
        $username = $request;
        $apiName = 'CreateSession';
        $KeyB = '4GZ2qQ';
        $key = "11" . md5($param['website'] . $username . $KeyB . $param['Date'], false) . "2222222";
        $data = [
            'website' => $param['website'],
            'username' => $username,
            'uppername' => $param['uppername'],
            'key' => $key,
        ];

        $sessionid = $this->Api($apiName, $data)->data->sessionid;
        session()->put('sessionId', $sessionid);
    }

    public function CheckUsrBalance($request)
    {
        $param = $this->param();
        $username = $request;
        $apiName = 'CheckUsrBalance';
        $KeyB = 'D5zIM6';
        $key = "1" . md5($param['website'] . $username . $KeyB . $param['Date'], false) . "2222";
        $data = [
            'website' => $param['website'],
            'username' => $username,
            'uppername' => $param['uppername'],
            'key' => $key,
        ];
        return $this->Api($apiName, $data)->data[0];
    }

    public function Transfer($request)
    {
        $param = $this->param();
        ['account' => $username, 'action' => $action, 'remit' => $remit] = $request;
        $apiName = 'Transfer';
        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999)); //int(19)( 1~9223372036854775806)來做設定
        $KeyB = 'yb89lxTRVB';
        $key = "11" . md5($param['website'] . $username . $remitno . $KeyB . $param['Date'], false) . "222";
        $data = [
            'website' => $param['website'],
            'username' => $username,
            'uppername' => $param['uppername'],
            'remitno' => $remitno,
            'action' => $action,
            'remit' => $remit,
            'key' => $key,
        ];
        return $this->Api($apiName, $data)->data;
    }
    //game
    public function GetGameTypeList($request)
    {
        $param = $this->param();
        ['lang' => $lang, 'gamekind' => $gamekind] = $request;
        $apiName = 'GetGameTypeList';
        $KeyB = '601gyM';
        $key = "11111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222";
        $data = [
            'website' => $param['website'],
            'lang' => $lang,
            'gamekind' => $gamekind,
            'key' => $key,
        ];

        if ($this->Api($apiName, $data)->result == false) {
            return $this->Api($apiName, $data);
        } else {
            return $this->Api($apiName, $data)->data;
        }

    }
    public function GameUrlBy($request)
    {
        $param = $this->param();
        ['gamekind' => $gamekind, 'lang' => $lang, 'SessionID' => $sessionid, 'GameType' => $gametype] = $request;
        $apiName = 'GameUrlBy' . $gamekind;
        $KeyB = '09fJb0vYem';
        $key = "11111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222";
        $data = [
            'website' => $param['website'],
            'lang' => $lang,
            'sessionid' => $sessionid,
            'key' => $key,
        ];

        match($gamekind) {
            '3', '75', '93' => $data,
        default=> $data['gametype'] = $gametype,
        };
        return $this->Api($apiName, $data);
    }
    //wager
    public function GetWagersRecord($request)
    {
        $param = $this->param();
        ['gamekind' => $gamekind, 'gametype' => $gametype, 'action' => $action, 'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $apiName = 'WagersRecordBy' . $gamekind;
        $KeyB = '7uK3nZ6Y9';
        $key = "1111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222222";
        $data = [
            'website' => $param['website'],
            'action' => $action,
            'uppername' => $param['uppername'],
            'date' => $date,
            'starttime' => $starttime,
            'endtime' => $endtime,
            'gametype' => $gametype,
            'key' => $key,
        ];

        match($gametype) {
            '5902' => $data['subgamekind'] = '2',
            '5901', '5904', '5012' => $data['subgamekind'] = '3',
            '5908' => $data['subgamekind'] = '5',
        default=> $data['subgamekind'] = '1',
        };
        return $this->Api($apiName, $data)->data;
    }

    public function GetWagersRecordDetail($request)
    {
        $param = $this->param();
        ['gamekind' => $gamekind, 'lang' => $lang, 'username' => $username, 'wagersid' => $wagersid, 'gametype' => $gametype] = $request;
        $apiName = 'GetWagersSubDetailUrlBy' . $gamekind;
        $KeyB = '51Rk82i';
        $key = "111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222222";
        $data = [
            'website' => $param['website'],
            'wagersid' => $wagersid,
            'lang' => $lang,
            'username' => $username,
            'gametype' => $gametype,
            'key' => $key,
        ];

        foreach ($this->Api($apiName, $data)->data as $arr => $value) {
            return $value;
        }
    }
}
