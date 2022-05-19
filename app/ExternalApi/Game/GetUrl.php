<?php

namespace App\ExternalApi\game;

use App\ExternalApi\Kernel;

class urlby extends Kernel
{
    public function GameUrlBy($request)
    {
        $param = $this->param();
        ['gamekind' => $gamekind, 'lang' => $lang, 'SessionID' => $sessionid, 'GameType' => $gametype] = $request;
        $apiName = 'GameUrlBy' . $gamekind;
        $KeyB = '09fJb0vYem';
        $key = "11111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222";
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
        return $this->Api($apiName, $data);
    }
}
