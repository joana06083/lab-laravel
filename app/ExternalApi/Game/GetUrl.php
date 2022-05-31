<?php

namespace App\ExternalApi\Game;

use App\Enums\ApiName;
use App\Enums\Key;
use App\ExternalApi\Kernel;

class GetUrl extends Kernel
{
    public function GameUrlBy(array $request)
    {
        ['gamekind' => $gamekind, 'lang' => $lang, 'sessionid' => $sessionid, 'gametype' => $gametype] = $request;
        $api_name = ApiName::GAMEURL->Name() . $gamekind;
        $key = parent::key(['key_a' => 8, 'key_b' => Key::GAMEURL->KeyB(), 'key_c' => 4]);
        $data = [
            'website' => Kernel::$website,
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
