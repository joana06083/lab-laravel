<?php

namespace App\ExternalApi\User;

use App\Enums\ApiName;
use App\Enums\Key;
use App\Enums\Param;
use App\ExternalApi\Kernel;

class Transfer extends Kernel
{
    public function GetTransfer(array $request)
    {
        ['username' => $username, 'action' => $action, 'remit' => $remit] = $request;
        $api_name = ApiName::TRANSFER->Name();
        $remitno = date('YmdHis', time()) . sprintf("%05d", rand(0, 99999));
        $key = $this->key(['key_a' => 2, 'key_b' => $username . $remitno . Key::TRANSFER->KeyB(), 'key_c' => 3]);

        $data = [
            'website' => Param::WEBSITE->Param(),
            'username' => $username,
            'uppername' => Param::UPPERNAME->Param(),
            'remitno' => $remitno,
            'action' => $action,
            'remit' => $remit,
            'key' => $key,
        ];

        return $this->Api($api_name, $data);
    }
}
