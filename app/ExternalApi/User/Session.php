<?php

namespace App\ExternalApi\User;

use App\ExternalApi\Kernel;

class Session extends Kernel
{
    public function CreateSession(String $request)
    {
        $param = $this->param();
        $api_name = 'CreateSession';
        $key_b = $this->ApiKeyB($api_name);

        $key_param = [
            'key_a' => 2,
            'key_b' => $request . $key_b,
            'key_c' => 7,
        ];

        $key = $this->Key($key_param);

        $data = [
            'website' => $param['website'],
            'username' => $request,
            'uppername' => $param['uppername'],
            'key' => $key,
        ];

        $result = $this->Api($api_name, $data)->data;
        if (isset($result->Message)) {
            $result_data = [
                'code' => $result->Code, 'message' => $result->Message,
            ];
            return $result_data;
        } else {
            $session_id = $this->Api($api_name, $data)->data->sessionid;
            session()->put('session_id', $session_id);
        }

    }
}
