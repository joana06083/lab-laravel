<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
trait ApiTraits
{
    public function Api(String $api_name, array $data)
    {
        $response = Http::get('http://apollo.vir777.net/app/WebService/JSON/display.php/' . $api_name . '?', $data);
        $json_data = json_decode($response->body());

        if (!isset($json_data->data->Message)) {
            return $this->Message($api_name, $json_data);
        } else {
            return $this->Error($api_name, $json_data);
        }
    }
    public function Message($api_name, $json_data)
    {
        $api_name = preg_replace("/\\d+/", '', $api_name);

        return match($api_name) {
            'CreateSession' => $json_data->data->sessionid,
            'CheckUsrBalance' => $json_data->data[0],
            'GameUrlBy', 'GetGameTypeList' => $json_data,
            'GetWagersSubDetailUrlBy' => $json_data->data->Url,
        default=> $json_data->data,
        };
    }
    public function Error($api_name, $json_data)
    {
        $api_name = preg_replace("/\\d+/", '', $api_name);
        return $json_data->data;
    }
}
