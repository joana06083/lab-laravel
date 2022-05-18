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

    public function CreateSession($request)
    {
        $param = $this->param();
        $username = $request;
        $KeyB = '4GZ2qQ';
        $key = "11" . md5($param['website'] . $username . $KeyB . $param['Date'], false) . "2222222";
        $response = Http::get(
            'http://apollo.vir777.net/app/WebService/JSON/display.php/CreateSession?',
            [
                'website' => $param['website'],
                'username' => $username,
                'uppername' => $param['uppername'],
                'key' => $key,
            ]);
        $json_data = json_decode($response->body());
        $sessionid = $json_data->data->sessionid;
        session()->put('sessionId', $sessionid);
    }

    public function CheckUsrBalance($request)
    {
        $param = $this->param();
        $username = $request;
        $KeyB = 'D5zIM6';
        $key = "1" . md5($param['website'] . $username . $KeyB . $param['Date'], false) . "2222";
        $response = Http::get(
            'http://apollo.vir777.net/app/WebService/JSON/display.php/CheckUsrBalance?',
            [
                'website' => $param['website'],
                'username' => $username,
                'uppername' => $param['uppername'],
                'key' => $key,
            ]);
        $json_data = json_decode($response->body());
        return $json_data->data[0];
    }

    public function Transfer($request)
    {
        $param = $this->param();
        ['account' => $username, 'action' => $action, 'remit' => $remit] = $request;
        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999)); //int(19)( 1~9223372036854775806)來做設定
        $KeyB = 'yb89lxTRVB';
        $key = "11" . md5($param['website'] . $username . $remitno . $KeyB . $param['Date'], false) . "222";
        $response = Http::get(
            'http://apollo.vir777.net/app/WebService/JSON/display.php/Transfer?',
            [
                'website' => $param['website'],
                'username' => $username,
                'uppername' => $param['uppername'],
                'remitno' => $remitno,
                'action' => $action,
                'remit' => $remit,
                'key' => $key,
            ]);
        $json_data = json_decode($response->body());
        return $json_data->data;
    }

    public function GetGameTypeList($request)
    {
        ['lang' => $lang, 'gamekind' => $gamekind] = $request;
        $param = $this->param();
        $KeyB = '601gyM';
        $key = "11111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222";
        $response = Http::get(
            'http://apollo.vir777.net/app/WebService/JSON/display.php/GetGameTypeList?',
            [
                'website' => $param['website'],
                'lang' => $lang,
                'gamekind' => $gamekind,
                'key' => $key,
            ]);
        $json_data = json_decode($response->body());

        if ($json_data->result == false) {
            return $json_data;
        } else {
            return $json_data->data;
        }

    }

    public function GetWagersRecord($request)
    {
        ['gamekind' => $gamekind, 'gametype' => $gametype, 'action' => $action,
            'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $param = $this->param();
        $KeyB = '7uK3nZ6Y9';
        $key = "1111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222222";
        $response = Http::get(
            'http://apollo.vir777.net/app/WebService/JSON/display.php/WagersRecordBy' . $gamekind . '?',
            [
                'website' => $param['website'],
                'action' => $action,
                'uppername' => $param['uppername'],
                'date' => $date,
                'starttime' => $starttime,
                'endtime' => $endtime,
                'gametype' => $gametype,
                'key' => $key,
            ]);
        $json_data = json_decode($response->body());

        return $json_data->data;
    }

    public function GetWagersRecordDetail($request)
    {
        ['gamekind' => $gamekind, 'lang' => $lang, 'username' => $username,
            'wagersid' => $wagersid, 'gametype' => $gametype] = $request;
        $param = $this->param();
        $KeyB = '51Rk82i';
        $key = "111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222222";
        $response = Http::get(
            'http://apollo.vir777.net/app/WebService/JSON/display.php/GetWagersSubDetailUrlBy' . $gamekind . '?',
            [
                'website' => $param['website'],
                'wagersid' => $wagersid,
                'lang' => $lang,
                'username' => $username,
                'gametype' => $gametype,
                'key' => $key,
            ]);
        $json_data = json_decode($response->body());
        foreach ($json_data->data as $arr => $value) {
            return $value;
        }
    }
}
