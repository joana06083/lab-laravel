<?php

namespace App\ExternalApi\user;

use App\ExternalApi\Kernel;

class Session extends Kernel
{
    public function CreateSession($request)
    {
        $param = $this->param();
        $key_b = '4GZ2qQ';
        $key = $this->key(2, $param['website'] . $request . $key_b . $param['Date'], 7);

        $api_name = 'CreateSession';
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
