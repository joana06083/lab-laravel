<?php

namespace App\ExternalApi\User;

use App\ExternalApi\Kernel;

class Balance extends Kernel
{
    public function CheckUsrBalance(String $request)
    {
        $param = $this->param();
        $api_name = 'CheckUsrBalance';
        $key_b = $this->ApiKeyB($api_name);

        $key_param = [
            'key_a' => 1,
            'key_b' => $request . $key_b,
            'key_c' => 4,
        ];

        $key = $this->key($key_param);

        $data = [
            'website' => $param['website'],
            'username' => $request,
            'uppername' => $param['uppername'],
            'key' => $key,
        ];

        return $this->Api($api_name, $data);
    }
}
