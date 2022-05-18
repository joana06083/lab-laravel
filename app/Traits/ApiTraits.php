<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ApiTraits
{
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
    public function Api($apiName, $data)
    {
        $response = Http::get('http://apollo.vir777.net/app/WebService/JSON/display.php/' . $apiName . '?', $data);
        $json_data = json_decode($response->body());
        return $json_data;
    }

}
