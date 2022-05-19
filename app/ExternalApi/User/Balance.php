<?php

namespace App\ExternalApi\user;

use App\ExternalApi\Kernel;

class Balance extends Kernel
{
    public function CheckUsrBalance($request)
    {
        $param = $this->param();
        $KeyB = 'D5zIM6';
        $key = $this->key(1, $param['website'] . $request . $KeyB . $param['Date'], 4);

        $api_name = 'CheckUsrBalance';
        $data = [
            'website' => $param['website'],
            'username' => $request,
            'uppername' => $param['uppername'],
            'key' => $key,
        ];

        return $this->Api($api_name, $data)->data[0];
    }
}
