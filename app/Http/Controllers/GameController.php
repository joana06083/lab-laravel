<?php

namespace App\Http\Controllers;

use App\ExternalApi\Game\GetUrl;
use App\Traits\ApiTraits;
use Illuminate\Http\Request;

class GameController extends Controller
{
    use ApiTraits;

    //進入遊戲
    public function GameIndex(Request $request)
    {
        $get_url = new GetUrl;
        $json_data = $get_url->GameUrlBy($request);

        if (isset($json_data->data->Message)) {
            return redirect('/')->with('Fail', $json_data->data->Message);
        }
        return match($request->gamekind) {
            '5', '30', '38' => redirect($json_data->data[0]->html5),
        default=> redirect($json_data->data[0]->pc),
        };
    }

}
