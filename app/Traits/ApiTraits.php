<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ApiTraits
{
    public function Api(String $apiName, array $data)
    {
        $response = Http::get('http://apollo.vir777.net/app/WebService/JSON/display.php/' . $apiName . '?', $data);
        $json_data = json_decode($response->body());
        return $json_data;
    }
}
