<?php

namespace App\Traits;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;
trait ApiTraits
{

    public function Api(String $api_name, array $data)
    {
        $response = Http::get('http://apollo.vir777.net/app/WebService/JSON/display.php/' . $api_name . '?', $data);
        $json_data = json_decode($response->body());
        $api_name = preg_replace("/\\d+/", '', $api_name);

        if (!isset($json_data->data->Message) || $json_data->data->Code == 11100) {
            if ($api_name == 'Transfer') {
                return 'Transfer successfully!';
            }
            return $this->Message($api_name, $json_data);
        } else {
            return match($api_name) {
                'WagersRecordBy' => $json_data->data,
                'CheckUsrBalance' => [],
            default=> $this->Error($json_data),
            };
        }
    }
    public function Message($api_name, $json_data)
    {
        return match($api_name) {
            'CreateSession' => $json_data->data->sessionid,
            'CheckUsrBalance' => $json_data->data[0],
            'GameUrlBy' => $json_data,
            'GetWagersSubDetailUrlBy' => redirect($json_data->data->Url),
        default=> $json_data->data,
        };
    }
    public function Error($json_data)
    {
        $data = $json_data->data->Code . '-' . $json_data->data->Message;
        throw new ApiException('Api Error:' . $data);
    }
}
