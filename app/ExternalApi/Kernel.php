<?php

namespace App\ExternalApi;

use App\Traits\ApiTraits;
use Illuminate\Support\Str;

class Kernel
{
    use ApiTraits;
    public function param()
    {
        date_default_timezone_set("America/New_York");

        $data = [
            'website' => 'bbinbgp',
            'uppername' => 'dpidtest',
            'Date' => date("Ymd"),
        ];
        return $data;
    }
    public function key(int $key_a, string $key_b, int $key_c)
    {
        // $key_b
        // $website . $username . $key_b . $date //Session,Balance
        // $website . $username . $remitno . $key_b . $date //Transfer
        // $website . $key_b . $date //other
        return Str::random($key_a) . md5($key_b, false) . Str::random($key_c);

    }
}
