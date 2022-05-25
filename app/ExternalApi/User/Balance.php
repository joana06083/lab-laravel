<?php

namespace App\ExternalApi\User;

use App\Enums\ApiName;
use App\Enums\Key;
use App\Enums\Param;
use App\ExternalApi\Kernel;

class Balance extends Kernel
{
    public function CheckUsrBalance(String $request)
    {
        $api_name = ApiName::BALANCE->Name();
        $key = $this->key(['key_a' => 1, 'key_b' => $request . Key::BALANCE->KeyB(), 'key_c' => 4]);

        $data = [
            'website' => Param::WEBSITE->Param(),
            'username' => $request,
            'uppername' => Param::UPPERNAME->Param(),
            'key' => $key,
        ];

        return $this->Api($api_name, $data);
    }
}
