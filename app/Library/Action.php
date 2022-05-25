<?php
namespace App\Library;

interface Action
{
    public function Key(array $key_param);
    public function Api(String $api_name, array $data);
    public function Message($api_name, $json_data);
    public function Error($json_data);
}
