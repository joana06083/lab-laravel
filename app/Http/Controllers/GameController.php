<?php

namespace App\Http\Controllers;

use App\Traits\ApiTraits;
use Illuminate\Http\Request;

class GameController extends Controller
{
    use ApiTraits;

    //進入遊戲
    public function GameIndex(Request $request)
    {
        ['gamekind' => $gamekind, 'lang' => $lang, 'SessionID' => $sessionid, 'GameType' => $gametype] = $request;
        $param = $this->param();
        $KeyB = '09fJb0vYem';
        $key = "11111111" . md5($param['website'] . $KeyB . $param['Date'], false) . "2222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GameUrlBy" . $gamekind .
            "?website=" . $param['website'] . "&lang=" . $lang . "&sessionid=" . $sessionid . "&gametype=" . $gametype . "&key=" . $key;
        $newUrl = "http://apollo.vir777.net/app/WebService/JSON/display.php/GameUrlBy" . $gamekind .
            "?website=" . $param['website'] . "&lang=" . $lang . "&sessionid=" . $sessionid . "&key=" . $key;

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        $newjson = file_get_contents($newUrl);
        $newjson_data = json_decode($newjson, true);

        if ($gamekind == 3 || $gamekind == 75 || $gamekind == 93) {
            if (isset($newjson_data['data']['Message'])) {
                return redirect('/')->with('Fail', $newjson_data['data']['Message']);
            } else {
                return redirect($newjson_data['data'][0]['pc']);
            }
        } else {
            if (isset($json_data['data']['Message'])) {
                return redirect('/')->with('Fail', $json_data['data']['Message']);
            } else {
                if ($gamekind == 5 || $gamekind == 30 || $gamekind == 38) {
                    return redirect($json_data['data'][0]['html5']);
                } elseif ($gamekind == 12 || $gamekind == 31 || $gamekind == 66 || $gamekind == 73 || $gamekind == 76 || $gamekind == 107 || $gamekind == 109) {
                    return redirect($json_data['data'][0]['pc']);
                }
            }
        }
    }

}
