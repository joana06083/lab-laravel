<?php

namespace App\ExternalApi\Wagers;

use App\ExternalApi\Kernel;

class RecordDetail extends Kernel
{
    public function GetWagersRecordDetail(array $request)
    {
        ['gamekind' => $gamekind, 'lang' => $lang, 'username' => $username, 'wagersid' => $wagersid, 'gametype' => $gametype] = $request;
        $param = $this->param();
        $api_name = 'GetWagersSubDetailUrlBy';
        $key_b = $this->ApiKeyB($api_name);

        $key_param = [
            'key_a' => 6,
            'key_b' => $key_b,
            'key_c' => 7,
        ];

        $key = $this->key($key_param);

        $data = [
            'website' => $param['website'],
            'wagersid' => $wagersid,
            'lang' => $lang,
            'username' => $username,
            'gametype' => $gametype,
            'key' => $key,
        ];

        foreach ($this->Api($api_name . $gamekind, $data)->data as $arr => $value) {
            return $value;
        }
    }
}
