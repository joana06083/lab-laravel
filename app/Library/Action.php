<?php
namespace App\Library;

interface Action
{
    public function Key(array $key_param);
    public function Api(String $api_name, array $data);
    public function Message(String $api_name, object $json_data);
    public function Error(object $json_data);
}
