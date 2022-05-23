<?php

namespace App\ExternalApi\Game;

use App\ExternalApi\Kernel;

class TypeList extends Kernel
{
    public function GetGameTypeList(array $request)
    {
        ['lang' => $lang, 'gamekind' => $gamekind] = $request;
        $param = $this->param();
        $api_name = 'GetGameTypeList';
        $key_b = $this->ApiKeyB($api_name);

        $key_param = [
            'key_a' => 8,
            'key_b' => $key_b,
            'key_c' => 4,
        ];

        $key = $this->key($key_param);

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
