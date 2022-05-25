<?php

namespace App\ExternalApi\Wagers;

use App\Enums\ApiName;
use App\Enums\Key;
use App\ExternalApi\Kernel;

class Record extends Kernel
{
    public function GetWagersRecord(array $request)
    {
        ['gamekind' => $gamekind, 'gametype' => $gametype, 'action' => $action, 'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $api_name = ApiName::RECORD->Name() . $gamekind;
        $key = $this->key(['key_a' => 7, 'key_b' => Key::RECORD->KeyB(), 'key_c' => 7]);

        $data = [
            'website' => Kernel::$website,
            'action' => $action,
            'uppername' => Kernel::$upper_name,
            'date' => $date,
            'gametype' => $gametype,
            'starttime' => $starttime,
            'endtime' => $endtime,
            'key' => $key,
        ];

        match($gametype) {
            '5902' => $data['subgamekind'] = '2',
            '5901', '5904', '5012' => $data['subgamekind'] = '3',
            '5908' => $data['subgamekind'] = '5',
        default=> $data['subgamekind'] = '1',
        };

        return $this->Api($api_name, $data);
    }

}
