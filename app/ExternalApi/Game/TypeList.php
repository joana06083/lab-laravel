<?php

namespace App\ExternalApi\Game;

use App\Enums\ApiName;
use App\Enums\Key;
use App\ExternalApi\Kernel;

class TypeList extends Kernel
{
    public function GetGameTypeList(array $request)
    {
        ['lang' => $lang, 'gamekind' => $gamekind] = $request;
        $api_name = ApiName::GAMETYPE->Name();
        $key = parent::key(['key_a' => 8, 'key_b' => Key::GAMETYPE->KeyB(), 'key_c' => 4]);

        $data = [
            'website' => Kernel::$website,
            'lang' => $lang,
            'gamekind' => $gamekind,
            'key' => $key,
        ];

        return $this->Api($api_name, $data);

    }
}
