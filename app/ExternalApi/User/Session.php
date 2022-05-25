<?php

namespace App\ExternalApi\User;

use App\Enums\ApiName;
use App\Enums\Key;
use App\ExternalApi\Kernel;

class Session extends Kernel
{
    public function CreateSession(String $request)
    {
        $api_name = ApiName::SESSION->Name();
        $key = $this->Key(['key_a' => 2, 'key_b' => $request . Key::SESSION->KeyB(), 'key_c' => 7]);

        $data = [
            'website' => Kernel::$website,
            'username' => $request,
            'uppername' => Kernel::$upper_name,
            'key' => $key,
        ];

        return $this->Api($api_name, $data);

    }
}
