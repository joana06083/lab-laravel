<?php

namespace App\ExternalApi\Game;

use App\ExternalApi\Kernel;

class GetUrl extends Kernel
{
    public function GameUrlBy($request)
    {
        $param = $this->param();
        ['gamekind' => $gamekind, 'lang' => $lang, 'SessionID' => $sessionid, 'GameType' => $gametype] = $request;
        $key_b = '09fJb0vYem';
        $key = $this->key(8, $param['website'] . $key_b . $param['Date'], 4);

        $api_name = 'GameUrlBy' . $gamekind;
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
        return $this->Api($api_name, $data);
    }
}
