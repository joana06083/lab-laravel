<?php

namespace App\ExternalApi\User;

use App\ExternalApi\Kernel;

class Transfer extends Kernel
{

    public function GetTransfer(array $request)
    {
        ['username' => $username, 'action' => $action, 'remit' => $remit] = $request;
        $param = $this->param();
        $key_b = 'yb89lxTRVB';
        $api_name = 'Transfer';
        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999));

        $key_param = [
            'key_a' => 2,
            'key_b' => $username . $remitno . $key_b,
            'key_c' => 3,
        ];

        $key = $this->key($key_param);

        $data = [
            'website' => $param['website'],
            'username' => $username,
            'uppername' => $param['uppername'],
            'remitno' => $remitno,
            'action' => $action,
            'remit' => $remit,
            'key' => $key,
        ];

        return $this->Api($api_name, $data)->data;
    }
}
