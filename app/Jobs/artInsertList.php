<?php

namespace App\Jobs;

use app\Models\ArticleInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// use Illuminate\Support\Facades\Redis;

class artInsertList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $artdetails;
    /**
     * Create a new job instance.
     * @param  \App\Models\ArticleInfo  $artdetails
     * @return void
     */
    public function __construct(ArticleInfo $artdetails)
    {
        //
        $this->artdetails = $artdetails->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //redis::throttle('key')->block(0)->allow(1)->every(5)->then(function () {
        //處理任務
        printf('ArtInserList job ...');
        ArticleInfo::insert([
            'articleNo' => date('YmdHis', time()),
            'articleTitle' => '12345666',
            'articleContent' => '12345666',
            'userNo' => 'admin',

        ]);

        // artInsertList::dispatch()->onQueue('insertArt');
        return response('artdetails sent successfully');
        // }, function () {

        //     return $this->release(5);
        // });

    }
}
