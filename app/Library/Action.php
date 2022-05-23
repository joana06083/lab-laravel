<?php
namespace App\Library;

interface Action
{
    public function Param();
    public function Key(array $key_param);
    public function ApiKeyB(String $api_name);

}
