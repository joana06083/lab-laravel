<?php

namespace App\ExternalApi\Game;

use App\ExternalApi\Kernel;

class TypeList extends Kernel
{
    public function GetGameTypeList($request)
    {
        $param = $this->param();
        ['lang' => $lang, 'gamekind' => $gamekind] = $request;
        $key_b = '601gyM';
        $key = $this->key(8, $param['website'] . $key_b . $param['Date'], 4);

        $api_name = 'GetGameTypeList';
        $data = [
            'website' => $param['website'],
            'lang' => $lang,
            'gamekind' => $gamekind,
            'key' => $key,
        ];

        if ($this->Api($api_name, $data)->result == false) {
            return $this->Api($api_name, $data);
        } else {
            return $this->Api($api_name, $data)->data;
        }

    }
}
