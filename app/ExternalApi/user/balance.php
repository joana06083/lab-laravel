<?php

namespace App\ExternalApi\user;

use App\ExternalApi\Kernel;

class balance extends Kernel
{
    public function CheckUsrBalance($request)
    {
        $param = $this->param();
        $username = $request;
        $apiName = 'CheckUsrBalance';
        $KeyB = 'D5zIM6';
        $key = "1" . md5($param['website'] . $username . $KeyB . $param['Date'], false) . "2222";
        $data = [
            'website' => $param['website'],
            'username' => $username,
            'uppername' => $param['uppername'],
            'key' => $key,
        ];
        return $this->Api($apiName, $data)->data[0];
    }
}
