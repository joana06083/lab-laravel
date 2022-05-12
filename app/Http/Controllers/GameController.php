<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    //進入遊戲
    public function GameIndex(Request $request)
    {
        //call CreateSession api
        $website = 'bbinbgp';

        ['gamekind' => $gamekind, 'lang' => $lang, 'SessionID' => $sessionid, 'GameType' => $gametype] = $request;
        if ($gamekind == "" or $lang == "" or $sessionid == "" or $gametype = "") {
            return redirect('/')->with('Fail', 'Ｐarameter is missing!');
        }
        date_default_timezone_set("America/New_York");
        $Date = date("Ymd");
        $KeyB = '09fJb0vYem';
        $key = "11111111" . md5($website . $KeyB . $Date, false) . "2222";
        $url = "http://apollo.vir777.net/app/WebService/JSON/display.php/GameUrlBy" . $gamekind . "?website=" . $website . "&lang=" . $lang .
            "&sessionid=" . $sessionid . "&gametype=" . $gametype . "&key=" . $key;
        //Response
        $json = file_get_contents($url);
        $json_data = json_decode($json, true);
        return redirect($json_data['data'][0]['html5']);
    }
}
