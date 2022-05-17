<?php

namespace App\Traits;

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
    public function CreateSession($account)
    {
        $param = $this->param();
        $username = $account;
        $KeyB = '4GZ2qQ';
        $key = "11" . md5($param['website'] . $username . $KeyB . $param['Date'], false) . "2222222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CreateSession?website="
            . $param['website'] . "&username=" . $username . "&uppername=" . $param['uppername'] . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        $sessionid = $json_data['data']['sessionid'];
        session()->put('ApiData', $sessionid);
    }

    public function CheckUsrBalance($account)
    {
        $param = $this->param();
        $username = $account;
        $KeyB = 'D5zIM6';
        $key = "1" . md5($param['website'] . $username . $KeyB . $param['Date'], false) . "2222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/CheckUsrBalance?website=" .
            $param['website'] . "&username=" . $username . "&uppername=" . $param['uppername'] . "&key=" . $key;

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
        $param = $this->param();
        $KeyB = '601gyM';
        $key = "11111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GetGameTypeList?website=" .
            $param['website'] . "&lang=" . $lang . "&gamekind=" . $gamekind . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        if ($json_data['result'] == false) {
            return $json_data;
        } else {
            return $json_data['data'];
        }

    }

    public function Transfer($username, $action, $remit)
    {
        $param = $this->param();
        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999)); //int(19)( 1~9223372036854775806)來做設定
        $KeyB = 'yb89lxTRVB';
        $key = "11" . md5($param['website'] . $username . $remitno . $KeyB . $param['Date'], false) . "222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/Transfer?website=" . $param['website'] . "&username=" . $username . "&uppername=" . $param['uppername'] . "&remitno=" . $remitno . "&action=" . $action . "&remit=" . $remit . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        return $json_data['data'];
    }

    public function GetWagersRecord($gamekind, $gametype, $date, $action)
    {
        $param = $this->param();
        $KeyB = '7uK3nZ6Y9';
        $key = "1111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/WagersRecordBy" . $gamekind .
            "?website=" . $param['website'] . "&action=" . $action . "&uppername=dpidtest" .
            "&date=" . $date . "&starttime=00:00:00&endtime=23:59:59" . "&gametype=" . $gametype . "&key=" . $key;
        //Response
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        return $url;
        return $json_data['data'];
    }

    public function GetWagersRecordDetail($gamekind, $lang, $username, $wagersid, $gametype)
    {
        $param = $this->param();
        $KeyB = '51Rk82i';
        $key = "111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GetWagersSubDetailUrlBy" . $gamekind .
            "?website=" . $param['website'] . "&wagersid=" . $wagersid . "&lang=" . $lang . "&username=" . $username .
            "&gametype=" . $gametype . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        foreach ($json_data['data'] as $arr => $value) {
            return $value;
        }
    }
}
