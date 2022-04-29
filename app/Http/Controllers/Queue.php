<?php

namespace App\Http\Controllers;

use APP\Jobs\artInsertList;
use Illuminate\Http\Request;

class Queue extends Controller
{
    //執行新增資料
    public function runServerInsertList(Request $request)
    {

        $artdetails['articleNo'] = '20220429160630';
        $artdetails['articleTitle'] = '12345666';
        $artdetails['articleContent'] = '123456';
        $artdetails['userNo'] = 'admin';

        artInsertList::dispatch($artdetails)->onQueue('processing');

        return response('artdetails sent successfully');

    }

}
