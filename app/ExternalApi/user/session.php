<?php

namespace App\ExternalApi\user;

use App\ExternalApi\Kernel;

class session extends Kernel
{
    public function CreateSession($request)
    {
        $param = $this->param();
        $username = $request;
        $apiName = 'CreateSession';
        $KeyB = '4GZ2qQ';
        $key = "11" . md5($param['website'] . $username . $KeyB . $param['Date'], false) . "2222222";
        $data = [
            'website' => $param['website'],
            'username' => $username,
            'uppername' => $param['uppername'],
            'key' => $key,
        ];

        $sessionid = $this->Api($apiName, $data)->data->sessionid;
        session()->put('sessionId', $sessionid);
    }
}
