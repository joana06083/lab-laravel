<?php

namespace App\Jobs;

use App\Models\ArticleInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// use Illuminate\Support\Facades\Redis;

class artInsertList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userNo;
    protected $count;
    protected $others;

    /**
     * Create a new job instance.
     * @param  \App\Models\ArticleInfo  $artdetails
     * @return void
     */
    public function __construct($userNo, $count, $others)
    {
        printf("created a job!");
        $this->userNo = $userNo;
        $this->count = $count;
        $this->others = $others;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $arrData = [];
        for ($i = 1; $i <= $this->count; $i++) {
            $articleNo = date('YmdHis', time()) . $this->others . $i;
            $articleTitle = $this->userNo . '寫入資料第' . $i . '筆';
            $articleContent = $this->userNo . '寫入資料測試內容' . $i;
            $userNo = $this->userNo;
            array_push($arrData, [
                'articleNo' => $articleNo,
                'articleTitle' => $articleTitle,
                'articleContent' => $articleContent,
                'userNo' => $userNo]
            );
        }

        ArticleInfo::insert($arrData);
        printf("Insert into article " . $this->count . " success!");

    }
}
