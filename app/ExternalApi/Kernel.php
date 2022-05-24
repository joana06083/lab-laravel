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
    public function ApiKeyB(String $api_name)
    {
        $api_name = preg_replace("/\\d+/", '', $api_name);
        return match($api_name) {
            'CreateSession' => '4GZ2qQ',
            'CheckUsrBalance' => 'D5zIM6',
            'Transfer' => 'yb89lxTRVB',
            'GameUrlBy' => '09fJb0vYem',
            'GetGameTypeList' => '601gyM',
            'WagersRecordBy' => '7uK3nZ6Y9',
            'GetWagersSubDetailUrlBy' => '51Rk82i',
        };
    }
    public function Key(array $key_param)
    {
        $param = $this->param();
        return Str::random($key_param['key_a']) . md5($param['website'] . $key_param['key_b'] . $param['Date'], false) . Str::random($key_param['key_c']);
    }

}
