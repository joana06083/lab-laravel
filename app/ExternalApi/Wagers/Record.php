<?php

namespace App\ExternalApi\Wagers;

use App\ExternalApi\Kernel;

class Record extends Kernel
{
    public function GetWagersRecord($request)
    {
        $param = $this->param();
        ['gamekind' => $gamekind, 'gametype' => $gametype, 'action' => $action, 'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $key_b = '7uK3nZ6Y9';
        $key = $this->key(7, $param['website'] . $key_b . $param['Date'], 7);

        $api_name = 'WagersRecordBy' . $gamekind;
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
        return $this->Api($api_name, $data)->data;
    }

}
