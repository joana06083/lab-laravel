<?php

namespace App\ExternalApi\Wagers;

use App\ExternalApi\Kernel;

class RecordDetail extends Kernel
{
    public function GetWagersRecordDetail($request)
    {
        $param = $this->param();
        ['gamekind' => $gamekind, 'lang' => $lang, 'username' => $username, 'wagersid' => $wagersid, 'gametype' => $gametype] = $request;
        $key_b = '51Rk82i';
        $key = $this->key(6, $param['website'] . $key_b . $param['Date'], 7);

        $api_name = 'GetWagersSubDetailUrlBy' . $gamekind;
        $data = [
            'website' => $param['website'],
            'wagersid' => $wagersid,
            'lang' => $lang,
            'username' => $username,
            'gametype' => $gametype,
            'key' => $key,
        ];

        foreach ($this->Api($api_name, $data)->data as $arr => $value) {
            return $value;
        }
    }
}
