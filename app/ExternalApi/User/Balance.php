<?php

namespace App\ExternalApi\User;

use App\Enums\ApiName;
use App\Enums\Key;
use App\ExternalApi\Kernel;

class Balance extends Kernel
{
    public function CheckUsrBalance(String $request)
    {
        $api_name = ApiName::BALANCE->Name();
        $key = parent::key(['key_a' => 1, 'key_b' => $request . Key::BALANCE->KeyB(), 'key_c' => 4]);

        $data = [
            'website' => Kernel::$website,
            'username' => $request,
            'uppername' => Kernel::$upper_name,
            'key' => $key,
        ];

        return $this->Api($api_name, $data);
    }
}
