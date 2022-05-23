<?php

namespace App\ExternalApi\Wagers;

use App\ExternalApi\Kernel;

class Record extends Kernel
{
    public function GetWagersRecord(array $request)
    {
        ['gamekind' => $gamekind, 'gametype' => $gametype, 'action' => $action, 'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $param = $this->param();
        $api_name = 'WagersRecordBy';
        $key_b = $this->ApiKeyB($api_name);

        $key_param = [
            'key_a' => 7,
            'key_b' => $key_b,
            'key_c' => 7,
        ];

        $key = $this->key($key_param);

        $data = [
            'website' => $param['website'],
            'action' => $action,
            'uppername' => $param['uppername'],
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
        return $this->Api($api_name . $gamekind, $data)->data;
    }

}
