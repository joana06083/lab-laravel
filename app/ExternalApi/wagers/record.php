<?php

namespace App\ExternalApi\wagers;

use App\ExternalApi\Kernel;

class record extends Kernel
{
    public function GetWagersRecord($request)
    {
        $param = $this->param();
        ['gamekind' => $gamekind, 'gametype' => $gametype, 'action' => $action, 'date' => $date, 'starttime' => $starttime, 'endtime' => $endtime] = $request;
        $apiName = 'WagersRecordBy' . $gamekind;
        $KeyB = '7uK3nZ6Y9';
        $key = "1111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222222";
        $data = [
            'website' => $param['website'],
            'action' => $action,
            'uppername' => $param['uppername'],
            'date' => $date,
            'starttime' => $starttime,
            'endtime' => $endtime,
            'gametype' => $gametype,
            'key' => $key,
        ];

        match($gametype) {
            '5902' => $data['subgamekind'] = '2',
            '5901', '5904', '5012' => $data['subgamekind'] = '3',
            '5908' => $data['subgamekind'] = '5',
        default=> $data['subgamekind'] = '1',
        };
        return $this->Api($apiName, $data)->data;
    }

}
