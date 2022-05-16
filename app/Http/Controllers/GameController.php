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

        if (empty($gamekind) == true or empty($lang) == true or empty($sessionid) == true or empty($gametype) == true) {
            return redirect('/')->with('Fail', 'Parameter is missing!');
        } else {
            return redirect($this->GameUrl($gamekind, $lang, $sessionid, $gametype));
        }

    }

}
