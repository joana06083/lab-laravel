<?php

namespace App\Http\Controllers;

use App\ExternalApi\Game\GetUrl;
use Illuminate\Http\Request;

class GameController extends Controller
{
    //進入遊戲
    public function Index(Request $request)
    {
        $get_url = new GetUrl;
        $request_data = [
            'gamekind' => $request->gamekind,
            'sessionid' => $request->sessionid,
            'gametype' => $request->gametype,
            'lang' => $request->lang,
        ];

        $json_data = $get_url->GameUrlBy($request_data);

        return match($request->gamekind) {
            '5', '30', '38' => redirect($json_data->data[0]->html5),
        default=> redirect($json_data->data[0]->pc),
        };
    }

}
