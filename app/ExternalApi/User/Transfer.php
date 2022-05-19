<?php

namespace App\ExternalApi\user;

use App\ExternalApi\Kernel;

class Transfer extends Kernel
{

    public function GetTransfer($request)
    {
        $param = $this->param();
        $key_b = 'yb89lxTRVB';
        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999));
        ['account' => $username, 'action' => $action, 'remit' => $remit] = $request;
        $key = $this->key(2, $param['website'] . $username . $remitno . $key_b . $param['Date'], 3);

        $api_name = 'Transfer';
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
