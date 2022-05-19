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
    public function key($key_a, $key_b, $key_c)
    {
        $key_a = Str::random($key_a);
        $key_c = Str::random($key_c);
        return $key_a . md5($key_b, false) . $key_c;

    }
}
