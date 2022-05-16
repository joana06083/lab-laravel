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
        $website = 'bbinbgp';
        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $KeyB = '09fJb0vYem';
        $key = "11111111" . md5($website . $KeyB . $Date, false) . "2222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GameUrlBy" . $gamekind . "?website=" . $website . "&lang=" . $lang .
            "&sessionid=" . $sessionid . "&gametype=" . $gametype . "&key=" . $key;
        //Response
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);

        if ($gamekind == 3 or $gamekind == 75 or $gamekind == 93) {
            $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GameUrlBy" . $gamekind . "?website=" . $website . "&lang=" . $lang .
                "&sessionid=" . $sessionid . "&key=" . $key;
            $json = file_get_contents($url);
            $json_data = json_decode($json, true);
            return redirect($json_data['data'][0]['pc']);
        } elseif ($gamekind == 5 or $gamekind == 30 or $gamekind == 38) {
            return redirect($json_data['data'][0]['html5']);
        } elseif ($gamekind == 12 or $gamekind == 31 or $gamekind == 66 or $gamekind == 73 or $gamekind == 76 or $gamekind == 107 or $gamekind == 109) {
            return redirect($json_data['data'][0]['pc']);
        } else {
            return redirect('/')->with('Fail', $json_data['data']['Message']);
        }

    }

}
