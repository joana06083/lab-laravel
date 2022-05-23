<?php

namespace App\ExternalApi\User;

use App\ExternalApi\Kernel;

class Session extends Kernel
{
    public function CreateSession(String $request)
    {
        $param = $this->param();
        $key_b = '4GZ2qQ';
        $api_name = 'CreateSession';

        $key_param = [
            'key_a' => 2,
            'key_b' => $request . $key_b,
            'key_c' => 7,
        ];

        $key = $this->key($key_param);

        $data = [
            'website' => $param['website'],
            'username' => $request,
            'uppername' => $param['uppername'],
            'key' => $key,
        ];

        $sessionid = $this->Api($api_name, $data)->data->sessionid;

        session()->put('sessionId', $sessionid);
    }
}
