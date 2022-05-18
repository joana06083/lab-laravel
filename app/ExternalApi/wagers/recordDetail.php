<?php

namespace App\ExternalApi\wagers;

use App\ExternalApi\Kernel;

class recordDetail extends Kernel
{
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
