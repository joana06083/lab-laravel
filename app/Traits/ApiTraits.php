<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
trait ApiTraits
{
    public function Api(String $api_name, array $data)
    {
        $response = Http::get('http://apollo.vir777.net/app/WebService/JSON/display.php/' . $api_name . '?', $data);
        $json_data = json_decode($response->body());
        return $this->Message($api_name, $json_data);
    }

    public function Message($api_name, $json_data)
    {
        if (!isset($json_data->Message)) {
            return match($api_name) {
                'CreateSession' => $json_data->data,
                'CheckUsrBalance' => $json_data->data[0],
                'Transfer' => $json_data->data,

            };

        }

    }
}
