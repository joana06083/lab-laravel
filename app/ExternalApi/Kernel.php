<?php

namespace App\ExternalApi;

use App\Library\Action;
use App\Traits\ApiTraits;
use Illuminate\Support\Str;

class Kernel implements Action
{
    use ApiTraits;

    public function Param()
    {
        date_default_timezone_set("America/New_York");

        $data = [
            'website' => 'bbinbgp',
            'uppername' => 'dpidtest',
            'Date' => date("Ymd"),
        ];
        return $data;
    }
    public function Key(array $key_param)
    {
        // $website . $username . $key_b . $date //Session,Balance
        // $website . $username . $remitno . $key_b . $date //Transfer
        // $website . $key_b . $date //other
        $param = $this->param();
        return Str::random($key_param['key_a']) . md5($param['website'] . $key_param['key_b'] . $param['Date'], false) . Str::random($key_param['key_c']);

    }
}
