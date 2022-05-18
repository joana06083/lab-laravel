<?php

namespace App\ExternalApi\game;

use App\ExternalApi\Kernel;

class typelist extends Kernel
{
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
}
