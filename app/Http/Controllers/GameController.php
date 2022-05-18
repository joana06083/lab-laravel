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

        if ($gamekind == 3 || $gamekind == 75 || $gamekind == 93) {
            $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GameUrlBy" . $gamekind .
                "?website=" . $param['website'] . "&lang=" . $lang . "&sessionid=" . $sessionid . "&key=" . $key;
        } else {
            $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GameUrlBy" . $gamekind .
                "?website=" . $param['website'] . "&lang=" . $lang . "&sessionid=" . $sessionid . "&gametype=" . $gametype . "&key=" . $key;
        }

        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        if (isset($json_data['data']['Message'])) {
            return redirect('/')->with('Fail', $json_data['data']['Message']);
        }
        return match($gamekind) {
            '5', '30', '38' => redirect($json_data['data'][0]['html5']),
        default=> redirect($json_data['data'][0]['pc']),
        };
    }

}
