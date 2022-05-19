<?php

namespace App\ExternalApi\user;

use App\ExternalApi\Kernel;

class transfer extends Kernel
{

    public function Transfer($request)
    {
        $param = $this->param();
        ['account' => $username, 'action' => $action, 'remit' => $remit] = $request;
        $apiName = 'Transfer';
        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999)); //int(19)( 1~9223372036854775806)來做設定
        $KeyB = 'yb89lxTRVB';
        $key = "11" . md5($param['website'] . $username . $remitno . $KeyB . $param['Date'], false) . "222";
        $data = [
            'website' => $param['website'],
            'username' => $username,
            'uppername' => $param['uppername'],
            'remitno' => $remitno,
            'action' => $action,
            'remit' => $remit,
            'key' => $key,
        ];
        return $this->Api($apiName, $data)->data;
    }
}
