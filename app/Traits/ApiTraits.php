<?php

namespace App\Traits;

trait ApiTraits
{
    public function CreateSession($account)
    {
        $website = 'bbinbgp';
        $uppername = 'dpidtest';
        $username = $account;
        $KeyB = '4GZ2qQ';
        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $key = "11" . md5($website . $username . $KeyB . $Date, false) . "2222222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CreateSession?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        $sessionid = $json_data['data']['sessionid'];
        session()->put('ApiData', $sessionid);
    }

    public function CheckUsrBalance($account)
    {
        $website = 'bbinbgp';
        $uppername = 'dpidtest';
        $username = $account;
        $KeyB = 'D5zIM6';
        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $key = "1" . md5($website . $username . $KeyB . $Date, false) . "2222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CheckUsrBalance?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        $data = [
            "Currency" => $json_data['data'][0]['Currency'],
            "Balance" => $json_data['data'][0]['Balance'],
            "TotalBalance" => $json_data['data'][0]['TotalBalance'],
        ];
        return $data;
    }

    public function GetGameTypeList($lang, $gamekind)
    {
        $website = 'bbinbgp';
        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $KeyB = '601gyM';
        $key = "11111111" . md5($website . $KeyB . $Date, false) . "2222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GetGameTypeList?website=" .
            $website . "&lang=" . $lang . "&gamekind=" . $gamekind . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        return $json_data['data'];
    }

    public function Transfer($username, $action, $remit)
    {
        $website = 'bbinbgp';
        $uppername = 'dpidtest';
        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999)); //int(19)( 1~9223372036854775806)來做設定
        $KeyB = 'yb89lxTRVB';
        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $key = "11" . md5($website . $username . $remitno . $KeyB . $Date, false) . "222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/Transfer?website=" . $website . "&username=" . $username . "&uppername=" . $uppername . "&remitno=" . $remitno . "&action=" . $action . "&remit=" . $remit . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        return $json_data['data'];
    }

    public function GetWagersRecord($gamekind, $gametype, $date, $action)
    {
        $website = 'bbinbgp';
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

        return $json_data['data'];
    }

    public function GetWagersRecordDetail($gamekind, $lang, $username, $wagersid, $gametype)
    {
        $website = 'bbinbgp';
        $KeyB = '51Rk82i';

        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");

        $key = "111111" . md5($website . $KeyB . $Date, false) . "2222222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GetWagersSubDetailUrlBy" . $gamekind .
            "?website=" . $website . "&wagersid=" . $wagersid . "&lang=" . $lang . "&username=" . $username .
            "&gametype=" . $gametype . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        foreach ($json_data['data'] as $arr => $value) {
            return $value;
        }
    }
}
