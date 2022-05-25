<?php

namespace App\ExternalApi\Wagers;

use App\Enums\ApiName;
use App\Enums\Key;
use App\Enums\Param;
use App\ExternalApi\Kernel;

class RecordDetail extends Kernel
{
    public function GetWagersRecordDetail(array $request)
    {
        ['gamekind' => $gamekind, 'lang' => $lang, 'username' => $username, 'wagersid' => $wagersid, 'gametype' => $gametype] = $request;
        $api_name = ApiName::RECORDDETAIL->Name() . $gamekind;
        $key = $this->key(['key_a' => 6, 'key_b' => Key::RECORDDETAIL->KeyB(), 'key_c' => 7]);

        $data = [
            'website' => Param::WEBSITE->Param(),
            'wagersid' => $wagersid,
            'lang' => $lang,
            'username' => $username,
            'gametype' => $gametype,
            'key' => $key,
        ];

        return $this->Api($api_name, $data);
    }
}
