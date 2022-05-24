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
        switch ($api_name) {
            case 'CreateSession':
                $key_b = '4GZ2qQ';
                return $key_b;
                break;
            case 'CheckUsrBalance':
                $key_b = 'D5zIM6';
                return $key_b;
                break;
            case 'Transfer':
                $key_b = 'yb89lxTRVB';
                return $key_b;
                break;
            case 'GameUrlBy':
                $key_b = '09fJb0vYem';
                return $key_b;
                break;
            case 'GetGameTypeList':
                $key_b = '601gyM';
                return $key_b;
                break;
            case 'WagersRecordBy':
                $key_b = '7uK3nZ6Y9';
                return $key_b;
                break;
            case 'GetWagersSubDetailUrlBy':
                $key_b = '51Rk82i';
                return $key_b;
                break;
        }
    }
    public function Key(array $key_param)
    {
        $param = $this->param();
        return Str::random($key_param['key_a']) . md5($param['website'] . $key_param['key_b'] . $param['Date'], false) . Str::random($key_param['key_c']);
    }

}
