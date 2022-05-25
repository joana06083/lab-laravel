<?php

namespace App\ExternalApi;

use App\Enums\ApiName;
use App\Enums\Param;
use App\Exceptions\ApiException;
use App\Library\Action;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Kernel implements Action
{

    public function Key(array $key_param)
    {
        return Str::random($key_param['key_a']) . md5(Param::WEBSITE->Param() . $key_param['key_b'] . Param::DATE->Param(), false) . Str::random($key_param['key_c']);
    }

    public function Api(String $api_name, array $data)
    {
        $response = Http::get('http://apollo.vir777.net/app/WebService/JSON/display.php/' . $api_name . '?', $data);
        $json_data = json_decode($response->body());
        $api_name = preg_replace("/\\d+/", '', $api_name);

        if (!isset($json_data->data->Message) || $json_data->data->Code == 11100) {
            if ($api_name == ApiName::TRANSFER->Name()) {
                return 'Transfer successfully!';
            }
            return $this->Message($api_name, $json_data);
        } else {
            return match($api_name) {
                ApiName::RECORD->Name() => $json_data->data,
                ApiName::BALANCE->Name() => [],
            default=> $this->Error($json_data),
            };
        }
    }

    public function Message($api_name, $json_data)
    {
        return match($api_name) {
            ApiName::SESSION->Name() => $json_data->data->sessionid,
            ApiName::BALANCE->Name() => $json_data->data[0],
            ApiName::GAMEURL->Name() => $json_data,
            ApiName::RECORDDETAIL->Name() => redirect($json_data->data->Url),
        default=> $json_data->data,
        };
    }

    public function Error($json_data)
    {
        $data = $json_data->data->Code . '-' . $json_data->data->Message;
        throw new ApiException('Api Error:' . $data);
    }
}
